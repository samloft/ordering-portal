<?php

use App\Models\Products;
use Illuminate\Http\Request;

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

Route::group(['middleware' => 'auth:api', 'prefix' => 'v1'], function () {
    Route::get('user', function() {
        return request()->user();
    });

    Route::get('product', function() {
        return Products::details(request('product'));
    });
});

/*
 * API routes that require no authentication.
 */

Route::get('version', function() {
    return [
        'version' => Version::major() . '.' . Version::minor() . '.' . Version::patch(),
        'build' => Version::build()
    ];
});
