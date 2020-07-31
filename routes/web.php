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
Route::get('balance', 'MainController@balance');

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































Route::get('hosted-session', function(){
	$PWD = '61422445f6c0f954e24c7bd8216ceedf';
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, 'https://test-nbe.gateway.mastercard.com/api/nvp/version/57');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "apiOperation=CREATE_CHECKOUT_SESSION&apiPassword=$PWD&apiUsername=merchant.EGPTEST1&merchant=EGPTEST1&interaction.operation=PURCHASE&interaction.returnUrl=https://souqtest.brmjyat.com/payment-result&order.id=".uniqid()."&order.amount=100&order.currency=EGP");

	$headers = array();
	$headers[] = 'Content-Type: application/x-www-form-urlencoded';
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);
	if (curl_errno($ch)) {
		echo 'Error:' . curl_error($ch);
	}
	curl_close($ch);

	// $result = "merchant=EGPTEST1&result=SUCCESS&session.id=SESSION0002546338248G4885481I10&session.updateStatus=SUCCESS&session.version=ab91e73001&successIndicator=a1b488a6898c458d";
	
	$result_params = explode('&', $result);
	$params = [];
	foreach($result_params as $param) {
		$param_name = explode('=', $param)[0] ?? false;
		$param_value = explode('=', $param)[1] ?? false;
		if($param_name && $param_value) $params[$param_name] = $param_value;
	}

	if($params['result'] == 'SUCCESS'){
		if(!empty($params['session.id']) && !empty($params['successIndicator'])){
			return view('main.store.buyer.hosted-session')->with([
				'session_id' => $params['session.id'],
				'successIndicator' => $params['successIndicator'],
			]);
		}
	}
	dd('An Error Occured');
});
