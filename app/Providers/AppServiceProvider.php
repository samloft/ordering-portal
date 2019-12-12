<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\GlobalSettings;
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

        view()->composer('products.sidebar', static function($view) {
            $view->with('category_list', Category::list());
        });

        view()->composer('layout.footer', static function($view) {
            $view->with('company_details', json_decode(GlobalSettings::where('key', 'company-details')->first()->value, true));
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
