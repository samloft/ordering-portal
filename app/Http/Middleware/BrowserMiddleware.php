<?php

namespace App\Http\Middleware;

use Closure;

class BrowserMiddleware
{
    /**
     * Check the users browser version, if the browser is less than IE11, show error page.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (env('APP_ENV') === 'testing') {
            return $next($request);
        }

        if (request()->route()->getName() !== 'not-supported') {
            if (preg_match('~MSIE|Internet Explorer~i', $_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0; rv:11.0') !== true)) {
                return redirect(route('not-supported'));
            }
        }

        return $next($request);
    }
}
