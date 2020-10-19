<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\FileHandler;

class Category extends Model
{
    use FileHandler;

    protected static $category_image_sizes = [
        '' => ['w'=>256, 'h'=>256, 'quality'=>80],
        'o' => ['w'=>null, 'h'=>null, 'quality'=>100],
        'xxxs' => ['w'=>15, 'h'=>15, 'quality'=>70],
        'xxs' => ['w'=>32, 'h'=>32, 'quality'=>70],
        'xs' => ['w'=>64, 'h'=>64, 'quality'=>70],
        's' => ['w'=>128, 'h'=>128, 'quality'=>80],
        'l' => ['w'=>512, 'h'=>512, 'quality'=>90],
        'xl' => ['w'=>1000, 'h'=>1000, 'quality'=>100],
    ];

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

    public function category_image( $options=[] ){
        $options = array_merge($options);
        return $this->image($this->image, $options);
    }
    public function upload_category_image($file){
        return $this->upload_file($file, 'image', ['ext'=>'jpg','w'=>256, 'h'=>256, 'allowed'=>['o', '', 's', 'xs', 'xxs', 'l']]);
    }

    // this is a recommended way to declare event handlers
    protected static function boot() {
        parent::boot();

        static::deleting(function(Category $category) {
            // before delete() method call this
            return $category->delete_file('image');
        });
    }
}
