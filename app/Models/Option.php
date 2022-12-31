<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    const PREVIEW_NAME = 1;

    const PREVIEW_NONE = 2;

    const PREVIEW_HTML = 3;

    const PREVIEW_FIXED_IMAGE = 4;

    const PREVIEW_PRODUCT_IMAGE = 5;

    const COLOR_DEFAULT = 1;

    const COLOR_CUSTOM = 2;

    protected $casts = ['categories' => 'array'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function option_values()
    {
        return $this->hasMany(OptionValue::class);
    }
}
