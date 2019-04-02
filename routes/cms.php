<?php

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
            return \App\Models\HomeLinks::show($request->id);
        })->name('cms.home-links.show');
    });

    /* Product images */
    Route::group(['prefix' => 'product-images'], function () {
        Route::get('/', 'Cms\ProductImageController@index')->name('cms.product-images');
        Route::post('check', 'Cms\ProductImageController@missingImages')->name('cms.product-images.check');
        Route::post('store', 'Cms\ProductImageController@store')->name('cms.product-images.store');
    });

});