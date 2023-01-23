<?php

namespace App\Models;

use App\Traits\ExchangeCurrency;
use Illuminate\Database\Eloquent\Model;

class SubTransaction extends Model
{
    use ExchangeCurrency;

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function original_currency()
    {
        return $this->belongsTo(Currency::class, 'original_currency_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function (SubTransaction $sub_transaction) {
            $sub_transaction->amount_usd = self::exchange($sub_transaction->original_amount, $sub_transaction->original_currency->code, 'USD');
        });
    }
}
