<?php

use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

if (! function_exists('getAvailableDrivers')) {
    function getAvailableDrivers() {
        $drivers = User::drivers();
        
        $first_drivers =  $drivers->whereDoesntHave('roads', function (Builder $query) {
            $query->where('status', '!=', 3);
        })->get();

        if ($first_drivers->isNotEmpty()) {
            return $first_drivers->pluck('id');
        }

        return Order::select('driver_id', DB::raw('count(*) as total'))
        ->whereNotNull('driver_id')
        ->groupBy('driver_id')
        ->orderBy('total')->get()
        ->makeHidden([
            'pdf_link','status_name','type_name','status_color','payment_method'
        ])->get()->pluck('driver_id');
    }
}

if (! function_exists('changeOrderStatus')) {
    function changeOrderStatus($road_id,$status) {
        Order::where('road_id',$road_id)
        ->where('status','!=',3)
        ->update([ 'status' => $status]);
    }
}

if (! function_exists('loginBackground')) {
    function loginBackground() {
        return asset('assets/img/backgrounds/global_bg.png');
    }
}

if (! function_exists('orderStatus')) {
    function orderStatus() {
        return [
            "" => trans("Select") ,
            1 => trans("Pending"),
            2 => trans("Assigned"),
            3 => trans("Under maintenance"),
            4 => trans("Finished"),
            0 => trans("Canceled"),
        ];
    }
}

if (! function_exists('referenceNo')) {
    function referenceNo($prefix) {
        // return $prefix.'-' . date("Ymd") . '-' . date("his").'-';
        return $prefix.'-'.str()->upper(uniqid());
    }
}


if (! function_exists('greeting')) {
    function greeting()
    {
        $hour = Carbon::now()->hour;
        // $hour = $this->format('H');
        if ($hour < 12) {
            return trans('Good morning');
        }
        if ($hour < 17) {
            return trans('Good afternoon');
        }
        return trans('Good evening');
    }
}