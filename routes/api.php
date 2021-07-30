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

Route::post('register', 'App\Http\Controllers\Api\UserController@register')->name('register');
Route::post('login', 'App\Http\Controllers\Api\UserController@login')->name('login');
Route::get('users', 'App\Http\Controllers\Api\UserController@users')->name('users');
Route::post('edit-user', 'App\Http\Controllers\Api\UserController@editUsers')->name('edit.user');
Route::post('delete-user', 'App\Http\Controllers\Api\UserController@deleteUsers')->name('delete.user');
Route::post('update-user', 'App\Http\Controllers\Api\UserController@updateUser')->name('update.user');
Route::post('contact-us','App\Http\Controllers\Api\UserController@contactus')->name('contact-us');

#Product
Route::post('product', 'App\Http\Controllers\Api\ProductController@product')->name('product');
Route::get('product-list', 'App\Http\Controllers\Api\ProductController@productList')->name('product.list');
Route::post('product-delete', 'App\Http\Controllers\Api\ProductController@productDelete')->name('product.delete');
Route::get('product-details/{id}', 'App\Http\Controllers\Api\ProductController@productDetails')->name('product.details');
Route::post('update-product', 'App\Http\Controllers\Api\ProductController@updateProduct')->name('update.product');
Route::post('search', 'App\Http\Controllers\Api\ProductController@search')->name('search');

#Newsletter
Route::post('newsletter', 'App\Http\Controllers\Api\IndexController@newsletter')->name('newsletter');