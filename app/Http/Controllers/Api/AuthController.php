<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            
            $data['user'] = $user = Auth::user();

            $data["token"] = $user->createToken("API-TOKEN")->plainTextToken;

            $message = trans('Successful Login');

            return $this->sendResponse(true ,$data ,$message,200);

        }

        $message = trans('Email & Password does not match with our record.');

        return $this->sendResponse(false,[],$message ,401);    
    }
    // End Function

    /*
    |--------------------------------------------------------------------------
    | Check Login
    |--------------------------------------------------------------------------
    */
    public function checkLogin(Request $request)
    {
        $user = $request->user();

        $message = trans('Successful Retrieved');

        return $this->sendResponse(true,$user,$message,200);
    }
}

