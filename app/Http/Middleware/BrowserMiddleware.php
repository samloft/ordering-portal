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
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ((request()->route()->uri !== 'not-supported') && preg_match('~MSIE|Internet Explorer~i', $this->getUserAgent()) && (strpos($this->getUserAgent(), 'Trident/7.0; rv:11.0') !== true)) {
            return redirect(route('not-supported'));
        }

        return $next($request);
    }

    /**
     * @return mixed
     */
    public function getUserAgent()
    {
        return request()->header('user-agent');
    }
}
