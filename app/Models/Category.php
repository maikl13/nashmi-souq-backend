<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\FileHandler;

class Category extends Model
{
    use FileHandler;

    public $images_path = "/assets/images/category/";
    
    public function getRouteKeyName() {
        return 'slug';
    }

    public function sub_categories()
    {
        return $this->hasMany(SubCategory::class, 'category_id');
    }

    public function listings()
    {
        return $this->hasMany(Listing::class);
    }

    public function url()
    {
        return '/listings?categories[]='.$this->id;
    }

    // this is a recommended way to declare event handlers
    protected static function boot() {
        parent::boot();

        static::deleting(function(Category $category) {
            // before delete() method call this
            $category->delete_category_image();
        });
    }
}
