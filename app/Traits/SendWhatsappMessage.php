<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait SendWhatsappMessage {

    public function send_whatsapp_message($phone, $msg)
    {
        $data = [
            'phone' => str_replace('+', '', $phone), // Receivers phone
            'body' => $msg //message
        ];
        $json = json_encode($data); // Encode data to JSON
        // URL for request POST /message
        $url = env('CHAT_API_URL');
        // Make a POST request
        $options = stream_context_create(['http' => [
                'method'  => 'POST',
                'header'  => 'Content-type: application/json',
                'content' => $json
            ]
        ]);
        // Send a request
        $result = file_get_contents($url, false, $options);
    }
}