<?php

use App\Http\Controllers\Api\ApiAdminController;
use App\Http\Controllers\Api\ApiCustomerController;
use App\Http\Controllers\Api\ApiDriverController;
use App\Http\Controllers\Api\ApiOrderController;
use App\Http\Controllers\Api\ApiRoadController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PaymentController;
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
Route::post('driver-login',[AuthController::class,'driverLogin']);

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
    Route::post('customers/active/{id}',[ApiCustomerController::class,'restore']);

    
});

/*
|--------------------------------------------------------------------------
|  Routes for all
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum'])->group(function () {
    /* |------ orders routes ---------| */
    Route::apiResource('orders',ApiOrderController::class);

    /* |------ add drop Off order routes ---------| */
    Route::post('orders/add-drop-off',[ApiOrderController::class,'storeDropOffOrder']);

    /* |------ orders files routes ---------| */
    Route::post('orders/add-files/{id}',[ApiOrderController::class,'addFiles']);
    Route::delete('orders/delete-files/{id}',[ApiOrderController::class,'deleteOrderFile']);
    Route::post('orders/send-invoice/{id}',[ApiOrderController::class,'sendInvoice']);
    Route::get('orders/available/time',[ApiOrderController::class,'getAvailableTime']);

    /* |------ payment file routes ---------| */
    Route::post('orders/add-payment-file/{id}',[ApiOrderController::class,'addPaymentFile']);

    /* |------ roads routes ---------| */
    Route::apiResource('roads',ApiRoadController::class);

    /* |------ update profile routes ---------| */
    Route::post('update-profile',[AuthController::class,'updateProfile']);
    
    /* |------ current user routes ---------| */
    Route::get('current-user',[AuthController::class,'currentUser']);

    /* |------ update driver location user ---------| */
    Route::post('drivers/update-location',[ApiDriverController::class,'updateLocation']);

    /* |------  stripe payment routes ---------| */
    Route::post('payment-intents',[PaymentController::class,'paymentIntents']);
    Route::get('payment-info',[PaymentController::class,'paymentInfo']);

    /* |------  logout routes ---------| */
    Route::post('logout',[AuthController::class,'logout']);

});

Route::get('orders/pdf/{id}',[ApiOrderController::class,'printPdf'])->name('orders.pdf');


