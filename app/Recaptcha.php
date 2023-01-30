<?php

namespace App;
use GuzzleHttp\Client;
use GuzzleHttp;

class Recaptcha {

    public static function verify($token){
        $secret = env('RECAPTCHA_SECRET');
        
        $client = new Client();
        $data = [
            'secret' => $secret,
            'response' => $token
        ];

        $url = 'https://www.google.com/recaptcha/api/siteverify'; 
        
       /*  $response = $client->post($url,[
            'form_params' => $data
        ]); */

        $response = $client->request('POST',$url,[
            'form_params'=>$data
        ]);

        return json_decode($response->getBody(),true);
    }
}