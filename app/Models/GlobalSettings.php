<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\GlobalSettings.
 *
 * @mixin \Eloquent
 *
 * @property int $id
 * @property string $key
 * @property string $value
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class GlobalSettings extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['key', 'value'];

    protected $fillable = ['value'];

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
        Cache::forget('v1-docid');
        Cache::forget('terms-enabled');
    }

    /**
     * Get a global setting based on key.
     *
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
     * @return mixed
     */
    public static function versionOneDocId()
    {
        return Cache::rememberForever('v1-docid', static function () {
            return self::where('key', 'v1-docid')->first()->value;
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

        $settings::where('key', 'v1-docid')->update([
            'value' => request('v1_docid') ?: '',
        ]);

        $settings::where('key', 'last-order')->update([
            'value' => request('last_order'),
        ]);

        $settings::where('key', 'terms-enabled')->update([
            'value' => json_encode([
                'enabled' => request('terms_enabled'),
                'url' => request('terms_url'),
            ], true),
        ]);

        return true;
    }

    /**
     * Get the next order number to be used.
     *
     * @return string
     */
    public static function nextOrderNumber(): string
    {
        $last_order_value = self::where('key', 'last-order')->firstOrFail();

        $order_prefix = substr($last_order_value->value, 0, 1);
        $next_order = $order_prefix.str_pad(substr($last_order_value->value, 1) + 1, 6, '0', STR_PAD_LEFT);

        $last_order_value->value = $next_order;
        $last_order_value->save();

        return $next_order;
    }

    /**
     * Check to see if product data or net prices downloads should be displayed on the site.
     *
     * @return mixed
     */
    public static function productData()
    {
        return Cache::rememberForever('product-data', static function () {
            return json_decode(self::where('key', 'product-data')->first()->value, true);
        });
    }

    /**
     * Check to see if new users should have to accept terms before accessing the site.
     *
     * @return mixed
     */
    public static function termsEnabled()
    {
        return Cache::rememberForever('terms-enabled', static function () {
            return json_decode(self::where('key', 'terms-enabled')->first()->value, true);
        });
    }

    /**
     * @return mixed
     */
    public static function uploadConfig()
    {
        return Cache::rememberForever('upload-config', static function () {
            return json_decode(self::where('key', 'upload-config')->first()->value, true);
        });
    }
}
