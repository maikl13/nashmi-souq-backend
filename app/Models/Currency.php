<?php

namespace App\Models;

use App\Traits\ExchangeCurrency;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use ExchangeCurrency;

    protected $fillable = ['code', 'slug', 'name', 'symbol'];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
