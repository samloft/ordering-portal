<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Pages
 *
 * @mixin \Eloquent
 */
class Pages extends Model
{
    /**
     * Gets HTML data based on given page name.
     *
     * @param $page_name
     * @return mixed
     */
    public static function show($page_name)
    {
        return (new Pages)->where('name', $page_name)->first();
    }
}
