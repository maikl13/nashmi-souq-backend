<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = ['user_id', 'start', 'end', 'type'];
    protected $dates = ['created_at', 'updated_at', 'start', 'end'];

    const TYPE_TRIAL = 0;
    const TYPE_MONTHLY = 1;
    const TYPE_HALF_YEAR = 2;
    const TYPE_YEARLY = 3;
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
