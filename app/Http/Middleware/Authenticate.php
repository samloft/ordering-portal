<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Route;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return string
     */
    protected function redirectTo($request): string
    {
        if (! $request->expectsJson()) {
            if (Route::is('cms.*')) {
                return route('cms.login');
            }

            return route('login');
        }

        return response()->json('Not authenticated', 401);
    }
}
