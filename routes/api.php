<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Login route
//Login is attempted here for quick understanding
Route::post('/login', function (Request $request) {
    if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
    {
        return response()->json(['resMsg' => "Login successful", 'resCode' => Response::HTTP_OK]);
    }
    return response()->json(['resMsg' => "Login failed", 'resCode' => Response::HTTP_FORBIDDEN]);
})->middleware('verified');

//User signup route
Route::post('/signup', [AuthController::class, 'signup']);


//Email verification route
Route::get('verify-email/{id}/{hash}', [AuthController::class, 'verifyEmail'])
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verification.verify');
// //Email verification sending route
// Route::post('email/verification-notification', [AuthController::class, 'sendEmailNotification'])
//             ->middleware('throttle:6,1')
//             ->name('verification.send');