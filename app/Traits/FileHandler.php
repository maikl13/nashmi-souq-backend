<?php

namespace App\Traits;

use Image;
use File;
use Storage;
use Response;

trait FileHandler {

    // ==============================================================
    // Profile picture
    // ==============================================================
    public function profile_picture( $return_default=false ){
        return $this->profile_picture && !$return_default ?
            $this->images_path.$this->id."/".$this->profile_picture :
            $this->images_path.'default-user.png';
    }

    public function upload_profile_picture($file, $w=512, $h=512){
        $path = public_path($this->images_path.$this->id."/");
        if($filename = $this->upload_image($file, $path , $w, $h)){
            // delete old image
            $this->delete_profile_picture();
            // save new one
            $this->profile_picture = $filename;
            $this->save();
        }
    }

    public function delete_profile_picture(){
        if(!$this->profile_picture) return;
        $path = public_path($this->images_path.$this->id."/");
        $file =$path.$this->profile_picture;
        if(!File::exists($file) or File::delete($file)){
            $this->delete_folder_if_empty($path);
            $this->profile_picture = null;
            if($this->save())
                return response()->json('', 200);
        }
    }




    // ==============================================================
    // Category image
    // ==============================================================
    public function category_image( $return_default=false ){
        return $this->image && !$return_default ?
            $this->images_path.$this->id."/".$this->image :
            $this->images_path.'default.png';
    }

    public function upload_category_image($file, $w=256, $h=256){
        $path = public_path($this->images_path.$this->id."/");
        if($filename = $this->upload_image($file, $path , $w, $h, 'png')){
            // delete old image
            $this->delete_category_image();
            // save new one
            $this->image = $filename;
            $this->save();
        }
    }

    public function delete_category_image(){
        if(!$this->image) return;
        $path = public_path($this->images_path.$this->id."/");
        $file =$path.$this->image;
        if(!File::exists($file) or File::delete($file)){
            $this->delete_folder_if_empty($path);
            $this->image = null;
            if($this->save())
                return response()->json('', 200);
        }
    }










    // ==============================================================
    // For all models
    // ==============================================================
    public function delete_folder_if_empty($path){
        if(File::exists($path) && count(scandir($path)) <= 2){
            File::deleteDirectory( $path );
        }
    }

    public function upload_image($file, $path,  $w=1280, $h=720, $ext='jpg'){
        if(!$file) return false;
        $image = Image::make($file)->encode($ext, 75);
        if($w && $h) $image->resize($w, $h);
        $filename = uniqid().".".$ext;
        File::exists($path) or File::makeDirectory($path);
        return $image->save($path."/".$filename) ? $filename : false;
    }

}