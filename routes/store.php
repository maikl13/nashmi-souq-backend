<?php

// ====================================================================
// * Sellers Routes
// ====================================================================
Route::group(['middleware' => ['auth', 'active']], function () {
	Route::get('stores/new', 'StoreController@create');
    Route::get('stores/edit', 'StoreController@edit');
	Route::put('stores/edit', 'StoreController@update');
});

Route::domain('{store}.'.config('app.domain'))->middleware(['auth', 'active'])->prefix('dashboard')->group(function () {
    Route::get('/', 'StoreController@dashboard');

});


// ====================================================================
// * Buyers Routes
// ====================================================================
Route::group(['middleware' => ['auth', 'active']], function () {
    //
});

// ====================================================================
// * Visitors Routes
// ====================================================================
Route::get('stores', 'StoreController@index');
Route::get('stores/pricing', 'StoreController@pricing');