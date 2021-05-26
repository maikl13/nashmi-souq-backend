<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Swap;

trait ExchangeCurrency { 
    public static function exchange($amount, $currency1, $currency2, $for_client=false)
    {
        if($currency1 == $currency2) return $amount;
        $base='USD';
        $rate = Self::rate($currency1, $currency2, $base);
        $new_amount = $amount*$rate;
        return $for_client ? round($new_amount-$new_amount*0.001, 4) : round($new_amount+$new_amount*0.001, 4);
    }

    public static function rate($currency1, $currency2, $base)
    {
        cache()->remember($currency1.'/'.$currency2, 86400, function() use ($currency1, $currency2, $base){
            $base_to_currency1 = Swap::latest($base."/$currency1");
            $base_to_currency2 = Swap::latest($base."/$currency2");
            $currency1_to_currency2 = $base_to_currency2->getValue()/$base_to_currency1->getValue();
            return $currency1_to_currency2;
        });
        return cache()->get($currency1.'/'.$currency2);
    }
    
    public static function is_valid_code($code, $base='USD')
    {
        try {
            Swap::latest($base."/$code");
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}