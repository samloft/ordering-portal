<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Page
 *
 * @mixin Eloquent
 */
class Page extends Model
{
    /**
     * @param $page_name
     * @return mixed
     */
    public static function show($page_name)
    {
        return self::where('name', $page_name)->first();
    }
}
