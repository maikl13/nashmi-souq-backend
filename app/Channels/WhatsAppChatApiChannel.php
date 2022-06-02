<?php

namespace App\Channels;

use Illuminate\Support\Facades\Http;
use Illuminate\Notifications\Notification;

class WhatsAppChatApiChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = '';

        foreach ($notification->toWhatsApp($notifiable) as $line)
            $message .= $line . PHP_EOL;

        Http::post(env('CHAT_API_URL'), [
            'body' => $message,
            'phone' => $notifiable->phone,
        ]);
    }
}