<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ExchangeCurrency;

class SubTransaction extends Model
{
    use ExchangeCurrency;
    public function transaction(){
        return $this->belongsTo(Transaction::class);
    }
    public function currency(){
        return $this->belongsTo(Currency::class);
    }
    public function original_currency(){
        return $this->belongsTo(Currency::class, 'original_currency_id');
    }

    
    // this is a recommended way to declare event handlers
    protected static function boot() {
        parent::boot();

        static::saving(function(SubTransaction $sub_transaction) {
            $sub_transaction->amount_usd = Self::exchange($sub_transaction->original_amount, $sub_transaction->original_currency->code, 'USD');
        });
    }
}
