<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

trait SendWhatsappMessage {

    public function send_whatsapp_message($phone, $msg)
    {
        $response = Http::post(env('CHAT_API_MESSAGE_URL'), [
            'phone' => $phone,
            'body' => $msg,
        ]);
    }

    public function send_whatsapp_template($phone, $template, $params)
    {
        $response = Http::post(env('CHAT_API_TEMPLATE_URL'), [
            'namespace' => env('CHAT_API_NAMESPACE'),
            'template' => $template,
            'language' => [ "policy" => "deterministic", "code" => "ar" ],
            'phone' => $phone,
            'params' => $params
        ]);
    }
}