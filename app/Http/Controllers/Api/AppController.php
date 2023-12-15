<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Guarantee;
use App\Models\Question;
use Illuminate\Http\Request;

class AppController extends Controller
{
    
    /*
    |--------------------------------------------------------------------------
    | get devices list
    |--------------------------------------------------------------------------
    */
    public function devices(){
        $data = Device::all();    
        return $this->sendResponse(true,$data,trans('Successful Retrieved'),200);
    }

    /*
    |--------------------------------------------------------------------------
    | get questions list
    |--------------------------------------------------------------------------
    */
    public function questions(){
        $data = Question::all();    
        return $this->sendResponse(true,$data,trans('Successful Retrieved'),200);
    }

    /*
    |--------------------------------------------------------------------------
    | get guarantees list
    |--------------------------------------------------------------------------
    */
    public function guarantees(){
        $data = Guarantee::all();    
        return $this->sendResponse(true,$data,trans('Successful Retrieved'),200);
    }
}