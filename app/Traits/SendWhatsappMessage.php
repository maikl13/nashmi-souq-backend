<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

trait SendWhatsappMessage {

    public function send_whatsapp_message($phone, $msg)
    {
        $response = Http::post(env('CHAT_API_URL'), [
            'phone' => $phone,
            'body' => $msg,
        ]);
    }
}