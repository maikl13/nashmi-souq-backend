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
	Route::put('account/update-store', 'UserController@update_store');
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

	Route::get('checkout', 'CartController@checkout')->name('checkout');
	Route::post('order/new', 'OrderController@store');
	Route::get('order/new', 'OrderController@order_saved')->name('order-saved');
	Route::get('my-orders', 'OrderController@index')->name('my-orders');
	Route::get('order/{order}/details', 'OrderController@show')->name('order-details');
	Route::get('order/{package}/cancel', 'OrderController@cancel_order');
	Route::post('product/rate', 'ProductController@rate');
	Route::post('product/add-review', 'ProductController@add_review');
	Route::get('get-product-reviews', 'ProductController@get_reviews');
	Route::get('get-product-rate', 'ProductController@get_rate');

	Route::get('orders', 'OrderController@orders')->name('orders');
	Route::get('orders/{package}', 'OrderController@show_for_store');
	Route::post('orders/change-status', 'OrderController@change_status');
	Route::post('orders/get-shipping', 'OrderController@get_shipping');
	Route::post('orders/get-status', 'OrderController@get_status');
	Route::post('orders/get-status-updates-log', 'OrderController@get_status_updates_log');

	Route::get('deliver', 'DeliveryController@show');
	Route::post('deliver', 'DeliveryController@send');
	
	Route::post('withdraw', 'TransactionController@withdraw');
	
	Route::get('balance', 'TransactionController@add_balance_page');
	Route::post('balance', 'TransactionController@add_balance');

	Route::post('listings/{listing}/comments', 'CommentController@store');
	Route::delete('listings/{listing}/comments/{comment}/delete', 'CommentController@destroy');
	Route::post('comments/edit', 'CommentController@update');
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
Route::get('stores', 'UserController@index');

Route::get('privacy-policy', 'MainController@privacy_policy');
Route::get('terms-and-conditions', 'MainController@terms_and_conditions');
Route::get('about', 'MainController@about');
Route::get('safety-tips', 'MainController@safety');
Route::get('advertise', 'MainController@advertise');

Route::get('contact-us', 'ContactMessageController@create');
Route::post('contact-us', 'ContactMessageController@store');

Route::get('c/{country}', 'MainController@change_country');


Route::post('cart/add', 'CartController@store');
Route::get('cart/update-dropdown', 'CartController@update_cart_dropdown');
Route::get('cart', 'CartController@index')->name('cart');
Route::delete('cart/{product_id}/remove', 'CartController@remove_from_cart');
Route::post('cart/update-quantity', 'CartController@update_product_quantity');
Route::get('cart/update-totals', 'CartController@update_totals');

Route::get('payment-result', 'TransactionController@payment_result');

Route::get('direct-payment', 'TransactionController@direct_payment');
Route::post('direct-payment', 'TransactionController@make_direct_payment');
