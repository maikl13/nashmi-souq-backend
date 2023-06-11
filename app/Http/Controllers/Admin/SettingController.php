<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use File;
use Illuminate\Http\Request;
use Image;

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
            'delivery_phone' => 'nullable|max:255',

            // social
            'facebook' => 'nullable|max:255|url',
            'twitter' => 'nullable|max:255|url',
            'instagram' => 'nullable|max:255|url',
            'youtube' => 'nullable|max:255|url',
            'linkedin' => 'nullable|max:255|url',

            'tier1' => 'nullable|numeric',
            'tier2' => 'nullable|numeric',
            'tier3' => 'nullable|numeric',
            'tier4' => 'nullable|numeric',
            'tier5' => 'nullable|numeric',
            'tier6' => 'nullable|numeric',
            'tier7' => 'nullable|numeric',
            'tier8' => 'nullable|numeric',

            'trial_period' => 'nullable|numeric',
            'grace_period' => 'nullable|numeric',
            'monthly_subscription' => 'nullable|numeric',
            'half_year_subscription' => 'nullable|numeric',
            'yearly_subscription' => 'nullable|numeric',

            'listings_limit' => 'nullable|integer|min:1',
            'listings_limit_timespan' => 'nullable|integer|min:1',
        ]);

        $allowed_settings = [
            // basic
            'website_name', 'website_description', 'logo', 'footer_logo', 'phone', 'phone2', 'whatsapp', 'delivery_phone', 'fax', 'email', 'address', 'hide_developer_names',
            // social
            'facebook', 'twitter', 'instagram', 'youtube', 'linkedin',
            // google maps
            'latitude', 'longitude',
            // sections
            'notification', 'notification2', 'slogan', 'open_store_section_header', 'open_store_section',
            // pages
            'about', 'privacy', 'terms', 'safety', 'advertise', 'balance',
            // tiers
            'featured_ads_benefits', 'tier1', 'tier2', 'tier3', 'tier4', 'tier5', 'tier6', 'tier7', 'tier8',
            'featured_ads_benefits2', 'tier9', 'tier10', 'tier11', 'tier12', 'tier13', 'tier14', 'tier15', 'tier16', 'tier17', 'tier18', 'tier19', 'tier20',
            // stores
            'grace_period', 'trial_period', 'monthly_subscription', 'half_year_subscription', 'yearly_subscription',
            // listings
            'listings_limit', 'listings_limit_timespan',
        ];
        $images = ['logo', 'footer_logo'];
        $html = [];

        foreach ($request->all() as $name => $value) {
            if (in_array($name, $allowed_settings)) {
                $setting = Setting::where('name', $name)->first();
                $setting = $setting ? $setting : new Setting;
                $setting->name = $name;
                if (in_array($name, $images)) {
                    $w = false;
                    $h = false;
                    if (in_array($name, ['about_image', 'story_image', 'message_image', 'vision_image'])) {
                        $w = 1080;
                        $h = 720;
                    }
                    if ($filename = $this->upload_image($request->file($name), $w, $h)) {
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
        if ($w && $h) {
            $file->resize($w, $h);
        }
        if ($file) {
            $img_dir = 'assets/images/';
            File::exists($img_dir) or File::makeDirectory($img_dir);

            $path = $img_dir.'settings'.'/';
            File::exists($path) or File::makeDirectory($path);

            if (File::exists($path."/{$name}.png")) {
                File::delete($path."/{$name}.png");
            }

            $file->save($path."/{$name}.png");

            return '/'.$path.$name.'.png';
        }

        return false;
    }

    public function delete_image($image)
    {
        $setting = Setting::where('name', $image)->first();
        if ($setting) {
            if (File::exists("assets/images/settings/{$setting->value}.png")) {
                File::delete("assets/images/settings/{$setting->value}.png");
            }
            $setting->value = null;
            $setting->save();
        }

        return response()->json('تم الحذف بنجاح', 200);
    }
}
