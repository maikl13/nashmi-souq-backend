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
	return $country;
}