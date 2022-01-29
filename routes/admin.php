<?php

// ====================================================================
// * Admin Routes
// ====================================================================
Route::group(['middleware' => ['auth', 'roles:admin-superadmin']],function () {
	Route::get('/', 'AdminController@index')->name('admin.dashboard');

	// Users
	Route::get('users', 'UserController@index')->name('users.index');
	Route::get('stores', 'UserController@stores')->name('users.stores');
	Route::get('admins/add', 'UserController@create');
	Route::post('admins/add', 'UserController@store');
	Route::get('profile', 'UserController@show');
	Route::get('profile/edit', 'UserController@edit');
	Route::put('profile/edit', 'UserController@update');
	Route::put('profile/change-password', 'UserController@update_password');
	Route::get('users/{user}/', 'UserController@show');
	Route::delete('users/{user}/delete', 'UserController@destroy');
	Route::post('users/{user}/active/toggle', 'UserController@toggle_active_state');
	Route::post('users/{user}/change-role', 'UserController@change_user_role');

	// Categories
	Route::get('categories', 'CategoryController@index')->name('categories');
	Route::post('categories', 'CategoryController@store');
	Route::get('categories/{category}/edit', 'CategoryController@edit')->name('edit-category');
	Route::put('categories/{category}', 'CategoryController@update');
	Route::delete('categories/{category}', 'CategoryController@destroy');
	Route::post('categories/{category}/delete-image', 'CategoryController@delete_category_image');

	// Currencies
	Route::get('currencies', 'CurrencyController@index')->name('currencies');
	Route::post('currencies', 'CurrencyController@store');
	Route::get('currencies/{currency}/edit', 'CurrencyController@edit')->name('edit-currency');
	Route::put('currencies/{currency}', 'CurrencyController@update');
	Route::delete('currencies/{currency}', 'CurrencyController@destroy');

	// Countries
	Route::get('countries', 'CountryController@index')->name('countries');
	Route::post('countries', 'CountryController@store');
	Route::get('countries/{country}/edit', 'CountryController@edit')->name('edit-country');
	Route::put('countries/{country}', 'CountryController@update');
	Route::delete('countries/{country}', 'CountryController@destroy');

	// states
	Route::get('countries/{country}/states', 'StateController@index')->name('states');
	Route::post('states', 'StateController@store');
	Route::get('states/{state}/edit', 'StateController@edit')->name('edit-state');
	Route::put('states/{state}', 'StateController@update');
	Route::delete('states/{state}', 'StateController@destroy');

	// areas
	Route::get('states/{state}/areas', 'AreaController@index')->name('areas');
	Route::post('areas', 'AreaController@store');
	Route::get('areas/{area}/edit', 'AreaController@edit')->name('edit-area');
	Route::put('areas/{area}', 'AreaController@update');
	Route::delete('areas/{area}', 'AreaController@destroy');

	// brands
	Route::get('brands', 'BrandController@index')->name('brands');
	Route::get('brands/{brand}/models', 'BrandController@index')->name('models');
	Route::post('brands', 'BrandController@store');
	Route::get('brands/{brand}/edit', 'BrandController@edit')->name('edit-brand');
	Route::put('brands/{brand}', 'BrandController@update');
	Route::delete('brands/{brand}', 'BrandController@destroy');

	// Transactions
	Route::get('transactions', 'TransactionController@index')->name('transactions');
	Route::post('transactions', 'TransactionController@store');
	Route::get('transactions/{transaction}/edit', 'TransactionController@edit')->name('edit-transaction');
	Route::put('transactions/{transaction}', 'TransactionController@update');
	Route::delete('transactions/{transaction}', 'TransactionController@destroy');

	// Listings
	Route::get('listings', 'ListingController@index')->name('listings');
	Route::get('listings/{listing}', 'ListingController@show');
	Route::post('listings/{listing}/change-status', 'ListingController@change_status');

	// Banners
	Route::get('bs', 'BannerController@index')->name('banners');
	Route::post('bs', 'BannerController@store');
	Route::get('bs/{banner}/edit', 'BannerController@edit')->name('edit-banner');
	Route::put('bs/{banner}', 'BannerController@update');
	Route::delete('bs/{banner}', 'BannerController@destroy');
	
	// options
	Route::get('options', 'OptionController@index')->name('options');
	Route::post('options', 'OptionController@store');
	Route::get('options/{option}/edit', 'OptionController@edit')->name('edit-option');
	Route::put('options/{option}', 'OptionController@update');
	Route::delete('options/{option}', 'OptionController@destroy');

	// option_values
	Route::get('options/{option}/option_values', 'OptionValueController@index')->name('option_values');
	Route::post('option_values', 'OptionValueController@store');
	Route::get('option_values/{option_value}/edit', 'OptionValueController@edit')->name('edit-option_value');
	Route::put('option_values/{option_value}', 'OptionValueController@update');
	Route::delete('option_values/{option_value}', 'OptionValueController@destroy');

	// Notifications
	Route::get('notifications', 'NotificationController@create');
	Route::post('notifications', 'NotificationController@store');
});


// ====================================================================
// * SuperAdmin Routes
// ====================================================================
Route::group(['middleware' => ['auth', 'roles:superadmin']],function () {
	// Site Settings
	Route::get('site-sections', 'SettingController@sections');
	Route::get('site-settings', 'SettingController@index');
	Route::post('site-settings/update', 'SettingController@save');
	Route::post('site-settings/{image}/delete', 'SettingController@delete_image');
});
