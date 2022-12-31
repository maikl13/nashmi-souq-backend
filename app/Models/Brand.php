<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $casts = ['categories' => 'array'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function parent()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function children()
    {
        return $this->hasMany(Brand::class, 'brand_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Brand $brand) {
            $brand->children->each(function ($child) {
                $child->delete();
            });
        });
    }
}
