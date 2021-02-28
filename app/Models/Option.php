<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $casts = ['categories'=>'array'];
    
    public function getRouteKeyName() {
        return 'slug';
    }

    public function option_values()
    {
        return $this->hasMany(OptionValue::class);
    }
    
}
