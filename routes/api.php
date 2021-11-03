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

Route::get('categories', 'CategoryController@index');

Route::get('get_sub_categories/{id}', 'CategoryController@sub_categories');
Route::get('get_categories/{id}/options', 'CategoryController@category_options');
Route::get('listing_types', 'CategoryController@listing_types');
Route::get('listing_states', 'CategoryController@listing_states');
Route::post('listings', 'ListingsController@index');
Route::post('search_listings', 'ListingsController@search_listings');
Route::get('related_listings/{id}', 'ListingsController@related_listings');
Route::get('category_listings/{id}', 'ListingsController@category_listings');
Route::get('sub_category_listings/{id}', 'ListingsController@sub_category_listings');
Route::get('brands', 'CategoryController@brands');
Route::get('category_brands/{id}', 'CategoryController@category_brands');
Route::get('models_brand/{id}', 'CategoryController@models_brand');
Route::get('user_listings/{id}', 'ListingsController@user_listings');
Route::get('country_listings/{code}', 'ListingsController@country_listings');
Route::get('countries', 'CountryController@index');
Route::get('areas/{id}', 'CountryController@areas');
Route::get('settings', 'settingsController@index');
Route::get('stores_pricing', 'StoreController@pricing');
Route::post('login', 'UserController@login');
Route::get('stores', 'StoreController@list_stores');
Route::post('register_by_email', 'UserController@register_by_email');
Route::post('register_by_whatsapp', 'UserController@register_by_whatsapp');
Route::get('list_store_products/{id}', 'StoreController@list_store_products');
Route::post('search_store_products/{id}', 'StoreController@search_store_products');
Route::group(['middleware'=>'auth:api'],function(){
    Route::get('my_listings', 'UserController@my_listings');
    Route::post('update_account', 'UserController@update');
    Route::post('change_password', 'UserController@change_password');
     Route::post('add_listing', 'UserController@add_listing');
     Route::post('delete_listing/{id}', 'UserController@destroy');
     Route::post('edit_listing/{id}', 'UserController@edit');
     Route::post('delete_listing_image/{id}', 'UserController@delete_listing_image');
     Route::post('update_payout_methods', 'UserController@update_payout_methods');
    Route::post('add_comment', 'UserController@add_comment');
    Route::post('edit_comment/{id}', 'UserController@edit_comment');
	Route::post('delete_comment/{id}', 'UserController@destroy_comment');
    Route::post('send_message', 'UserController@send_message');
    Route::get('get_conversation/{user}', 'UserController@get_conversation');
    Route::get('get_conversations', 'UserController@get_conversations');
    Route::get('get_unseen_messages_count', 'UserController@get_unseen_messages_count');
    Route::post('create_store', 'StoreController@create_update_store');
    Route::post('store_categories', 'StoreController@store_categories')->middleware('store_api');
    Route::post('update_store', 'StoreController@create_update_store');
    Route::post('delete_store_banner', 'StoreController@delete_store_banner');
    Route::post('delete_store_logo', 'StoreController@delete_store_logo');
    Route::get('store_subscriptions', 'StoreController@store_subscriptions')->middleware('store_api');
    Route::get('store_products', 'StoreController@store_products')->middleware('store_api');
    Route::get('search_store_products', 'StoreController@search_store_products')->middleware('store_api');
    Route::post('create_store_product', 'StoreController@create_store_product')->middleware('store_api');
    Route::post('edit_store_product/{id}', 'StoreController@edit_store_product')->middleware('store_api');
    Route::post('delete_store_product/{id}', 'StoreController@delete_store_product')->middleware('store_api');
    Route::post('delete_product_image/{id}', 'StoreController@delete_product_image')->middleware('store_api');
    Route::get('promotions', 'StoreController@promotions')->middleware('store_api');
    Route::get('store_promotions', 'StoreController@store_promotions')->middleware('store_api');
    Route::post('create_store_promotion', 'StoreController@create_store_promotion')->middleware('store_api');
    Route::post('delete_promotions/{id}', 'StoreController@delete_promotions')->middleware('store_api');
    
});

/*
Route::get('states/{state}/areas', 'StateController@areas');

Route::get('categories/{category}/options', 'CategoryController@category_options');
Route::get('sub-categories/{sub_category}/options', 'CategoryController@sub_category_options');
*/


// الكود ده مهم للفرونت اند :)
Route::namespace('\App\Http\Controllers\Admin')->group(function () {
	Route::get('categories/{category}/sub-categories', '\App\Http\Controllers\Admin\CategoryController@sub_categories');
	Route::get('states/{state}/areas', '\App\Http\Controllers\Admin\StateController@areas');

	Route::get('categories/{category}/options', '\App\Http\Controllers\Admin\CategoryController@category_options');
	Route::get('sub-categories/{sub_category}/options', '\App\Http\Controllers\Admin\CategoryController@sub_category_options');
});
