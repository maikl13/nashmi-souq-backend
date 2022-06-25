<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Channels\TwilioSMSChannel;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrderRecieved extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail', TwilioSMSChannel::class];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject($this->order->store->store_name . ' | لديك طلب جديد')
                    ->line('لديك طلب جديد بقيمة '. $this->order->price . ' '. $this->order->currency->symbol . ' من المشتري "'. $this->order->buyer_name. '"')
                    ->action('معاينة الطلبات', route('orders', $this->order->store->store_slug));
    }

    public function toMessage($notifiable)
    {
        return [
            'مرحبا بك!', 
            'لديك طلب جديد بقيمة '. $this->order->price . ' '. $this->order->currency->symbol . ' من المشتري "'. $this->order->buyer_name. '"',
            ' ',
            'معاينة الطلبات',
            route('orders', $this->order->store->store_slug),
            ' ',
            'مع التحية,',
            setting('website_name')
        ];
    }

    public function toTwilioSMS($notifiable)
    {
        return $this->toMessage($notifiable);
    }

    public function toChatApiWhatsApp($notifiable)
    {
        return $this->toMessage($notifiable);
    }
}
