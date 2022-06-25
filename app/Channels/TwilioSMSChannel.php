<?php

namespace App\Channels;

use Twilio\Rest\Client;
use Illuminate\Notifications\Notification;

class TwilioSMSChannel
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
        
        foreach ($notification->toTwilioSMS($notifiable) as $line)
            $message .= $line . "\r\n";

        $twilio = new Client(config('services.twilio.sid'), config('services.twilio.token'));
 
        $twilio->messages->create($notifiable->phone, [
            "messagingServiceSid" => config('services.twilio.messaging_service_sid'),      
            "body" => $message, 
        ]); 
    }
}