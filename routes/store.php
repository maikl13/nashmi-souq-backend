<?php

// ====================================================================
// * Sellers Routes
// ====================================================================
Route::group(['middleware' => ['auth']], function () {
	Route::get('stores/new', 'StoreController@create');
	Route::put('stores/new', 'StoreController@update');
});

Route::domain('{store}.'.config('app.domain'))->group(function () {
	Route::middleware(['auth', 'active', 'store'])->prefix('dashboard')->group(function () {
		Route::get('subscribe', 'SubscriptionController@subscribe')->name('subscribe');
	});

	Route::middleware(['auth', 'active-store'])->prefix('dashboard')->group(function () {
		Route::get('/', 'StoreController@dashboard');
		
		Route::get('store-settings', 'StoreController@edit');
		Route::put('store-settings', 'StoreController@update');
		Route::resource('products', 'ProductController');
		Route::post('products/{product}/delete-image', 'ProductController@delete_product_image');
	
		Route::get('orders', 'OrderController@orders')->name('orders');
		Route::get('orders/{package}', 'OrderController@show_for_store');
		Route::post('orders/change-status', 'OrderController@change_status');
		Route::post('orders/get-shipping', 'OrderController@get_shipping');
		Route::post('orders/get-status', 'OrderController@get_status');
		Route::post('orders/get-status-updates-log', 'OrderController@get_status_updates_log');
	});
});




// ====================================================================
// * Buyers Routes
// ====================================================================
Route::domain('{store}.'.config('app.domain'))->middleware(['auth'])->group(function () {
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
});

// ====================================================================
// * Visitors Routes
// ====================================================================
Route::get('stores', 'StoreController@index');
Route::get('stores/pricing', 'StoreController@pricing');

Route::domain('{store}.'.config('app.domain'))->group(function () {
	Route::get('/', 'StoreController@home')->name('store-home');
	Route::get('products', 'ProductController@list');
	Route::get('products/{product}', 'ProductController@show');
});