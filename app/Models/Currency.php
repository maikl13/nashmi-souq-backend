<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    public function getRouteKeyName() {
        return 'slug';
    }
    
}
