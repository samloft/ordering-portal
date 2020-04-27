<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class SiteAdmin
{
    /**
     * Checks if the user is a site admin. Meaning that can change customer on the fly.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user() && auth()->user()->admin === 1) {
            return $next($request);
        }

        return redirect('/');
    }
}
