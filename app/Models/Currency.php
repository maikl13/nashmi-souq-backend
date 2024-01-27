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
    

    protected static function boot()
    {
        parent::boot();

        static::saved(fn () => Cache::forget('currencies'));

        static::deleted(fn () => Cache::forget('currencies'));
    }
}
