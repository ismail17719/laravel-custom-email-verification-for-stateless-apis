<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Response;

class EnsureEmailIsVerified
{
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $redirectToRoute
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|null
     */
    public function handle($request, Closure $next, $redirectToRoute = null)
    {
        //Get user model
        $user = User::where('email', $request->email)->first();
        //Check if user has signed up
        //If user is not signed up, let the login action handle the request
        if($user)
        {
            //Check if the email is verified
            if ($user instanceof MustVerifyEmail &&
                ! $user->hasVerifiedEmail()) {
                return response()->json(["resMsg" => "Your email address is not verified. Please verify you email address to continue.","resCode" => Response::HTTP_FORBIDDEN]);
            }
        }
        
        return $next($request);
    }
}
