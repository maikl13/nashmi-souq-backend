<?php

namespace App\Models;

use App\Traits\FileHandler;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use FileHandler;

    public $images_path = '/assets/images/sub-category/';

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function listings()
    {
        return $this->hasMany(Listing::class);
    }

    public function url()
    {
        return '/listings?sub_categories[]='.$this->id;
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (SubCategory $sub_category) {
            // before delete() method call this
            $sub_category->delete_category_image();
        });
    }
}
