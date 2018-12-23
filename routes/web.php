<?php

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

Route::group(['middleware' => 'auth'], function () {
    /*
     *  Home Page
     */
    Route::get('/', 'HomeController@index')->name('home');

    /*
     *  Product Pages
     */
    Route::group(['prefix' => 'products'], function () {
        Route::get('/', 'ProductController@index')->name('products');
    });

    /*
     * Order Tracking
     */
    Route::get('order-tracking', 'OrderTrackingController@index')->name('order-tracking');

    /*
     * Order Upload
     */
    Route::get('upload', 'UploadController@index')->name('upload');

    /*
     * Saved Baskets
     */
    Route::group(['prefix' => 'saved-baskets'], function () {
        Route::get('/', 'SavedBasketController@index')->name('saved-baskets');
    });

    /*
     * Reports
     */
    Route::group(['prefix' => 'reports'], function () {
        Route::get('/', 'ReportController@index')->name('reports');
    });

    /*
     * Support pages
     */
    Route::group(['prefix' => 'support'], function () {

    });
});

/* Contact Page */
Route::group(['prefix' => 'contact'], function () {
    Route::get('/', 'Support\ContactController@index')->name('support.contact');
});


Auth::routes();

Route::get('new-products', 'Auth\LoginController@loginContent')->name('login.content');
