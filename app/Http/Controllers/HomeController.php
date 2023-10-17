<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Road;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['routes_count'] = Road::count();
        $data['orders_count'] = Order::count();
        $data['customers_count'] = Customer::count();
        $data['drivers_count'] = User::drivers()->count();
        $data['sales'] = Order::sum('amount');

        // return $data;
        return view('content.dashboard.dashboards-analytics',$data);
    }

    public function changeLang($locale)
    {
        app()->setLocale($locale);
        
        session()->put('locale', $locale);

        return redirect()->back();
    }
}
