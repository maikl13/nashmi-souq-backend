<?php

// ====================================================================
// * Admin Routes
// ====================================================================
Route::group(['middleware' => ['auth', 'roles:admin-superadmin']],function () {
	Route::get('/', 'AdminController@index')->name('admin.dashboard');

	// Users
	Route::get('users', 'UserController@index')->name('users.index');
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

	// SubCategories
	Route::get('categories/{category}/sub-categories', 'SubCategoryController@index')->name('sub-categories');
	Route::post('sub-categories', 'SubCategoryController@store');
	Route::get('sub-categories/{sub_category}/edit', 'SubCategoryController@edit')->name('edit-sub-category');
	Route::put('sub-categories/{sub_category}', 'SubCategoryController@update');
	Route::delete('sub-categories/{sub_category}', 'SubCategoryController@destroy');
	Route::post('sub-categories/{sub_category}/delete-image', 'SubCategoryController@delete_category_image');

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

	// ...
});


