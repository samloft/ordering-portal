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
        return Cache::rememberForever('discount', static function() {
            return self::where('key', 'discount')->first()->value;
        });
    }
}
