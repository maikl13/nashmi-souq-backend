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

    const STATUS_PENDING = 0;
    CONST STATUS_ACTIVE = 1;
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPeriodAttribute()
    {
        return $this->end->diffInDays($this->start);
    }

    public function getTypeAttribute()
    {
        switch ($this->attributes['type']) {
            case Self::TYPE_TRIAL: return "فترة تجريبية"; break;
            case Self::TYPE_TRIAL: return "اشتراك شهري"; break;
            case Self::TYPE_TRIAL: return "اشتراك نصف سنوي"; break;
            case Self::TYPE_TRIAL: return "اشتراك سنوي"; break;
        }
    }

    public function scopeActive($query)
    {
        return $query->where('status', Self::STATUS_ACTIVE);
    }
}
