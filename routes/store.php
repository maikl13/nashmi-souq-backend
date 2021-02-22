<?php

// ====================================================================
// * Sellers Routes
// ====================================================================
Route::domain(config('app.domain'))->middleware(['auth'])->group(function () {
	Route::get('stores/new', 'StoreController@create');
	Route::put('stores/new', 'StoreController@update');
});

Route::domain(config('app.domain'))->middleware(['auth', 'store'])->group(function () {
	Route::get('categories', 'StoreController@categories')->name('store-categories');
	Route::put('categories', 'StoreController@store_categories')->name('store-categories.store');
});

Route::domain('{store}.'.config('app.domain'))->middleware(['auth', 'mystore'])->group(function () {
	Route::middleware(['active', 'store'])->group(function () {
		Route::get('subscribe', 'SubscriptionController@subscribe')->name('subscribe');
		Route::post('subscribe', 'SubscriptionController@store')->name('subscription.store');
		Route::get('subscribed', 'SubscriptionController@subscribed')->name('subscribed');
	});
	Route::middleware(['active', 'store'])->prefix('dashboard')->group(function () {
		Route::get('subscriptions', 'SubscriptionController@index')->name('subscriptions');
	});

	Route::middleware(['active-store'])->prefix('dashboard')->group(function () {
		Route::get('/', 'StoreController@dashboard')->name('store-dashboard');
		
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

		Route::get('promotions', 'PromotionController@index');
		Route::post('promotions', 'PromotionController@store');
		Route::delete('promotions/{promotion}', 'PromotionController@destroy');
	});
});


// ====================================================================
// * Buyers Routes
// ====================================================================
Route::domain('{store}.'.config('app.domain'))->middleware(['active-store'])->group(function () {
	Route::post('cart/add', 'CartController@store');
	Route::get('cart/update-dropdown', 'CartController@update_cart_dropdown');
	Route::get('cart', 'CartController@index')->name('cart');
	Route::delete('cart/{product_id}/remove', 'CartController@remove_from_cart');
	Route::post('cart/update-quantity', 'CartController@update_product_quantity');
	Route::get('cart/update-totals', 'CartController@update_totals');
});
Route::get('payment-result', 'TransactionController@payment_result');
Route::get('paypal-payment-result', 'TransactionController@paypal_payment_result');
Route::domain('{store}.'.config('app.domain'))->middleware(['auth', 'store'])->group(function () {
	Route::get('payment-result', 'TransactionController@payment_result');
	Route::get('paypal-payment-result', 'TransactionController@paypal_payment_result');
});
Route::domain('{store}.'.config('app.domain'))->middleware(['auth', 'active-store'])->group(function () {
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
	Route::get('/unavailable', 'StoreController@unavailable')->name('store-unavailable');
});
Route::domain('{store}.'.config('app.domain'))->middleware(['active-store'])->group(function () {
	Route::get('/', 'StoreController@home')->name('store-home');
	Route::get('products', 'ProductController@list');
	Route::get('products/{product}', 'ProductController@show');
});