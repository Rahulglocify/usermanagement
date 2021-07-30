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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');


#Mobile Verify by firebase
Route::get('mobile-verify', 'App\Http\Controllers\ProfileController@mobileNoVerify')->name('mobile-verify');

Route::any('send-notification', 'App\Http\Controllers\ProfileController@sendNotification')->name('send-notification');
Route::group(['middleware' => ['auth', 'CheckMobileNoVerified']], function () {
    Route::get('users', 'App\Http\Controllers\ProfileController@users')->name('users');
    Route::get('dashboard', 'App\Http\Controllers\ProfileController@dashboard')->name('dashboard');
    Route::post('dashboard', 'App\Http\Controllers\ProfileController@updateProfile')->name('update-profile');
    Route::get('google-autocomplete', 'App\Http\Controllers\ProfileController@googleautocomplete')->name('google-autocomplete');

    #Mobile No update with status
    Route::post('mobile-no-update', 'App\Http\Controllers\ProfileController@mobileNoUpdate')->name('mobile-no-update');

    #Web Push Notification
    Route::post('save-token', 'App\Http\Controllers\ProfileController@saveToken')->name('save-token');

    #Social Share
    Route::get('social-share', 'App\Http\Controllers\ProfileController@socialShare')->name('social-share');
    
    #Calender
    Route::get('fullcalender', 'App\Http\Controllers\ProfileController@fullcalender')->name('fullcalender');
    Route::post('fullcalender', 'App\Http\Controllers\ProfileController@postCalender')->name('fullcalender');

    #gallery
    Route::get('gallery', 'App\Http\Controllers\ProfileController@gallery')->name('gallery');
    Route::get('add-gallery', 'App\Http\Controllers\ProfileController@addGallery')->name('add-gallery');
    Route::post('add-gallery', 'App\Http\Controllers\ProfileController@postGallery')->name('post-gallery');

    #webcam & camera
    Route::get('webcam', 'App\Http\Controllers\ProfileController@webcam')->name('webcam');
    Route::post('webcam', 'App\Http\Controllers\ProfileController@postWebcam')->name('post-webcam');
});

require __DIR__ . '/auth.php';
