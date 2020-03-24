<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * App\Models\CategoryImage.
 *
 * @mixin \Eloquent
 */
class CategoryImage extends Model
{
    /**
     * @param $category
     * @return mixed
     */
    public static function show($category)
    {
        return Cache::rememberForever('cat-image:'.$category, static function () use ($category) {
            $override = self::where('level_1', $category)->orWhere('level_2', $category)->orWhere('level_3', $category)->first();

            return $override ? $override->image : false;
        });
    }
}
