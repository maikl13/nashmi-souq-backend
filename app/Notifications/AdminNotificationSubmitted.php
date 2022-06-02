<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Channels\WhatsAppChatApiChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminNotificationSubmitted extends Notification implements ShouldQueue
{
    use Queueable;

    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $msg = (new MailMessage)->subject(setting('website_name').' | إشعار جديد');
        foreach (explode(PHP_EOL, $this->message) as $line) {
            $msg = $msg->line($line);
        }
        return $msg;
    }

    public function toWhatsApp($notifiable)
    {
        $msg = [];
        $msg[] = 'مرحبا بك!';
        $msg[] = ' ';
        foreach (explode(PHP_EOL, $this->message) as $line) {
            $msg[] = $line;
        }
        $msg[] = ' ';
        $msg[] = 'مع التحية,';
        $msg[] = setting('website_name');

        return $msg;
    }
}
