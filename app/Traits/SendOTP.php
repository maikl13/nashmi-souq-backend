<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait SendOTP {

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

        $data = [
            'phone' => str_replace('+', '', $this->phone), // Receivers phone
            'body' => $msg //message
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

    public function generate_otp()
    {
        $this->otp = $this->otp ?? strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 8));
        $this->save();
    }
}