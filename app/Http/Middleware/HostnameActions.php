<?php

namespace App\Http\Middleware;

use Closure;
use Hyn\Tenancy\Contracts\CurrentHostname;
use Illuminate\Http\Request;

class HostnameActions extends \Hyn\Tenancy\Middleware\HostnameActions
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function handle(Request $request, Closure $next)
    {
        $hostname = config('tenancy.hostname.auto-identification') ? app(CurrentHostname::class) : null;

        if ($hostname !== null) {
            if ($hostname->under_maintenance_since && ! $request->is('cms*')) {
                return $this->maintenance($hostname);
            }

            if ($hostname->redirect_to) {
                return $this->redirect($hostname);
            }

            if ($hostname->force_https && ! $request->secure()) {
                return $this->secure($hostname, $request);
            }
        } else {
            $this->abort($request);
        }

        return $next($request);
    }
}
