<?php

use App\Models\Setting;
use App\Models\Country;

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
	$ip_address = getUserIP();
	$location = Location::get($ip_address);
	$country_code = $location && $location->countryCode ? $location->countryCode : '';

	$country = Country::whereRaw( 'LOWER(`code`) = ?', strtolower($country_code))->first() ?? Country::first();
	if(Auth::check() && Auth::user()->country) $country = Auth::user()->country;

    if( request()->cookie('country'))
        $country = Country::where('code', request()->cookie('country'))->first() ?? $country;
	return $country;
}

function ad_space($type='')
{
	if ($type == 'text')
		return '<a href="#">أعلن لدينا - إعلان نصي</a>';

	// Large Rectangle - 336x280
	// Leaderboard - 728x90
	// Large Leaderboard - 970x90
	// Mobile Banner - 320x50

	switch ($type) {
		// case 'small_square': $width = 200; $height = 200; break;
		// case 'square': $width = 250; $height = 250; break;
		// case 'medium_rectangle': $width = 300; $height = 250; break;
		case 'large_rectangle': $width = 336; $height = 280; break;
		case 'leaderboard': $width = 728; $height = 90; break;
		case 'large_leaderboard': $width = 970; $height = 90; break;
		// case 'full_banner': $width = 468; $height = 60; break;
		case 'mobile_banner': $width = 320; $height = 50; break;
		// case 'skyscraper': $width = 120; $height = 600; break;
		// case 'wide_skyscraper': $width = 160; $height = 600; break;
		// case 'half_page': $width = 300; $height = 600; break;
		
		// default: $type = 'full_banner'; $width = 468; $height = 60; break;
	}
	// return '<div style="width: '. $width .'px; height: '. $height .'px; background: #f85c70; color: #fff; line-height: '. $height .'px; text-align: center; max-width: 100%; margin: 0 auto; font-size: 14x; overflow: hidden;">أعلن لدينا '. Str::title(str_replace('_', ' ', $type)) .' ( '.$width.'x'.$height.' )</div>';

	return '<a href="https://brmjyat.com"><img style="width: '. $width .'px; height: auto; max-width: 100%; margin: 0 auto;" src="/assets/images/bs/'.$type.'.png"></a>';
}

function ad($type='')
{
	return ad_space($type);
}