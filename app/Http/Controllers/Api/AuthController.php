<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ForgerPasswordRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\UpdateProfileRequest;
use App\Models\User;
use App\Notifications\NewPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login User
    |--------------------------------------------------------------------------
    */
    public function Login(LoginRequest $request)
    {
        if(Auth::attempt($request->only(['email', 'password']))){
            
            $user = Auth::user();

            $data['user'] = $user ;
            $data["token"] = $user->createToken("API-TOKEN")->plainTextToken;

            if ($request->filled('fcm_token')) {
                $user->update($request->only(['fcm_token','device_type']));
            }

            $message = trans('Successful Login');
            return $this->sendResponse(true ,$data ,$message,200);

        }

        $message = trans('Email & Password does not match with our record.');

        return $this->sendResponse(false,[],$message ,401);    
    }
    // End Function

    /*
    |--------------------------------------------------------------------------
    | Update Profile
    |--------------------------------------------------------------------------
    */
    public function updateProfile(UpdateProfileRequest $request)
    {
        $data = $request->validated();

        $user = $request->user();

        $user->update($data);

        $message = trans('Successful Successful Updated');

        return $this->sendResponse(true,$user,$message,200);
    }

    /*
    |--------------------------------------------------------------------------
    |  Forger Password
    |--------------------------------------------------------------------------
    */
    public function forgerPassword(ForgerPasswordRequest $request)
    {
        $user = User::where('email',$request->email)->first();

        if (is_null($user)) {
            return $this->sendResponse(false,[],trans('Email Not Found'),404);
        }

        $password = Str::random(8);

        $user->update([ 'password' => $password ]);

        $user->notify(new NewPassword($password));

        $message = trans('New Password Successful Send');

        return $this->sendResponse(true,$user,$message,200);
    }

    /*
    |--------------------------------------------------------------------------
    | Current User Login
    |--------------------------------------------------------------------------
    */
    public function currentUser(Request $request)
    {
        $user = $request->user();

        $message = trans('Successful Retrieved');

        return $this->sendResponse(true,$user,$message,200);
    }
}

