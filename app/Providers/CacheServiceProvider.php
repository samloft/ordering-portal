<?php

namespace App\Providers;

use DB;
use Illuminate\Cache\RedisStore;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class CacheServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Cache::extend('redis_tenancy', function ($app) {
            if (PHP_SAPI === 'cli') {
                $uuid = $app['config']['driver'];
            } else {
                // ok, this is basically a hack to set the redis cache store
                // prefix to the UUID of the current website being called
                $fqdn = request()->getHost();

                $uuid = DB::table('hostnames')
                    ->select('websites.uuid')
                    ->join('websites', 'hostnames.website_id', '=', 'websites.id')
                    ->where('fqdn', $fqdn)
                    ->value('uuid');
            }

            return Cache::repository(new RedisStore(
                $app['redis'],
                $uuid,
                $app['config']['cache.stores.redis.connection']
            ));
        });
    }
}
