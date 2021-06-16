<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Swap;

trait ExchangeCurrency { 
    public static function exchange($amount, $currency1, $currency2, $for_client=false)
    {
        if($currency1 == $currency2) return $amount;
        $base = config('swap.options.base_currency');
        $rate = Self::rate($currency1, $currency2, $base);
        $new_amount = $amount*$rate;
        return $for_client ? round($new_amount-$new_amount*0.001, 4) : round($new_amount+$new_amount*0.001, 4);
    }

    public static function rate_from_base($base, $currency)
    {
        if($base == $currency) return 1;
        return cache()->store('database')->remember($base.'/'.$currency, 259200, function() use ($currency, $base){
            return Swap::latest($base."/$currency")->getValue();
        });
    }

    public static function rate($currency1, $currency2, $base)
    {
        $base_to_currency1 = self::rate_from_base($base, $currency1);
        $base_to_currency2 = self::rate_from_base($base, $currency2);
        return $base_to_currency2/$base_to_currency1;
    }
    
    public static function is_valid_code($code)
    {
        $base = config('swap.options.base_currency');

        try {
            return self::rate_from_base($base, $code);
        } catch (\Throwable $th) {
            return false;
        }
    }
}