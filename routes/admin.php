<?php

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\RoadController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Driver\Driver;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "admin" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('roads', RoadController::class);
Route::resource('orders', OrderController::class);
Route::resource('users', UserController::class);
Route::resource('drivers', DriverController::class);
Route::resource('customers', CustomerController::class);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/change-lang/{lang}', [HomeController::class, 'changeLang'])->name('change-lang');
