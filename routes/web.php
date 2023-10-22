<?php

use App\Http\Controllers\Admin\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\Schema;
// use Illuminate\Database\Schema\Blueprint;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('config',function() {
    // Schema::table('customers', function (Blueprint $table) {
    //     $table->string('postal_code',10)->nullable()->after('zone_area');
    //     $table->string('city',50)->nullable()->after('postal_code');
    // });
});

Route::get('optimize',function() {
    
    Artisan::call('optimize');
    return "<h1> Cached Successful </h1>";
    
});

Route::get('gen-password/{pass}',function($pass) {
    
    // User::first()->update(['password' => $pass]);

    return Hash::make($pass);
    
});

$controller_path = 'App\Http\Controllers';

Route::redirect('/', '/admin');

// Main Page Route
// Route::get('/', 'App\Http\Controllers\dashboard\Analytics@index')->name('dashboard-analytics');



Auth::routes();

// Route::get('/home',$controller_path . '\dashboard\Analytics@index')->name('home');


// Route::resource('/users', [UserController::class]);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
