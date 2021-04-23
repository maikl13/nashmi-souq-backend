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
	Route::get('/deactivated', 'MainController@deactivated')->name('deactivated');
});

Route::group(['middleware' => ['auth', 'active']], function () {
	Route::post('profile-picture/delete', 'UserController@delete_profile_picture');
	Route::post('store-banner/delete', 'UserController@delete_store_banner');
	Route::post('store-logo/delete', 'UserController@delete_store_logo');

	Route::get('account', 'UserController@edit')->name('account');
	Route::put('account/edit', 'UserController@update');
	Route::put('account/change-password', 'UserController@update_password');
	Route::put('account/update-payout-methods', 'UserController@update_payout_methods');


	Route::get('listings', 'ListingController@index');
	Route::get('listings/add', 'ListingController@create');
	Route::post('listings', 'ListingController@store');
	Route::post('listings/promote', 'ListingController@promote');
	Route::delete('listings/{listing}', 'ListingController@destroy');
	Route::get('listings/{listing}/edit', 'ListingController@edit');
	Route::put('listings/{listing}', 'ListingController@update');
	Route::post('listings/{listing}/delete-image', 'ListingController@delete_listing_image');

	Route::post('messages/add', 'MessageController@store');
	Route::get('conversation/{user}', 'MessageController@get_conversation');
	Route::get('conversations', 'MessageController@get_conversations');
	Route::get('messages/unseen', 'MessageController@get_unseen_messages_count');


	Route::get('deliver', 'DeliveryController@show')->name('deliver');
	Route::post('deliver', 'DeliveryController@send');
	
	Route::post('withdraw', 'TransactionController@withdraw');
	
	Route::get('balance', 'TransactionController@add_balance_page');
	Route::post('balance', 'TransactionController@add_balance');

	Route::post('/comments', 'CommentController@store');
	Route::post('comments/edit', 'CommentController@update');
	Route::delete('/comments/{comment}/delete', 'CommentController@destroy');
});

// ====================================================================
// * Guests Routes
// ====================================================================

Route::namespace('\App\Http\Controllers')->group(function () {
    Auth::routes();
});

Route::get('/', 'MainController@index')->name('home');

Route::get('listings', 'ListingController@index')->name('listings');
Route::get('listings/{listing}', 'ListingController@show');
Route::get('users/{user}', 'UserController@show');

Route::get('privacy-policy', 'MainController@privacy_policy');
Route::get('terms-and-conditions', 'MainController@terms_and_conditions');
Route::get('about', 'MainController@about');
Route::get('safety-tips', 'MainController@safety');
Route::get('advertise', 'MainController@advertise');

Route::get('contact-us', 'ContactMessageController@create');
Route::post('contact-us', 'ContactMessageController@store');

Route::get('c/{country}', 'MainController@change_country');

Route::get('direct-payment', 'TransactionController@direct_payment');
Route::post('direct-payment', 'TransactionController@make_direct_payment');
Route::get('payment-result', 'TransactionController@payment_result');
Route::get('hyperpay-payment-result', 'TransactionController@hyperpay_payment_result');