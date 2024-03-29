<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function areas()
    {
        return $this->hasMany(Area::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function listings()
    {
        return $this->hasMany(Listing::class);
    }

    public function url()
    {
        return '/listings?states[]='.$this->id;
    }
}
