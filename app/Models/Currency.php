<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ExchangeCurrency;

class Currency extends Model
{
    use ExchangeCurrency;

    protected $fillable = ['code', 'slug', 'name', 'symbol'];

    public function getRouteKeyName() {
        return 'slug';
    }
}
