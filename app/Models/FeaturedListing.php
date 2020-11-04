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
        return $this->belongsTo(Transaction::class);
    }
    
    public function period()
    {
        switch ($this->tier) {
            case 1: return 1; break;
            case 2: return 3; break;
            case 3: return 7; break;
            case 4: return 15; break;
            case 5: return 30; break;
            case 6: return 90; break;
            case 7: return 180; break;
            case 8: return 365; break;

            case 9: return 30; break;
            case 10: return 60; break;
            case 11: return 90; break;
            case 12: return 120; break;
            case 13: return 150; break;
            case 14: return 180; break;
            case 15: return 210; break;
            case 16: return 240; break;
            case 17: return 270; break;
            case 18: return 300; break;
            case 19: return 330; break;
            case 20: return 360; break;
        }
    }
}
