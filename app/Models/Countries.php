<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Countries
 *
 * @mixin \Eloquent
 */
class Countries extends Model
{
    /**
     * @return mixed
     */
    public static function show()
    {
        return self::get();
    }
}
