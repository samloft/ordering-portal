<?php

namespace App\Http\Middleware;

use App\Models\GlobalSettings;
use Artisan;
use Closure;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode as Middleware;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\IpUtils;

class CheckForMaintenanceMode extends Middleware
{
    /**
     * The URIs that should be reachable while maintenance mode is enabled.
     *
     * @var array
     */
    protected $except = [
        'cms*',
    ];

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function handle($request, Closure $next)
    {
        if (!App::environment('testing')) {
            $maintenance = json_decode(GlobalSettings::key('maintenance'), true);

            if ($maintenance['enabled'] && ! $this->app->isDownForMaintenance()) {
                Artisan::call('down --message="'.$maintenance['message'].'"');
            }

            if (! $maintenance['enabled'] && $this->app->isDownForMaintenance()) {
                Artisan::call('up');
            }

            if ($this->app->isDownForMaintenance()) {
                $data = json_decode(file_get_contents($this->app->storagePath().'/framework/down'), true);

                if (isset($data['allowed']) && IpUtils::checkIp($request->ip(), (array) $data['allowed'])) {
                    return $next($request);
                }

                if ($this->inExceptArray($request)) {
                    return $next($request);
                }

                throw new MaintenanceModeException($data['time'], $data['retry'], $data['message']);
            }
        }

        return $next($request);
    }
}
