<?php

namespace App\Http\Middleware;

use App\Models\GlobalSettings;
use Closure;

class TermsAccepted
{
    /**
     * Handle an incoming request.
     * Check to see if a user has accepted the site terms. If not redirect
     * them to a page where they can accept it.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $enabled = GlobalSettings::termsEnabled()['enabled'];
        $route = request()->route()->getName();

        if (! preg_match('/\bsite-terms\b/', $route) && $enabled && ! auth()->user()->terms_accepted) {
            return redirect(route('site-terms'));
        }

        return $next($request);
    }
}
