<?php

namespace App\Channels;

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
        $message_lines = $notification->toWhatsApp($notifiable);
        $phone = $notifiable->phone;

        foreach ($message_lines as $line) {
            $message .= $line . PHP_EOL;
        }

        $data = [
            'phone' => str_replace('+', '', $phone), // Receivers phone
            'body' => $message //message
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