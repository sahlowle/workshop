<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class FirebaseService
{
    public static function sendNotification($title,$body,Collection $tokens)
    {
        $SERVER_API_KEY = 'AAAAT11oKJM:APA91bGbb1Id61Ac-6ieFmQULcTHT7aH2Jl_FBf1voIZxgHIZ6A8cQrKTLLnKJFAFx0E7fVHnv_ahLPqKsNNj00VPX05R4apybqctZX5SQ32rfFKZn6DaY1nxUdG1FAWMGtmXJXISPIt';

        $headers = [

            'Authorization' => 'key=' . $SERVER_API_KEY,

            'Content-Type'=>'application/json',

        ];

        //initial request
        $http = Http::withHeaders($headers);
        
        //chunk tokens
        foreach ($tokens->chunk(100) as $firebaseToken){
            $data = [

                "registration_ids" => $firebaseToken,
    
                "notification" => [
    
                    "title" => $title,
    
                    "body" => $body,  
    
                ]
    
            ];

            $response = $http->post('https://fcm.googleapis.com/fcm/send',$data);

            return $response->object();
        }

        
    }
}