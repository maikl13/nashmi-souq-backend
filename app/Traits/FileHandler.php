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
    // Store Banner
    // ==============================================================

    public function store_banner( $return_default=false ){
        return $this->store_banner && !$return_default ?
            $this->images_path.$this->id."/".$this->store_banner :
            $this->images_path.'default-store-banner.jpg';
    }

    public function upload_store_banner($file, $w=1180, $h=300){
        $path = public_path($this->images_path.$this->id."/");
        if($filename = $this->upload_image($file, $path , $w, $h)){
            // delete old image
            $this->delete_store_banner();
            // save new one
            $this->store_banner = $filename;
            $this->save();
        }
    }

    public function delete_store_banner(){
        if(!$this->store_banner) return;
        $path = public_path($this->images_path.$this->id."/");
        $file =$path.$this->store_banner;
        if(!File::exists($file) or File::delete($file)){
            $this->delete_folder_if_empty($path);
            $this->store_banner = null;
            if($this->save())
                return response()->json('', 200);
        }
    }





    // ==============================================================
    // Store Logo
    // ==============================================================

    public function store_logo( $return_default=false ){
        return $this->store_logo && !$return_default ?
            $this->images_path.$this->id."/".$this->store_logo :
            $this->images_path.'default-store-logo.png';
    }

    public function upload_store_logo($file, $w=512, $h=512){
        $path = public_path($this->images_path.$this->id."/");
        if($filename = $this->upload_image($file, $path , $w, $h, 'png')){
            // delete old image
            $this->delete_store_logo();
            // save new one
            $this->store_logo = $filename;
            $this->save();
        }
    }

    public function delete_store_logo(){
        if(!$this->store_logo) return;
        $path = public_path($this->images_path.$this->id."/");
        $file =$path.$this->store_logo;
        if(!File::exists($file) or File::delete($file)){
            $this->delete_folder_if_empty($path);
            $this->store_logo = null;
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
    // Listing images
    // ==============================================================
    public function listing_images( $return_default=false ){
        $images = json_decode($this->images);
        $imgs = [];
        if(is_array($images))
            foreach ($images as $image) 
                $imgs[] = $this->images_path.$this->id."/".$image ;

        return !empty($imgs) && !$return_default ? $imgs : [$this->images_path.'default.png'];
    }

    public function listing_image(){
        $images = $this->listing_images();
        return array_shift($images);
    }

    public function upload_listing_images($files, $w=false, $h=false){
        $path = public_path($this->images_path.$this->id."/");
        $images = is_array( json_decode($this->images) ) ? json_decode($this->images) : array();
        if($files && is_array($files)){
            foreach ($files as $file) {
                if($filename = $this->upload_image($file, $path , $w, $h, 'png')){
                    $images[] = $filename;
                }
            }
        }
        $this->images = json_encode($images);
        $this->save();
    }

    public function delete_listing_image($image){
        $path = public_path($this->images_path.$this->id."/");
        $file =$path.$image;
        if(!File::exists($file) or File::delete($file)){
            $this->delete_folder_if_empty($path);
            $images = json_decode($this->images);
            $key = array_search($image, $images);
            unset($images[$key]);
            $this->images = json_encode(array_values($images));
            if($this->save())
                return response()->json('', 200);
        }
    }




    // ==============================================================
    // Banner image
    // ==============================================================
    public function banner_image( $return_default=false ){
        return $this->image && !$return_default ?
            $this->images_path.$this->id."/".$this->image :
            $this->images_path.'default.png';
    }

    public function upload_banner_image($file, $w=256, $h=256){
        $path = public_path($this->images_path.$this->id."/");
        if($filename = $this->upload_image($file, $path , $w, $h, 'png')){
            // delete old image
            $this->delete_banner_image();
            // save new one
            $this->image = $filename;
            $this->save();
        }
    }

    public function delete_banner_image(){
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