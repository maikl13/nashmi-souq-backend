<?php

namespace App\Models;

use App\Traits\FileHandler;
use Illuminate\Database\Eloquent\Model;

class OptionValue extends Model
{
    use FileHandler;

    protected static $option_value_image_sizes = [
        '' => ['w' => 64, 'h' => null, 'quality' => 80],
        'o' => ['w' => null, 'h' => null, 'quality' => 100],
        's' => ['w' => 56, 'h' => null, 'quality' => 80],
        'l' => ['w' => 128, 'h' => null, 'quality' => 80],
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function option_value_image($options = [])
    {
        $options = array_merge($options);

        return $this->image($this->image, $options);
    }

    public function upload_option_value_image($file, $options = [])
    {
        $options = array_merge($options, ['ext' => 'png', 'sizes' => self::$option_value_image_sizes]);

        return $this->upload_file($file, 'image', $options);
    }

    // this is a recommended way to declare event handlers
    protected static function boot()
    {
        parent::boot();

        static::deleting(function (OptionValue $option_value) {
            return $option_value->delete_file('image');
        });
    }
}
