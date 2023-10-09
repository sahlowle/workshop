<?php

use App\Http\Controllers\Api\ApiAdminController;
use App\Http\Controllers\Api\ApiCustomerController;
use App\Http\Controllers\Api\ApiDriverController;
use App\Http\Controllers\Api\ApiOrderController;
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


/*
|--------------------------------------------------------------------------
| Login Routes
|--------------------------------------------------------------------------
*/
Route::post('login',[AuthController::class,'login']);

/*
|--------------------------------------------------------------------------
| Application Routes for admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum','role:admin'])->group(function () {
    //admins routes
    Route::apiResource('admins',ApiAdminController::class);

    //drivers routes
    Route::apiResource('drivers',ApiDriverController::class);

    //customers routes
    Route::apiResource('customers',ApiCustomerController::class);

    //orders routes
    Route::apiResource('orders',ApiOrderController::class)->except([
        'show'
    ]);
});

/*
|--------------------------------------------------------------------------
|  Routes for all
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum'])->group(function () {
    //orders files
    Route::post('orders/add-files/{id}',[ApiOrderController::class,'addFiles']);
    Route::post('orders/delete-files/{id}',[ApiOrderController::class,'deleteOrderFile']);

});


