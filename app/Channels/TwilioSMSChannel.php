<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Twilio\Rest\Client;

class TwilioSMSChannel
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

        foreach ($notification->toTwilioSMS($notifiable) as $line) {
            $message .= $line."\r\n";
        }

        $twilio = new Client(config('services.twilio.sid'), config('services.twilio.token'));

        $twilio->messages->create($notifiable->phone, [
            'messagingServiceSid' => config('services.twilio.messaging_service_sid'),
            'body' => $message,
        ]);
    }
}
