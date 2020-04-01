<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Image;
use File;

class SettingController extends Controller
{

    public function index()
    {
        return view('admin.settings.site-settings');
    }

    public function sections()
    {
        return view('admin.settings.site-sections');
    }


    public function save(Request $request)
    {
        $request->validate([
            //basic
            'website_name' => 'max:255',
            'website_description' => 'nullable|max:1000',
            'logo' => 'image|nullable|max:2000',
            'footer_logo' => 'image|nullable|max:2000',
            'address' => 'nullable|max:255',
            'phone' => 'nullable|max:255',
            'phone2' => 'nullable|max:255',
            'whatsapp' => 'nullable|max:255',
            'fax' => 'nullable|max:255',
            'email' => 'nullable|max:255|email',

            // social
            'facebook' => 'nullable|max:255|url',
            'twitter' => 'nullable|max:255|url',
            'instagram' => 'nullable|max:255|url',
            'youtube' => 'nullable|max:255|url',
            'linkedin' => 'nullable|max:255|url',
        ]);

        $allowed_settings = [
            // basic
            'website_name', 'website_description', 'logo', 'footer_logo', 'phone', 'phone2', 'whatsapp', 'fax', 'email', 'address', 'hide_developer_names',
            // social
            'facebook', 'twitter', 'instagram', 'youtube', 'linkedin',
            // google maps
            'latitude', 'longitude',
            // sections
            'about',
            // pages
            'privacy', 'terms', 'safety'
        ];
        $images = ['logo', 'footer_logo'];
        $html = [];

        foreach($request->all() as $name => $value){
            if(in_array($name, $allowed_settings)){
                $setting = Setting::where('name', $name)->first();
                $setting = $setting ? $setting : new Setting;
                $setting->name = $name;
                if(in_array($name, $images)){
                    $w = false; $h = false;
                    if(in_array($name, ['about_image', 'story_image', 'message_image', 'vision_image'])){
                        $w = 1080; $h = 720;
                    }
                    if($filename = $this->upload_image($request->file($name), $w, $h)){
                        $this->delete_image($name);
                        $setting->value = $filename;
                    } else {
                        return response()->json('حدث خطأ ما أثناء رفع الملف! من فضلك حاول مجددا', 500);
                    }
                } else {
                    $setting->value = in_array($name, $html) ? $setting->clean_html($value) : $value;
                }
                $setting->save();
            }
        }
        return response()->json('تم تحديث الاعدادات بنجاح', 200);
    }

    public function upload_image($file, $w, $h)
    {
        $extention = $file->getClientOriginalExtension();
        $name = uniqid();
        $file = Image::make($file)->encode('png', 75);
        if($w && $h) $file->resize($w, $h);
        if($file){
            $img_dir = "assets/images/" ;
            File::exists($img_dir) or File::makeDirectory($img_dir);

            $path = $img_dir . 'settings' . "/";
            File::exists($path) or File::makeDirectory($path);
            
            if(File::exists($path."/{$name}.png")) File::delete($path . "/{$name}.png");

            $file->save($path . "/{$name}.png");
            return "/".$path.$name.".png";
        }
        return false;
    }
    
    public function delete_image($image)
    {
        $setting = Setting::where('name', $image)->first();
        if($setting){
            if(File::exists("assets/images/settings/{$setting->value}.png")) File::delete("assets/images/settings/{$setting->value}.png");
            $setting->value = null;
            $setting->save();
        }
        return response()->json('تم الحذف بنجاح', 200);
    }
}
