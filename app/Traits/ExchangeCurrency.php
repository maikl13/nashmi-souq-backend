<?php

namespace App\Traits;

use App\Models\Setting;
use Swap;

trait ExchangeCurrency
{
    public static function exchange($amount, $currency1, $currency2, $for_client = false)
    {
        if ($currency1 == $currency2) {
            return $amount;
        }
        $base = config('swap.options.base_currency');
        $rate = self::rate($currency1, $currency2, $base);
        $new_amount = $amount * $rate;

        return $for_client ? round($new_amount - $new_amount * 0.001, 4) : round($new_amount + $new_amount * 0.001, 4);
    }

    public static function rate_from_base($base, $currency)
    {
        if ($base == $currency) {
            return 1;
        }

        try {
            if($GLOBALS['excange_rate'] != 'settings') {
                $rate = cache()->remember("{$base}/{$currency}", 432000, function () use ($currency, $base) {
                    $rate = Swap::latest("{$base}/{$currency}")->getValue();
    
                    // Store rate in settings
                    $setting = Setting::where('name', 'exchange_rates')->firstOrCreate([
                        'name' => 'exchange_rates',
                    ]);
    
                    $exchange_rates = json_decode($setting->value, true) ?? [];
                    $exchange_rates["{$base}/{$currency}"] = $rate;
                    $setting->value = $exchange_rates;
                    $setting->save();
    
                    return $rate;
                });
            }
        } catch (\Throwable $th) {
            $GLOBALS['excange_rate'] = 'settings';
        }

        if($GLOBALS['excange_rate'] == 'settings') {
            try {
                $rate = json_decode(setting('exchange_rates'), true)["{$base}/{$currency}"];
            } catch (\Throwable $th) {
                //
            }
        }

        return $rate ?? 1;
    }

    public static function rate($currency1, $currency2, $base)
    {
        $base_to_currency1 = self::rate_from_base($base, $currency1);
        $base_to_currency2 = self::rate_from_base($base, $currency2);

        return $base_to_currency2 / $base_to_currency1;
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
