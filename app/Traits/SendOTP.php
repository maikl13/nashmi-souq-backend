<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait SendOTP {
    public function generate_otp()
    {
        $this->otp = $this->otp ?? rand(100100, 999000);
        $this->save();
    }

    public function send_otp($reset=false)
    {
        if(!$this->otp) return;
        $msg = 'مرحبا بك!'. PHP_EOL;

        if($reset){
            $msg .= 'كلمة المرور المؤقتة لحسابك هي '. $this->otp. PHP_EOL.' '.PHP_EOL;
            $msg .= 'إذا لم تقم بطلب إعادة تعيين كلمة المرور ، فلا يلزم اتخاذ أي إجراء.'. PHP_EOL;
        } else {
            $msg .= 'يسعدنا إنضمامك لموقع  '. setting('website_name') . PHP_EOL.' '.PHP_EOL;
            $msg .= 'كلمة المرور المؤقتة لحسابك هي '. $this->otp. PHP_EOL.' '.PHP_EOL;
            $msg .= 'إذا لم تقم بإنشاء حساب ، فلا يلزم اتخاذ أي إجراء.'. PHP_EOL;
        }

        $msg .= 'مع التحية,'. PHP_EOL;
        $msg .= setting('website_name');

        $this->send_whatsapp_message($this->phone, $msg);
    }
}