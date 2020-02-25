<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * App\Models\GlobalSettings.
 *
 * @mixin \Eloquent
 */
class GlobalSettings extends Model
{
    protected $table = 'globals';

    /**
     * Forget all the cache keys regarding site settings.
     *
     * @return void
     */
    public function forgetSettingsCache(): void
    {
        Cache::forget('site-announcement');
        Cache::forget('checkout-notice');
        Cache::forget('google-maps-url');
        Cache::forget('google-analytics-url');
        Cache::forget('default-country');
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public static function key($key)
    {
        return self::where('key', $key)->first()->value;
    }

    /**
     * Get the global site discount that will be used if there
     * is no override created for the customer.
     *
     * @return mixed
     */
    public static function discount()
    {
        return Cache::rememberForever('discount', static function () {
            return self::where('key', 'discount')->first()->value;
        });
    }

    /**
     * Get the rules surrounding small order charges.
     *
     * @return mixed
     */
    public static function smallOrderCharge()
    {
        return Cache::rememberForever('small-order-charge', static function () {
            return self::where('key', 'small-order-charge')->first()->value;
        });
    }

    /**
     * @return mixed
     */
    public static function siteAnnouncement()
    {
        return Cache::rememberForever('site-announcement', static function () {
            return self::where('key', 'site-announcement')->first()->value;
        });
    }

    /**
     * @return mixed
     */
    public static function checkoutNotice()
    {
        return Cache::rememberForever('checkout-notice', static function () {
            return self::where('key', 'checkout-notice')->first()->value;
        });
    }

    /**
     * @return mixed
     */
    public static function countries()
    {
        return Cache::remember('countries', 1440, static function () {
            return self::where('key', 'countries')->first()->value;
        });
    }

    /**
     * @return mixed
     */
    public static function defaultCountry()
    {
        return Cache::rememberForever('default-country', static function () {
            return self::where('key', 'default-country')->first()->value;
        });
    }

    /**
     * @return mixed
     */
    public static function googleMapsUrl()
    {
        return Cache::rememberForever('google-maps-url', static function () {
            return self::where('key', 'google-maps')->first()->value;
        });
    }

    /**
     * @return mixed
     */
    public static function googleAnalyticsUrl()
    {
        return Cache::rememberForever('google-analytics-url', static function () {
            return self::where('key', 'google-analytics')->first()->value;
        });
    }

    /**
     * @return bool
     */
    public static function storeSiteSettings(): bool
    {
        $settings = new self();

        $settings->forgetSettingsCache();

        $settings::where('key', 'site-announcement')->update([
            'value' => request('announcement') ?: '',
        ]);

        $settings::where('key', 'checkout-notice')->update([
            'value' => request('checkout_notice') ?: '',
        ]);

        $settings::where('key', 'default-country')->update([
            'value' => request('default_country'),
        ]);

        $settings::where('key', 'google-analytics')->update([
            'value' => request('tracking_code') ?: '',
        ]);

        $settings::where('key', 'google-maps')->update([
            'value' => request('google_maps') ?: '',
        ]);

        return true;
    }
}
