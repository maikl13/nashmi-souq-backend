<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageItem extends Model
{
    public function listing(){
        return $this->belongsTo(Listing::class);
    }
    public function package(){
        return $this->belongsTo(Package::class);
    }
    public function original_currency(){
        return $this->belongsTo(Currency::class, 'original_currency_id');
    }

    public function price(){
        return $this->price+0;
    }
    public function total_price(){
        return $this->price()*$this->quantity;
    }
    public function original_price(){
        // The price in the original currency not the local one
        return $this->original_price+0;
    }
}
