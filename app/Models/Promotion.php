<?php

namespace App\Models;

use App\Traits\FileHandler;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use FileHandler;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function promotion_image( $options=[] ){
        $options = array_merge($options, ['default'=>'promotion']);
        return $this->image($this->image, $options);
    }
    public function upload_promotion_image($file, $w=1280, $h=375){
        return $this->upload_file($file, 'image', ['ext'=>'jpg','w'=>$w, 'h'=>$h, 'allowed'=>['o', '']]);
    }
}
