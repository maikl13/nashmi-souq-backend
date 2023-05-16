<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class ChatApiWhatsAppChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = '';

        foreach ($notification->toChatApiWhatsApp($notifiable) as $line) {
            $message .= $line.PHP_EOL;
        }

        Http::post(env('CHAT_API_MESSAGE_URL'), [
            'body' => $message,
            'phone' => $notifiable->phone,
        ]);
    }
}
