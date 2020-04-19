<?php

use App\Models\Setting;
use App\Models\Country;
use App\Models\Banner;

function setting($name, $return_defaults_if_setting_does_not_exist=true){
    $setting = Setting::where('name', $name)->first();

    if($setting && !empty(trim($setting->value))) return $setting->value;
    return $return_defaults_if_setting_does_not_exist ? default_setting($name) : null;
}

function default_setting($name){
	$defaults = [
		'website_name' => config('app.name'),
		'website_description' => 'Website Description.',
		'logo' => '/assets/images/logo.png',
		'footer_logo' => '/assets/images/footer-logo.png',
	];

    $setting = isset( $defaults[$name] ) ? $defaults[$name] : null;
    return $setting;
}

function getUserIP() {
	if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
			  $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
			  $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
	}
	$client  = @$_SERVER['HTTP_CLIENT_IP'];
	$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
	$remote  = $_SERVER['REMOTE_ADDR'];

	if(filter_var($client, FILTER_VALIDATE_IP)) { $ip = $client; }
	elseif(filter_var($forward, FILTER_VALIDATE_IP)) { $ip = $forward; }
	else { $ip = $remote; }

	return $ip;
}

function country(){
	$country = location();

	if(Auth::check() && Auth::user()->country) $country = Auth::user()->country;

    if( request()->cookie('country'))
        $country = Country::where('code', request()->cookie('country'))->first() ?? $country;
	return $country;
}

function location(){
	if( env('APP_ENV') == 'local' ){
		$country = Country::first();
	} else {
		$ip_address = getUserIP();
		$location = Location::get($ip_address);
		$country_code = $location && $location->countryCode ? $location->countryCode : '';
		$country = Country::whereRaw( 'LOWER(`code`) = ?', strtolower($country_code))
						->first() ?? Country::first();
	}

	return $country;
}

function ad_space($type='', $banner)
{
	switch ($type) {
		case 'large_rectangle': $width = 336; $height = 280; break;
		case 'leaderboard': $width = 728; $height = 90; break;
		case 'large_leaderboard': $width = 970; $height = 90; break;
		case 'mobile_banner': $width = 320; $height = 50; break;
	}

	$src = $banner ? $banner->banner_image() : '/assets/images/bs/'.$type.'.png';
	$url = $banner ? $banner->url : 'javascript:void(0)';

	return '<a href="'.$url.'" target="_blank"><img style="width: '. $width .'px; height: auto; max-width: 100%; margin: 0 auto;" src="'.$src.'"></a>';
}

function ad($type='leaderboard')
{
	switch ($type) {
		case 'large_rectangle': 
			$banner = Banner::valid()->where('type', Banner::TYPE_LARGE_RECTANGLE)->inRandomOrder()->first();
			break;
		case 'leaderboard': 
			$banner = Banner::valid()->where('type', Banner::TYPE_LEADERBOARD)->inRandomOrder()->first();
			break;
		case 'large_leaderboard': 
			$banner = Banner::valid()->where('type', Banner::TYPE_LARGE_LEADERBOARD)->inRandomOrder()->first();
			break;
		case 'mobile_banner': 
			$banner = Banner::valid()->where('type', Banner::TYPE_MOBILE_BANNER)->inRandomOrder()->first();
			break;
	}

	return ad_space($type, $banner);
}