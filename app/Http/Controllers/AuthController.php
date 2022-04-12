<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use App\Http\Requests\EmailVerificationRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    

    
    /**
     * Sign Up a new user
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signup(Request $request)
    {
        //validate request
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ]);
        //Check for any validation voilations
        if($validator->fails())
        {
            //Return validation failed response
            return response()->json(['resMsg' => $validator->messages()->all(),'resCode' => Response::HTTP_BAD_REQUEST]);
        }
        //Monitor for errors and exceptions
        try {
            //Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                ]
            );
            //Check if user created
            if($user)
            {
                //Send email verification link
                if($this->sendEmailNotification($request))
                {
                return response()->json(['resMsg' => "User signed up and verification link sent to the provided email.", "resCode" => Response::HTTP_CREATED]);
                }
            }
            return response()->json(['resMsg' => "Signup failed.", "resCode" => Response::HTTP_I_AM_A_TEAPOT]);
        } catch (\Throwable $th) {
            //throw $th;
            //Return exception message
            return response()->json(['resMsg' => $th->getMessage(), "resCode" => Response::HTTP_INTERNAL_SERVER_ERROR]);
        }
        
        
    }
   
    /**
     * Mark the user's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyEmail(EmailVerificationRequest $request)
    {
        //Get user
        $user = User::find($request->route('id'));
        if ($user->hasVerifiedEmail()) {
            return response()->json(['resMsg' => 'Email is already verified', 'resCode' => Response::HTTP_OK]);
        }
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }
        
        return response()->json(['resMsg' => 'Email verified', 'resCode' => Response::HTTP_OK]);
    }
    /**
     * Send a new email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendEmailNotification(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended();
        }

        $user->sendEmailVerificationNotification();

        return true;
    }
}
