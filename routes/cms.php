<?php

use App\Models\HomeLinks;
use App\Models\User;
use App\Models\UserCustomers;
use Illuminate\Http\Request;

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

Route::group(['middleware' => 'auth:admin'], function () {

    Route::post('logout', 'Auth\AdminController@logout')->name('cms.logout');

    Route::get('/', 'Cms\HomeController@index')->name('cms.index');

    Route::group(['prefix' => 'site-users'], function() {
        Route::get('/', 'Cms\UserController@index')->name('cms.site-users');
        Route::get('show/{id}', function($id) {
            return User::show($id);
        })->name('cms.site-users.show');
        Route::get('delete/{id}', 'Cms\UserController@destroy')->name('cms.site-users.destroy');
        Route::post('validate', 'Cms\UserController@validation')->name('cms.site-users.validate');
        Route::post('store', 'Cms\UserController@store')->name('cms.site-users.store');

        Route::post('extra-customers/destroy', function(Request $request) {
            return UserCustomers::destroy($request->id);
        })->name('cms.extra-customers.destroy');

        Route::post('extra-customers/store', function(Request $request) {
            return UserCustomers::store($request);
        })->name('cms.extra-customers.store');
    });

    Route::group(['prefix' => 'company-information'], function () {
        Route::get('/', 'Cms\CompanyDetailsController@index')->name('cms.company-information');
        Route::post('store', 'Cms\CompanyDetailsController@store')->name('cms.company-information.store');
    });

    Route::group(['prefix' => 'home-links'], function () {
        Route::get('/', 'Cms\HomeLinksController@index')->name('cms.home-links');
        Route::post('store', 'Cms\HomeLinksController@store')->name('cms.home-links.store');
        Route::post('update', 'Cms\HomeLinksController@updatePositions')->name('cms.home-links.update');
        Route::get('delete/{id}', 'Cms\HomeLinksController@destroy')->name('cms.home-links.delete');

        Route::post('show', function (Request $request) {
            return HomeLinks::show($request->id);
        })->name('cms.home-links.show');
    });

    /* Product images */
    Route::group(['prefix' => 'product-images'], function () {
        Route::get('/', 'Cms\ProductImageController@index')->name('cms.product-images');
        Route::post('check', 'Cms\ProductImageController@missingImages')->name('cms.product-images.check');
        Route::post('store', 'Cms\ProductImageController@store')->name('cms.product-images.store');
    });

});