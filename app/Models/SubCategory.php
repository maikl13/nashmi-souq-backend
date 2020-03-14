<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\FileHandler;

class SubCategory extends Model
{
    use FileHandler;

    public $images_path = "/assets/images/sub-category/";
    
    public function getRouteKeyName() {
        return 'slug';
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // this is a recommended way to declare event handlers
    protected static function boot() {
        parent::boot();

        static::deleting(function(SubCategory $sub_category) {
            // before delete() method call this
            $sub_category->delete_category_image();
        });
    }
}
