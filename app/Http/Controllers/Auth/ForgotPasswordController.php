<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\NewPassword;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );

        $user = User::where('email',$request->email)->first();

        if (is_null($user)) {
            return $this->sendResetLinkFailedResponse($request, $response);
        }

        $password = Str::random(8);

        $user->update([ 'password' => $password ]);

        $user->notify(new NewPassword($password));


        return $this->sendResetLinkResponse($request, $response);
    }

    use SendsPasswordResetEmails;
}
