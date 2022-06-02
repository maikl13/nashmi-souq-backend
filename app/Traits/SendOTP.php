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
        $this->send_whatsapp_template($this->phone, 'otp', [
            [
                "type" => "body", 
                "parameters" => [
                    ["type" => "text", "text" => $this->otp]
                ] 
            ]
        ]);
    }
}