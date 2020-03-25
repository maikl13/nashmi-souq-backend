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
// * Guests Routes
// ====================================================================

Route::namespace('\App\Http\Controllers')->group(function () {
    Auth::routes();
});

Route::get('/', 'MainController@index')->name('home');
Route::get('/deactivated', 'MainController@deactivated')->name('deactivated');



// ====================================================================
// * Authenticated Users Routes
// ====================================================================
Route::group(['middleware' => 'auth'], function () {
	Route::post('profile-picture/delete', 'UserController@delete_profile_picture');

	Route::get('account', 'UserController@edit');
	Route::put('account/edit', 'UserController@update');

});