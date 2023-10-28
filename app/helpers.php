<?php

use App\Models\Order;
use Carbon\Carbon;

if (! function_exists('changeOrderStatus')) {
    function changeOrderStatus($road_id,$status) {
        Order::where('road_id',$road_id)->update([ 'status' => $status]);
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
            1 => trans("Pending") ,
            2 => trans("On Progress") ,
            3 => trans("Finished") ,
            4 => trans("Canceled") ,
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