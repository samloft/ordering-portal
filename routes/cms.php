<?php

/*
|--------------------------------------------------------------------------
| CMS Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your CMS routes
| for the administration area of the website. Located on the cms. sub-domain.
|
*/

Route::get('/', 'Cms\HomeController@index')->name('cms.index');
Route::get('login', 'Auth\AdminController@showLoginForm')->name('cms.login');
Route::post('login', 'Auth\AdminController@login')->name('cms.login.submit');
Route::post('logout', 'Auth\AdminController@logout')->name('cms.logout');