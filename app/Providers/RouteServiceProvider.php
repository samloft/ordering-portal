<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map(): void
    {
        $this->mapApiRoutes();

        $this->mapCmsRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/web.php'));
    }

    /**
     * Define the "cms" routes for the application.
     *
     * These routes are on a sub-domain.
     *
     * @return void
     */
    protected function mapCmsRoutes(): void
    {
        //Route::domain($this->baseDomain('cms'))
        //    ->middleware('web')
        //    ->namespace($this->namespace)
        //    ->group(base_path('routes/cms.php'));

        Route::prefix('cms')->middleware('web')->namespace($this->namespace)->group(base_path('routes/cms.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')->middleware('api')->namespace($this->namespace)->group(base_path('routes/api.php'));
    }

    /**
     * Appends the given sub-domain to the main domain.
     *
     * @param string $sub_domain
     *
     * @return string
     */
    private function baseDomain(string $sub_domain = ''): string
    {
        if (strlen($sub_domain) > 0) {
            $sub_domain = "{$sub_domain}.";
        }

        return $sub_domain.config('app.base_domain');
    }
}
