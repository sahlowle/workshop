<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Login Routes
|--------------------------------------------------------------------------
*/
Route::post('login',[AuthController::class,'login']);

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum'])->group(function () {
    //admins routes
    Route::apiResource('admins',ApiAdminController::class);

    //drivers routes
    Route::apiResource('drivers',ApiDriverController::class);
});


