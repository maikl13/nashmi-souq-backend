<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    public function getRouteKeyName() {
        return 'slug';
    }
    
    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
