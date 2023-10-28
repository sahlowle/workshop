<?php

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;

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

Route::get('restart-system-from-scratch',function() {
    Artisan::call('optimize:clear');
    
    $tables = Schema::getAllTables();

    $keysFromObject = array_keys(get_object_vars($tables[0]));

    $keyName = $keysFromObject[0];


    // dd($keysFromObject);


    foreach ($tables as $key => $table) {
        $name = $table->$keyName;

        DB::table($name)->truncate();
    }

    User::create([
        'name' => 'Admin',
        'email' => 'admin@admin.com',
        'password' => '123admin',
        'type' => 1,
    ]);

    $file = new Filesystem;
    $file->cleanDirectory(public_path('uploads'));

    Artisan::call('optimize:clear');

    return "<h1> System Restarted Successful </h1>";
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



Auth::routes();
