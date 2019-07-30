<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SupportPages
 *
 * @mixin Eloquent
 */
class SupportPages extends Model
{
    protected $table = 'support_pages';

    /**
     * @param $page_name
     * @return mixed
     */
    public static function show($page_name)
    {
        return (new SupportPages)->where('page_name', $page_name)->first();
    }
}
