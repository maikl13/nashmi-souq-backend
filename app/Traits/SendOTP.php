<?php

namespace App\Traits;

use App\Notifications\OTPGenerated;

trait SendOTP
{
    public function send_otp($reset)
    {
        $this->otp = $this->otp ?? rand(100100, 999000);
        $this->save();

        $this->notify(new OTPGenerated($reset));
    }
}
