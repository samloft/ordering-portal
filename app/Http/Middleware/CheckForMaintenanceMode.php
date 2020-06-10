<?php

namespace App\Http\Middleware;

use App\Models\GlobalSettings;
use Artisan;
use Closure;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode as Middleware;

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
        $maintenance = json_decode(GlobalSettings::key('maintenance'), true);

        if ($this->app->isDownForMaintenance()) {
            if (! $maintenance['enabled']) {
                Artisan::call('up');

                return $next($request);
            }

            return $this->enableMaintenance($request, $next);
        }

        if ($maintenance['enabled']) {
            Artisan::call('down --message="'.$maintenance['message'].'"');
        }

        return $next($request);
    }

    /**
     * @param $request
     * @param $next
     *
     * @return mixed
     */
    public function enableMaintenance($request, $next)
    {
        $data = json_decode(file_get_contents($this->app->storagePath().'/framework/down'), true);

        if ($this->inExceptArray($request)) {
            return $next($request);
        }

        throw new MaintenanceModeException($data['time'], $data['retry'], $data['message']);
    }
}
