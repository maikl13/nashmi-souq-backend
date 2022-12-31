<?php

namespace App\Notifications;

use App\Channels\TwilioSMSChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class OTPGenerated extends Notification implements ShouldQueue
{
    use Queueable;

    private $reset;

    public function __construct($reset)
    {
        $this->reset = $reset;
    }

    public function via($notifiable)
    {
        return [TwilioSMSChannel::class];
    }

    public function toMessage($notifiable)
    {
        $msg[] = 'مرحبا بك!';
        $msg[] = ' ';

        if ($this->reset) {
            $msg[] = 'كلمة المرور المؤقتة لحسابك هي '.$notifiable->otp;
            $msg[] = 'إذا لم تقم بطلب إعادة تعيين كلمة المرور، فلا يلزم إتخاذ أي إجراء';
        } else {
            $msg[] = 'يسعدنا إنضمامك لموقعنا';
            $msg[] = 'كلمة المرور المؤقتة لحسابك هي '.$notifiable->otp;
            $msg[] = 'إذا لم تقم بإنشاء حساب ، فلا يلزم اتخاذ أي إجراء';
        }

        $msg[] = ' ';
        $msg[] = 'مع التحية,';
        $msg[] = setting('website_name');

        return $msg;
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
