<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PaymentIntentsRequest;
use App\Http\Requests\Api\UpdateAdminRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public $token = "sk_test_51NyYgHHUrt9Sftxct4dGfBIYxXUTLkHsjmpePvj7zvsBTloUOK2xsh16mfD8WmXVXlIQhqHj3U7BXPg5sE2GWTLz00EjLqVsD2";
   
    public function paymentIntents(PaymentIntentsRequest $request) {
        
        $body = $request->validated();

        $response = Http::withToken($this->token)->asForm()->post('https://api.stripe.com/v1/payment_intents',$body);

        return $response->json();
    }
}