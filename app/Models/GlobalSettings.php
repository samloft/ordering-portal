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
     * @param $key
     *
     * @return mixed
     */
    public static function key($key)
    {
        return self::where('key', $key)->first()->value;
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
}
