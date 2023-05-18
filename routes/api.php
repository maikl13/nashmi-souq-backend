<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('contact-us', 'ContactMessageController@store');

Route::get('categories', 'CategoryController@index');

Route::get('get_sub_categories/{id}', 'CategoryController@sub_categories');
Route::get('get_categories/{id}/options', 'CategoryController@category_options');
Route::get('listing_types', 'CategoryController@listing_types');
Route::get('listing_states', 'CategoryController@listing_states');

Route::get('banners', 'CategoryController@banners');
Route::get('banners_by_country/{code}', 'CategoryController@banners_by_country');

Route::post('listings', 'ListingsController@index');
Route::get('listings/pinned_ads/{code}', 'ListingsController@pinned_ads');

// Route::post('search_listings', 'ListingsController@search_listings');
Route::post('search_listings/{code}', 'ListingsController@search_listings');
Route::get('currency', 'CurrencyController@index');
Route::get('users/list/{id}', 'UserController@listuser');
Route::get('related_listings/{id}', 'ListingsController@related_listings');
Route::get('category_listings/{id}', 'ListingsController@category_listings');
Route::get('sub_category_listings/{id}', 'ListingsController@sub_category_listings');
Route::get('brands', 'CategoryController@brands');
Route::get('category_brands/{id}', 'CategoryController@category_brands');
Route::get('models_brand/{id}', 'CategoryController@models_brand');
Route::get('user_listings/{id}', 'ListingsController@user_listings');
Route::get('id_listings/{id}', 'ListingsController@id_listings');
Route::get('country_listings/{code}', 'ListingsController@country_listings');
Route::get('countries', 'CountryController@index');
Route::get('areas/{id}', 'CountryController@areas');
Route::get('settings', 'settingsController@index');
Route::get('stores_pricing', 'StoreController@pricing');
Route::post('login', 'UserController@login');
Route::get('stores', 'StoreController@list_stores');
Route::post('register_by_email', 'UserController@register_by_email');
Route::post('register_by_whatsapp', 'UserController@register_by_whatsapp');

Route::post('forgetpassword', 'UserController@forgetpassword');
Route::post('resetpassword', 'UserController@reset');
Route::post('password/reset', 'UserController@sendOTP');

Route::get('list_store_products/{id}', 'StoreController@list_store_products');
Route::post('search_store_products/{id}', 'StoreController@search_store_products');
Route::get('show_product/{id}', 'StoreController@show_product');

// payment and account
Route::middleware(['auth:api', 'verified'])->group(function () {
    Route::get('account/membership_report/{code}', 'AccountsController@membership_report');
    Route::get('account/financial_transactions', 'AccountsController@financial_transactions');
    Route::put('account/update-payout-methods', 'AccountsController@payout');
});
Route::domain('{store}.'.config('app.domain'))->middleware(['active-store'])->group(function () {
    Route::get('products/{product}', 'ProductController@show');
});

Route::get('order/{order}/details', 'OrderController@show')->name('order-details');

Route::domain('{store}.'.config('app.domain'))->middleware(['auth:api', 'verified', 'active-store'])->group(function () {
    Route::post('checkout', 'CartController@checkout')->name('checkout');

    Route::post('order/new/{code}', 'OrderController@store');

    Route::get('order/new', 'OrderController@order_saved')->name('order-saved');

    Route::get('my-orders', 'OrderController@index')->name('my-orders');

    //	Route::get('order/{order}/details', 'OrderController@show')->name('order-details');

    Route::get('order/{package}/cancel', 'OrderController@cancel_order');

    Route::post('product/rate', 'ProductController@rate');

    Route::post('product/add-review', 'ProductController@add_review');

    Route::get('get-product-reviews', 'ProductController@get_reviews');

    Route::get('get-product-rate', 'ProductController@get_rate');
});

Route::domain('{store}.'.config('app.domain'))->middleware(['auth:api', 'active-store'])->group(function () {
    Route::post('cart/add/{code}', 'CartController@store');

    Route::get('cart/update-dropdown', 'CartController@update_cart_dropdown');

    Route::get('cart/index', 'CartController@index')->name('cart');

    Route::delete('cart/{product_id}/remove', 'CartController@remove_from_cart');

    Route::post('cart/update-quantity', 'CartController@update_product_quantity');

    Route::get('cart/update-totals', 'CartController@update_totals');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('my_listings', 'UserController@my_listings');
    Route::post('update_account', 'UserController@update');
    Route::post('change_password', 'UserController@change_password');
    Route::post('add_listing', 'UserController@add_listing');
    Route::post('delete_listing/{id}', 'UserController@destroy');
    Route::post('edit_listing/{id}', 'UserController@edit');
    Route::post('delete_listing_image/{id}', 'UserController@delete_listing_image');
    Route::post('update_payout_methods', 'UserController@update_payout_methods');
    Route::post('add_comment', 'UserController@add_comment');
    Route::post('listings/promote', 'ListingsController@promote');
    Route::get('feature/promote/{id}/{code}', 'ListingsController@featurepromote');
    Route::get('feature/promote/ads/{id}/{code}', 'ListingsController@pinads');

    Route::get('balance', 'direct_payment@add_balance_page');

    Route::post('balance/{code}', 'TransactionController@add_balance');

    Route::post('withdraw', 'TransactionController@withdraw');

    Route::get('direct-payment', 'TransactionController@direct_payment');

    Route::post('direct-payment', 'TransactionController@make_direct_payment');

    Route::get('payment-result', 'TransactionController@payment_result');

    Route::get('hyperpay-payment-result', 'TransactionController@hyperpay_payment_result')->name('hyperpay-payment-result');

    Route::post('edit_comment/{id}', 'UserController@edit_comment');
    Route::post('delete_comment/{id}', 'UserController@destroy_comment');
    Route::post('send_message', 'UserController@send_message');
    Route::get('get_conversation/{user}', 'UserController@get_conversation');
    Route::get('get_conversations', 'UserController@get_conversations');
    Route::get('get_unseen_messages_count', 'UserController@get_unseen_messages_count');
    Route::get('my-orders', 'UserController@my_orders');

    Route::post('create_store', 'StoreController@create_update_store');
    Route::post('store_categories', 'StoreController@store_categories')->middleware('store_api');
    Route::post('update_store', 'StoreController@create_update_store');
    Route::post('delete_store_banner', 'StoreController@delete_store_banner');
    Route::post('delete_store_logo', 'StoreController@delete_store_logo');
    Route::get('store_subscriptions', 'StoreController@store_subscriptions')->middleware('store_api');
    Route::get('store_products', 'StoreController@store_products')->middleware('store_api');
    Route::get('store_orders', 'StoreController@store_orders')->middleware('store_api');
    Route::get('search_store_products', 'StoreController@search_store_products')->middleware('store_api');
    Route::post('create_store_product', 'StoreController@create_store_product')->middleware('store_api');
    Route::post('edit_store_product/{id}', 'StoreController@edit_store_product')->middleware('store_api');
    Route::post('delete_store_product/{id}', 'StoreController@delete_store_product')->middleware('store_api');
    Route::post('delete_product_image/{id}', 'StoreController@delete_product_image')->middleware('store_api');
    Route::get('promotions', 'StoreController@promotions')->middleware('store_api');
    Route::get('store_promotions', 'StoreController@store_promotions')->middleware('store_api');
    Route::post('create_store_promotion', 'StoreController@create_store_promotion')->middleware('store_api');
    Route::post('delete_promotions/{id}', 'StoreController@delete_promotions')->middleware('store_api');
    Route::post('checkout', 'StoreController@checkout')->middleware('store_api');
});

/*
Route::get('states/{state}/areas', 'StateController@areas');

Route::get('categories/{category}/options', 'CategoryController@category_options');
Route::get('sub-categories/{sub_category}/options', 'CategoryController@sub_category_options');
*/

Route::namespace('\App\Http\Controllers\Admin')->group(function () {
    Route::get('categories/{category}/sub-categories', '\App\Http\Controllers\Admin\CategoryController@sub_categories');
    Route::get('states/{state}/areas', '\App\Http\Controllers\Admin\StateController@areas');

    Route::get('categories/{category}/options', '\App\Http\Controllers\Admin\CategoryController@category_options');
    Route::get('sub-categories/{sub_category}/options', '\App\Http\Controllers\Admin\CategoryController@sub_category_options');
});
