<?php

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\RoadController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use App\Models\Order;
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

Route::resource('roads', RoadController::class)->middleware('prevent-back-history');
Route::resource('orders', OrderController::class)->middleware('prevent-back-history');
Route::resource('users', UserController::class)->except('show')->middleware('prevent-back-history');
Route::resource('drivers', DriverController::class)->except('show')->middleware('prevent-back-history');
Route::resource('customers', CustomerController::class)->middleware('prevent-back-history');

 /* |------ add drop Off order routes ---------| */
 Route::get('orders/create/drop/off',[OrderController::class,'createDropOffOrder'])->name('orders.drop.create')->middleware('prevent-back-history');
 Route::post('orders/store/drop/off',[OrderController::class,'storeDropOffOrder'])->name('orders.drop.store')->middleware('prevent-back-history');
 Route::post('orders/add/drop/off/{id}',[OrderController::class,'addDropOffOrder'])->name('orders.drop.add')->middleware('prevent-back-history');

//today roads
Route::get('roads/only/today', [RoadController::class, 'today'])->name('roads.today')->middleware('prevent-back-history');

//today orders
Route::get('orders/only/today', [OrderController::class, 'today'])->name('orders.today')->middleware('prevent-back-history');

//today orders
Route::get('orders/print/pdf/{id}', [OrderController::class, 'printPdf'])->name('orders.print.pdf')->middleware('prevent-back-history');
Route::get('orders/send/invoice/{id}', [OrderController::class, 'sendInvoice'])->name('orders.send.invoice')->middleware('prevent-back-history');

//restore customer
Route::get('orders/remind/customers', [OrderController::class, 'unpaid'])->name('orders.unpaid')->middleware('prevent-back-history');

//restore customer
Route::get('drivers/map/location', [DriverController::class, 'mapLocation'])->name('drivers.map-location')->middleware('prevent-back-history');

//restore customer
Route::get('customers/active/{id}', [CustomerController::class, 'reStore'])->name('customers.active')->middleware('prevent-back-history');

//restore customer
Route::get('drivers/active/{id}', [DriverController::class, 'reStore'])->name('drivers.active')->middleware('prevent-back-history');


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->middleware('prevent-back-history')->name('index');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('prevent-back-history')->name('home');

Route::get('/change-lang/{lang}', [HomeController::class, 'changeLang'])->name('change-lang')->middleware('prevent-back-history');

Route::view('invoice','emails.invoice',['order'=> Order::first()]);


Route::post('/orders/add-item/{id}', [OrderController::class, 'addItem'])->name('orders.add-item')->middleware('prevent-back-history');
Route::delete('/orders/delete-item/{id}', [OrderController::class, 'deleteItem'])->name('orders.delete-item')->middleware('prevent-back-history');

Route::post('/orders/add-payment/{id}', [OrderController::class, 'addPayment'])->name('orders.add-payment')->middleware('prevent-back-history');
