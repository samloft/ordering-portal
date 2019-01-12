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
        Route::get('view/{product}', 'ProductController@show')->name('products.show');
        Route::get('search', 'ProductController@search')->name('products.search');
        Route::get('{cat1?}/{cat2?}/{cat3?}', 'ProductController@index')->name('products');
    });

    /*
     * Order Tracking
     */
    Route::get('order-tracking', 'OrderTrackingController@index')->name('order-tracking');

    /*
     * Order Upload
     */
    Route::group(['prefix' => 'upload'], function () {
        Route::get('/', 'UploadController@index')->name('upload');
        Route::post('validation', 'UploadController@validation')->name('upload-validate');
        Route::get('completed', 'UploadController@store')->name('upload-completed');
    });

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
    Route::group(['prefix' => 'account'], function () {
        Route::get('/', 'AccountController@index')->name('account');
        Route::post('store', 'AccountController@store')->name('account.store');

        Route::group(['prefix' => 'password'], function () {
            Route::get('/', 'Account\PasswordController@index')->name('account.password');
            Route::patch('store', 'Account\PasswordController@store')->name('account.password.store');
        });

        Route::group(['prefix' => 'addresses'], function () {
            Route::get('/', 'Account\AddressController@index')->name('account.addresses');
            Route::get('create', 'Account\AddressController@create')->name('account.address.create');
            Route::patch('store', 'Account\AddressController@store')->name('account.address.store');
            Route::get('{id}/edit', 'Account\AddressController@edit')->name('account.address.edit');
            Route::patch('{id}/edit', 'Account\AddressController@update')->name('account.address.update');
            Route::post('default', 'Account\AddressController@default')->name('account.address.default');
            Route::get('{id}/delete', 'Account\AddressController@destroy')->name('account.address.destroy');
        });
    });

    /*
     * Basket
     */
    Route::group(['prefix' => 'basket'], function () {
        Route::get('/', 'BasketController@index')->name('basket');
        Route::get('empty', 'BasketController@clear')->name('basket.empty');
    });

    /*
     * Checkout
     */
    Route::group(['prefix' => 'checkout'], function () {
        Route::get('/', 'CheckoutController@index')->name('checkout');
    });
});

/* Contact Page */
Route::group(['prefix' => 'contact'], function () {
    Route::get('/', 'Support\ContactController@index')->name('support.contact');
});


Auth::routes();

Route::get('new-products', 'Auth\LoginController@loginContent')->name('login.content');

Route::fallback(function () {
    return view('errors.404');
});
