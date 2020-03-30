<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// ====================================================================
// * Authenticated Users Routes
// ====================================================================
Route::group(['middleware' => 'auth'], function () {
	Route::post('profile-picture/delete', 'UserController@delete_profile_picture');
	Route::post('store-banner/delete', 'UserController@delete_store_banner');
	Route::post('store-logo/delete', 'UserController@delete_store_logo');

	Route::get('account', 'UserController@edit')->name('account');
	Route::put('account/edit', 'UserController@update');
	Route::put('account/change-password', 'UserController@update_password');
	Route::put('account/update-store', 'UserController@update_store');

	Route::get('listings', 'ListingController@index');
	Route::get('listings/add', 'ListingController@create');
	Route::post('listings', 'ListingController@store');
	Route::delete('listings/{listing}', 'ListingController@destroy');
	Route::get('listings/{listing}/edit', 'ListingController@edit');
	Route::put('listings/{listing}', 'ListingController@update');
	Route::post('listings/{listing}/delete-image', 'ListingController@delete_listing_image');
});

// ====================================================================
// * Guests Routes
// ====================================================================

Route::namespace('\App\Http\Controllers')->group(function () {
    Auth::routes();
});

Route::get('/', 'MainController@index')->name('home');
Route::get('/deactivated', 'MainController@deactivated')->name('deactivated');

Route::get('listings', 'ListingController@index');
Route::get('listings/{listing}', 'ListingController@show');
Route::get('users/{user}', 'UserController@show');

Route::get('privacy-policy', 'MainController@privacy_policy');
Route::get('terms-and-conditions', 'MainController@terms_and_conditions');
Route::get('about', 'MainController@about');
Route::get('contact', 'MainController@contact');
Route::get('safety-tips', 'MainController@safety');
