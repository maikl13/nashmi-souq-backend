<?php

use App\Models\Setting;

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