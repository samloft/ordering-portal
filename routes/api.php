<?php

use App\Models\Product;

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

Route::group(['middleware' => 'auth:api', 'prefix' => 'v1'], static function () {
    Route::get('user', static function () {
        return auth()->user();
    });

    Route::get('product', static function () {
        return Product::details(request('product'));
    });
});

/*
 * API routes that require no authentication.
 */

Route::get('version', static function () {
    return [
        'foo' => 'bar'
    ];
});
