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

Route::group(['middleware' => ['auth', 'has.customer']], function () {
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

    /*
     * User Account
    */
    Route::group(['prefix' => 'account'], function() {
        Route::get('/', 'AccountController@index')->name('account');
        Route::post('store', 'AccountController@store')->name('account.store');

        Route::get('password', 'AccountController@password')->name('account.password');
        Route::post('password-change', 'AccountController@storePassword')->name('account.password.store');

        Route::get('addresses', 'AccountController@addresses')->name('account.addresses');
        Route::get('address/{id?}', 'AccountController@showAddress')->name('account.address.show');
        Route::post('address/store', 'AccountController@storeAddress')->name('account.address.store');
        Route::post('address/default/', 'AccountController@setDefault')->name('account.address.default');
    });
});

/* Contact Page */
Route::group(['prefix' => 'contact'], function () {
    Route::get('/', 'Support\ContactController@index')->name('support.contact');
});


Auth::routes();

Route::get('new-products', 'Auth\LoginController@loginContent')->name('login.content');
