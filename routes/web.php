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

use App\Models\Basket;
use App\Models\Customer;
use Illuminate\Http\Request;

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

        Route::get('autocomplete/{search}', function ($search) {
            return App\Models\Products::autocomplete($search);
        });

        Route::get('{cat1?}/{cat2?}/{cat3?}', 'ProductController@index')->name('products');
    });

    Route::group(['prefix' => 'category'], function () {
        Route::get('image/{products}', function ($products) {
            return App\Models\Products::checkImage($products);
        })->name('products.check-image');
    });

    /*
     * Customer code auto complete.
     */
    Route::post('customer/autocomplete', function(Request $request) {
        return Customer::autocomplete($request->customer);
    })->name('customer.autocomplete');

    /*
     * Order Tracking
     */
    Route::group(['prefix' => 'order-tracking'], function () {
        Route::get('/', 'OrderTrackingController@index')->name('order-tracking');
        Route::get('order/{order}', 'OrderTrackingController@show')->name('order-tracking.show');
        Route::get('copy/{order}', 'OrderTrackingController@copy')->name('order-tracking.copy-to-basket');

        Route::get('invoice/{order}/{customer_order}/{download?}', 'OrderTrackingController@invoicePdf')->name('order-tracking.invoice-pdf');
    });

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
        Route::get('view', 'SavedBasketController@show')->name('saved-baskets.show');
        Route::post('store', 'SavedBasketController@store')->name('saved-baskets.store');
        Route::get('delete', 'SavedBasketController@destroy')->name('saved-baskets.destroy');
        Route::get('copy/{id}', 'SavedBasketController@copyToBasket')->name('saved-baskets.copy');
    });

    /*
     * Reports
     */
    Route::group(['prefix' => 'reports'], function () {
        Route::get('/', 'ReportController@index')->name('reports');
        Route::post('show', 'ReportController@show')->name('reports.show');
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

        Route::group(['prefix' => 'customer'], function () {
            Route::post('change', 'AccountController@changeCustomer')->name('customer.change');
            Route::get('revert', 'AccountController@revertChangeCustomer')->name('customer.change.revert');
        });
    });

    /*
     * Basket
     */
    Route::group(['prefix' => 'basket'], function () {
        Route::get('/', 'BasketController@index')->name('basket');
        Route::get('empty', 'BasketController@clear')->name('basket.empty');

        Route::post('add-product', 'BasketController@addProduct')->name('basket.add-product');
        Route::post('delete-product', 'BasketController@removeProduct')->name('basket.delete-line');
        Route::post('update-product', 'BasketController@updateProductQuantity')->name('basket.update-line');

        Route::get('summary/{shipping_value?}', function ($shipping_value) {
            return Basket::show($shipping_value);
        })->name('basket.summary');

        Route::get('dropdown', function () {
            return Basket::show();
        })->name('basket.dropdown');
    });

    /*
     * Checkout
     */
    Route::group(['prefix' => 'checkout'], function () {
        Route::get('/', 'CheckoutController@index')->name('checkout');
        Route::post('order', 'CheckoutController@store')->name('checkout.order');
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
