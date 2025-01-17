<?php

use App\Http\Controllers\Admin\DataBaseBackupController;
use App\Models\Device;
use App\Models\Guarantee;
use App\Models\Order;
use App\Models\Question;
use App\Models\Road;
use App\Models\User;
use App\Services\TimeSlot;
use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

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

Route::get('backups',[DataBaseBackupController::class,'store']);

Route::get('restart-system-from-scratch',function() {
    Artisan::call('optimize:clear');
    
    $tables = Schema::getAllTables();

    $keysFromObject = array_keys(get_object_vars($tables[0]));

    $keyName = $keysFromObject[0];


    // dd($keysFromObject);


    foreach ($tables as $key => $table) {
        $name = $table->$keyName;
        if ($name == "telescope_entries" 
        || $name == "telescope_entries_tags" 
        ||$name == "telescope_monitoring"
        ||$name == "questions"
        ||$name == "guarantees"
        ||$name == "devices"
        ) {
            
        } else{
            DB::table($name)->truncate();
        }
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

Route::get('optimize/clear',function() {

    Artisan::call('optimize:clear');
    return "<h1> Cached Successful </h1>";
    
});

Route::get('pdf',function() {

    $order = Order::has('road')->where('type',1)->first();
    
    $order->load(['customer','driver','files','customer','items','devices','questions','payments']);

    $order->driver = $order->road->driver;
    
    $data['order'] = $order;

    $data['devices'] = Device::all();
    $data['questions'] = Question::all();
    $data['guarantees'] = Guarantee::all();
    
    return view('reports.pickup',$data);
    
});

Route::get('wael/pdf',function() {

    $order = Order::has('road')->where('type',1)->first();
    
    $order->load(['customer','driver','files','customer','items','devices','questions','payments']);

    $order->driver = $order->road->driver;
    
    $data['order'] = $order;

    $data['devices'] = Device::all();
    $data['questions'] = Question::all();
    $data['guarantees'] = Guarantee::all();

    $pdf = Pdf::loadView('pdf',$data);
        
    return $pdf->stream('invoice.pdf');
    
});


Route::get('edit/table',function() {
    $order = Order::find(3)->load(['road.driver','driver','customer','items']);

    $order->driver = $order->road->driver;

    // $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
    // ->loadView('reports.index', compact('order'));

    // return $pdf->stream('inv.pdf');

    // $html = view('reports.route',compact('road'));

    // $pdf = Pdf::loadHtml($html);
    // $pdf = Pdf::loadView('reports.route',['road'=> $road]);
        
    // return $pdf->download('inv.pdf');

    return view('reports.index',compact('order'));

    return "<h1> Added Successful </h1>";
    
});


Route::redirect('/', '/admin');

Auth::routes();
