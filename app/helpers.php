<?php

if (! function_exists('loginBackground')) {
    function loginBackground() {
        return asset('assets/img/backgrounds/login-background.png');
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