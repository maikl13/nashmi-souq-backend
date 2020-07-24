<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function getRouteKeyName() {
        return 'slug';
    }
    
    public function states()
    {
        return $this->hasMany(State::class);
    }
    
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function listings()
    {
        return $this->hasManyThrough(Listing::class, State::class);
    }
}
