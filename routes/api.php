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

Route::namespace('\App\Http\Controllers\Admin')->group(function () {
	Route::get('categories/{category}/sub-categories', 'CategoryController@sub_categories');
	Route::get('states/{state}/areas', 'StateController@areas');

	Route::get('categories/{category}/options', 'CategoryController@category_options');
	Route::get('sub-categories/{sub_category}/options', 'CategoryController@sub_category_options');
});
