<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\PaymentTrait;
use App\Traits\ExchangeCurrency;

class FeaturedListing extends Model
{
    use PaymentTrait, ExchangeCurrency;

    public function listing(){
        return $this->belongsTo(Listing::class);
    }
    public function currency(){
        return $this->belongsTo(Currency::class);
    }
    public function transaction(){
        return $this->belongsTo(Currency::class);
    }
}
