<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PaymentIntentsRequest;
use App\Http\Requests\Api\PaymentInfoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public $token = "sk_test_51NyYgHHUrt9Sftxct4dGfBIYxXUTLkHsjmpePvj7zvsBTloUOK2xsh16mfD8WmXVXlIQhqHj3U7BXPg5sE2GWTLz00EjLqVsD2";
   
    public function paymentIntents(PaymentIntentsRequest $request) {
        
        $body = $request->validated();

        $url = "https://api.stripe.com/v1/payment_intents";
        
        $response = Http::withToken($this->token)->asForm()->post($url,$body);

        return $response->json();
    }

    public function paymentInfo(PaymentInfoRequest $request) {
        
        $body = $request->validated();
        
        $url = "https://api.stripe.com/v1/charges";

        $response = Http::withToken($this->token)->get($url,$body);

        return $response->json();
    }
}