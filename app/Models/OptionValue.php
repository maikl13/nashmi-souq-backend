<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OptionValue extends Model
{
    public function getRouteKeyName() {
        return 'slug';
    }
    
    public function option()
    {
        return $this->belongsTo(Option::class);
    }
}
