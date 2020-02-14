<?php

use App\Models\Category;
use App\Models\Customer;
use App\Models\GlobalSettings;
use App\Models\UserCustomer;

/*
|--------------------------------------------------------------------------
| CMS Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your CMS routes
| for the administration area of the website. Located on the cms. sub-domain.
|
*/

Route::get('login', 'Auth\AdminController@showLoginForm')->name('cms.login');
Route::post('login', 'Auth\AdminController@login')->name('cms.login.submit');
Route::get('password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('cms.forgot-password');
Route::post('password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('cms.password-email');
Route::get('password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('cms.password.reset');
Route::post('password/reset', 'Auth\AdminResetPasswordController@reset')->name('cms.password.update');

Route::group(['middleware' => 'auth:admin'], static function () {
    Route::post('logout', 'Auth\AdminController@logout')->name('cms.logout');
    Route::get('/', 'Cms\HomeController@index')->name('cms.index');

    Route::group(['prefix' => 'site-users'], static function () {
        Route::get('/', 'Cms\UserController@index')->name('cms.site-users');
        Route::post('/', 'Cms\UserController@store')->name('cms.site-users.store');
        Route::post('password-reset', 'Cms\UserController@passwordReset')->name('cms.site-users.password-reset');

        Route::delete('extra-customers', static function () {
            return UserCustomer::destroy(request('id'));
        })->name('cms.extra-customers.destroy');

        Route::post('extra-customers', static function () {
            return UserCustomer::store();
        })->name('cms.extra-customers.store');

        Route::patch('{id}', 'Cms\UserController@update')->name('cms.site-users.update');
        Route::delete('{id}', 'Cms\UserController@destroy')->name('cms.site-users.destroy');
    });

    Route::group(['prefix' => 'admin-users'], static function () {
        Route::get('/', 'Cms\AdminController@index')->name('cms.admin-users');
        Route::post('/', 'Cms\AdminController@store')->name('cms.admin-users.store');
        Route::delete('{id}', 'Cms\AdminController@destroy')->name('cms.admin-users.destroy');
        Route::patch('{id}', 'Cms\AdminController@update')->name('cms.admin-users.update');
    });

    Route::group(['prefix' => 'company-information'], static function () {
        Route::get('/', 'Cms\CompanyDetailsController@index')->name('cms.company-information');
        Route::post('/', 'Cms\CompanyDetailsController@store')->name('cms.company-information.store');
    });

    Route::group(['prefix' => 'contacts'], static function () {
        Route::get('/', 'Cms\ContactController@index')->name('cms.contacts');
        Route::post('/', 'Cms\ContactController@store')->name('cms.contacts.store');
        Route::patch('{contact}', 'Cms\ContactController@update')->name('cms.contacts.update');
        Route::delete('{contact}', 'Cms\ContactController@destroy')->name('cms.contacts.delete');
    });

    Route::group(['prefix' => 'site-settings'], static function () {
        Route::get('/', 'Cms\SiteSettingsController@index')->name('cms.site-settings');

        Route::patch('maintenance', static function () {
            return GlobalSettings::where('key', 'maintenance')->update([
                'value' => json_encode(['enabled' => request('enabled'), 'message' => request('message')], true)
            ]);
        })->name('cms.site-settings');
    });

    Route::group(['prefix' => 'home-links'], static function () {
        Route::get('/', 'Cms\HomeLinksController@index')->name('cms.home-links');
        Route::post('/', 'Cms\HomeLinksController@store')->name('cms.home-links.store');
        Route::patch('/update-positions', 'Cms\HomeLinksController@updatePositions')->name('cms.home-links.update');

        Route::post('/categories/{level_1}/{level_2?}/{level_3?}', static function (
            $level_1,
            $level_2 = null,
            $level_3 = null
        ) {
            return Category::showLevels($level_1, $level_2, $level_3);
        });

        Route::delete('{id}', 'Cms\HomeLinksController@destroy')->name('cms.home-links.delete');
    });

    Route::group(['prefix' => 'small-order'], static function () {
        Route::get('/', 'Cms\SmallOrderChargeController@index')->name('cms.small-order');
        Route::post('/', 'Cms\SmallOrderChargeController@update')->name('cms.small-order.update');
    });

    Route::group(['prefix' => 'discounts'], static function () {
        Route::get('/', 'Cms\DiscountsController@index')->name('cms.discounts');
        Route::post('/', 'Cms\DiscountsController@globalStore')->name('cms.discounts.global-store');
        Route::post('customer', 'Cms\DiscountsController@store')->name('cms.discounts.customer-store');
        Route::delete('customer/{id}', 'Cms\DiscountsController@destroy')->name('cms.discounts.customer-destroy');
    });

    Route::group(['prefix' => 'delivery-methods'], static function () {
        Route::get('/', 'Cms\DeliveryMethodsController@index')->name('cms.delivery-methods');
        Route::post('/', 'Cms\DeliveryMethodsController@store')->name('cms.delivery-methods.store');
        Route::delete('{deliveryMethod}', 'Cms\DeliveryMethodsController@destroy')->name('cms.delivery-methods.delete');
    });

    Route::group(['prefix' => 'product-images'], static function () {
        Route::get('/', 'Cms\ProductImageController@index')->name('cms.product-images');
        Route::get('missing', 'Cms\ProductImageController@missingImages')->name('cms.product-images.missing');
        Route::post('/', 'Cms\ProductImageController@store')->name('cms.product-images.store');
    });

    Route::group(['prefix' => 'customer'], static function () {
        Route::get('validate', static function () {
            return Customer::show(request('code'));
        });
    });
});
