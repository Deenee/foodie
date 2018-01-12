<?php

use Illuminate\Http\Request;

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
// For Auth
Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');
Route::put('logout', 'AuthController@logout');

// For Vendor
Route::get('vendor', 'VendorsController@index');
Route::post('vendor', 'VendorsController@store');
Route::put('vendor/{id}', 'VendorsController@update');
Route::delete('vendor/{id}', 'VendorsController@destroy');

// For Menu
Route::get('menu', 'MenusController@index');
Route::post('menu', 'MenusController@store');
Route::get('menu/{id}', 'MenusController@index');
Route::put('menu/{id}', 'MenusController@update');
Route::delete('menu/{id}', 'MenusController@destroy');