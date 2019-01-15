<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class SiteAdmin
{
    /**
     * Checks if the user is a site admin. Meaning that can change customer on the fly.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user() && Auth::user()->admin == 1) {
            return $next($request);
        }

        return redirect('/');
    }
}
