<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\GlobalSettings;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        view()->composer('products.sidebar', static function ($view) {
            $view->with('category_list', Category::list());
        });

        view()->composer(['layout.footer', 'contact.index'], static function ($view) {
            if (!Cache::has('company_details')) {
                Cache::rememberForever('company_details', static function () {
                    return GlobalSettings::where('key', 'company-details')->first()->value;
                });
            }

            $view->with('company_details', json_decode(Cache::get('company_details'), true));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
