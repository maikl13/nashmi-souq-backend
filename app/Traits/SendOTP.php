<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait SendOTP {
    public function generate_otp()
    {
        $this->otp = $this->otp ?? unique_id();
        $this->save();
    }

    public function send_otp($reset=false)
    {
        if(!$this->otp) return;
        $br = '
';
        $msg = 'مرحبا بك!'. $br;

        if($reset){
            $msg .= 'كلمة المرور المؤقتة لحسابك هي '. $this->otp. $br. $br;
            $msg .= 'إذا لم تقم بطلب إعادة تعيين كلمة المرور ، فلا يلزم اتخاذ أي إجراء.'. $br;
        } else {
            $msg .= 'يسعدنا إنضمامك لموقع  '. setting('website_name') . $br. $br;
            $msg .= 'كلمة المرور المؤقتة لحسابك هي '. $this->otp. $br. $br;
            $msg .= 'إذا لم تقم بإنشاء حساب ، فلا يلزم اتخاذ أي إجراء.'. $br;
        }

        $msg .= 'مع التحية,'. $br;
        $msg .= setting('website_name');

        $this->send_whatsapp_message($this->phone, $msg);
    }
}