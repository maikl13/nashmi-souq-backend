<?php

namespace App\Models;

use App\Traits\CleanHtml;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use CleanHtml;

    protected $fillable = ['name'];

    protected static function boot()
    {
        parent::boot();

        static::saved(fn () => Cache::forget('settings'));

        static::deleted(fn () => Cache::forget('settings'));
    }
}
