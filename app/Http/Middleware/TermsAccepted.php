<?php

namespace App\Http\Middleware;

use Closure;

class TermsAccepted
{
    /**
     * Handle an incoming request.
     *
     * Check to see if a user has accepted the site terms. If not redirect
     * them to a page where they can accept it.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! auth()->guest() && $request->route()->getPrefix() !== 'cms' && $request->route()->getName() !== 'site-terms.accept') {
            if (auth()->user()->terms_accepted && $request->route()->getName() === 'site-terms') {
                return redirect(route('home'));
            }

            if (! auth()->user()->terms_accepted && $request->route()->getName() !== 'site-terms') {
                return redirect(route('site-terms'));
            }
        }

        return $next($request);
    }
}
