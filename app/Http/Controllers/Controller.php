<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

/*
|--------------------------------------------------------------------------
| Json Format For All Api's
|--------------------------------------------------------------------------
*/
public function sendResponse($success, $result, $message, $code)
{
    $response = [
        'success' => $success,
        'message' => $message,
        'data' => $result,
        'code' => $code,
    ];

   
    return response()->json($response, $code);
}
/*
|--------------------------------------------------------------------------
| Json Format For Pagination
|--------------------------------------------------------------------------
*/
public function paginationResponse($success, $result, $message, $code)
{
    $response = collect($result);

    $response->prepend($message,"message"); // add item in first
    $response->prepend($success,"success"); // add item in first

    $response->put('code', $code); // add item in last

    return response()->json($response, $code);
}

/*
|--------------------------------------------------------------------------
| Json Format2 For Specific Api's
|--------------------------------------------------------------------------
*/
public function sendApiResponse($success, $result, $message, $code)
{
    $key =  key($result); 
    $value = $result[$key];
    $response = [
        'success' => $success,
        'message' => $message,
        $key => $value,
        'code' => $code,
    ];

    return response()->json($response, $code);
}
// End Function
}
