<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\GlobalSettings;
use App\Models\HomeLink;
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

        view()->composer('layout.master', static function ($view) {
            $view->with('announcement', GlobalSettings::siteAnnouncement());
        });

        view()->composer('products.sidebar', static function ($view) {
            $view->with('category_list', Category::list());
        });

        view()->composer(['layout.footer', 'contact.index'], static function ($view) {
            if (! Cache::has('company_details')) {
                Cache::rememberForever('company_details', static function () {
                    return GlobalSettings::where('key', 'company-details')->first()->value;
                });
            }

            $view->with('company_details', json_decode(Cache::get('company_details'), true));
        });

        view()->composer('home.categories', static function ($view) {
            $links = [
                'categories' => HomeLink::categories(),
            ];

            $view->with('links', $links);
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
