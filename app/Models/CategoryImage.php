<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * App\Models\CategoryImage.
 *
 * @mixin \Eloquent
 *
 * @property int $id
 * @property string $image
 * @property string $level_1
 * @property string $level_2
 * @property string $level_3
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
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
