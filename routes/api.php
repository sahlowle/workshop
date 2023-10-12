<?php

use App\Http\Controllers\Api\ApiAdminController;
use App\Http\Controllers\Api\ApiCustomerController;
use App\Http\Controllers\Api\ApiDriverController;
use App\Http\Controllers\Api\ApiOrderController;
use App\Http\Controllers\Api\ApiRoadController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API DOCS:
|--------------------------------------------------------------------------
| https://documenter.getpostman.com/view/4438633/2s9YJaYj19
|--------------------------------------------------------------------------
*/


/* |------ Login Routes ---------| */
Route::post('login',[AuthController::class,'login']);

/* |------ Login Routes ---------| */
Route::post('forget-password',[AuthController::class,'forgerPassword']);

/*
|--------------------------------------------------------------------------
| Application Routes for admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum','role:admin'])->group(function () {
    /* |------ admins routes ---------| */
    Route::apiResource('admins',ApiAdminController::class);

    /* |------ drivers routes ---------| */
    Route::apiResource('drivers',ApiDriverController::class);

    /* |------ customers routes ---------| */
    Route::apiResource('customers',ApiCustomerController::class);

    
});

/*
|--------------------------------------------------------------------------
|  Routes for all
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum'])->group(function () {
    /* |------ orders routes ---------| */
    Route::apiResource('orders',ApiOrderController::class);

    /* |------ orders files routes ---------| */
    Route::post('orders/add-files/{id}',[ApiOrderController::class,'addFiles']);
    Route::delete('orders/delete-files/{id}',[ApiOrderController::class,'deleteOrderFile']);

    /* |------ roads routes ---------| */
    Route::apiResource('roads',ApiRoadController::class);

    /* |------ update profile routes ---------| */
    Route::post('update-profile',[AuthController::class,'updateProfile']);

});


