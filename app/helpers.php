<?php

use App\Models\Banner;
use App\Models\Cart;
use App\Models\Country;
use App\Models\Setting;
use App\Models\User;

function setting($name, $return_defaults_if_setting_does_not_exist = true)
{
    $setting = Setting::where('name', $name)->first();

    if ($setting && ! empty(trim($setting->value))) {
        return $setting->value;
    }

    return $return_defaults_if_setting_does_not_exist ? default_setting($name) : null;
}

function default_setting($name)
{
    $defaults = [
        'website_name' => config('app.name'),
        'website_description' => 'Website Description.',
        'logo' => '/assets/images/logo.png',
        'footer_logo' => '/assets/images/footer-logo.png',
    ];

    $setting = isset($defaults[$name]) ? $defaults[$name] : null;

    return $setting;
}

function getUserIP()
{
    if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
        $_SERVER['HTTP_CLIENT_IP'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
    }
    $client = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote = $_SERVER['REMOTE_ADDR'];

    if (filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    } else {
        $ip = $remote;
    }

    return $ip;
}

function country()
{
    $country = location();

    if (Auth::check() && Auth::user()->country) {
        $country = Auth::user()->country;
    }

    if (request()->cookie('country')) {
        $country = Country::where('code', request()->cookie('country'))->first() ?? $country;
    }

    return $country;
}

function country_api()
{
    $country = location();

    if (Auth::check() && Auth::user()->country) {
        $country = Auth::user()->country;
    }

    /*if( request()->cookie('country'))
        $country = Country::where('code', request()->cookie('country'))->first() ?? $country;*/
    return $country;
}

function location()
{
    if (config('app.env') != 'local') {
        if (request()->cookie('country_code')) {
            $country = Country::where('code', request()->cookie('country_code'))->first() ?? Country::first();
        } else {
            try {
                $location = Location::get(getUserIP());
                if ($location && $location->countryCode) {
                    $country_code = $location->countryCode;
                    if ($country_code && ! empty($country_code)) {
                        cookie()->queue('country_code', $country_code, 24 * 60);
                    } // 24 hours
                    $country = Country::whereRaw('LOWER(`code`) = ?', strtolower($country_code))
                        ->first() ?? Country::first();
                }
            } catch (\Throwable $th) { /*_*/
            }
        }
    }

    return $country ?? Country::first();
}

function ad_space($type = '', $banner = false)
{
    switch ($type) {
        // case 'large_rectangle': $width = 336; $height = 280; break;
        case 'large_rectangle': $width = 280;
            $height = 232;
            break;
        case 'leaderboard': $width = 728;
            $height = 90;
            break;
        case 'large_leaderboard': $width = 970;
            $height = 90;
            break;
        case 'mobile_banner': $width = 320;
            $height = 50;
            break;
    }

    $src = $banner ? $banner->banner_image() : '/assets/images/bs/'.$type.'.png';
    $url = $banner ? $banner->url : 'https://wa.me/+201004503999';

    return '<a href="'.$url.'" target="_blank"><img style="width: '.$width.'px; height: auto; max-width: 100%; margin: 0 auto;" src="'.$src.'"></a>';
}

function ad($type = 'leaderboard')
{
    $types = [
        'large_rectangle' => Banner::TYPE_LARGE_RECTANGLE,
        'leaderboard' => Banner::TYPE_LEADERBOARD,
        'large_leaderboard' => Banner::TYPE_LARGE_LEADERBOARD,
        'mobile_banner' => Banner::TYPE_MOBILE_BANNER,
    ];

    $banner = Banner::valid()->localized()->where('type', $types[$type])->inRandomOrder()->first();

    return ad_space($type, $banner);
}

function ads($type = 'leaderboard', $limit = 1, $strict = false)
{
    $types = [
        'large_rectangle' => Banner::TYPE_LARGE_RECTANGLE,
        'leaderboard' => Banner::TYPE_LEADERBOARD,
        'large_leaderboard' => Banner::TYPE_LARGE_LEADERBOARD,
        'mobile_banner' => Banner::TYPE_MOBILE_BANNER,
    ];

    $banners = Banner::valid()->localized()->where('type', $types[$type])->inRandomOrder()->limit($limit)->get();

    $ads = [];

    foreach ($banners as $banner) {
        $ads[] = ad_space($type, $banner);
    }

    if ($strict && count($ads) < $limit) {
        $x = $limit - count($ads);
        for ($i = 0; $i < $x; $i++) {
            $ads[] = ad_space($type, false);
        }
    }

    if (! count($ads)) {
        $ads[] = ad_space($type, false);
    }

    return $ads;
}

function cart()
{
    $cart = new Cart;

    return $cart;
}

function currency()
{
    if (auth()->check()) {
        if (Auth::check() && Auth::user()->country) {
            return auth()->user()->country->currency;
        }
    }

    return country()->currency;
}

function currency_api()
{
    if (auth()->check()) {
        if (Auth::check() && Auth::user()->country) {
            return auth()->user()->country->currency;
        }
    }

    return country_api()->currency;
}

function exchange($amount, $currency1, $currency2, $for_client = false)
{
    return User::exchange($amount, $currency1, $currency2, $for_client = false);
}

function unique_id($length = 8)
{
    return strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $length));
}

function uid($lenght = 32)
{
    if (function_exists('random_bytes')) {
        $bytes = random_bytes(ceil($lenght / 2));
    } elseif (function_exists('openssl_random_pseudo_bytes')) {
        $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
    } else {
        throw new Exception('no cryptographically secure random function available');
    }

    return substr(bin2hex($bytes), 0, $lenght);
}
