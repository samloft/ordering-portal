<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\CategoryImage.
 *
 * @mixin \Eloquent
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
    use LogsActivity;

    protected static $logAttributes = ['id', 'image', 'level_1', 'level_2', 'level_3'];

    /**
     * @param $category
     *
     * @return mixed
     */
    public static function show($category)
    {
        return Cache::rememberForever('cat-image:'.$category, static function () use ($category) {
            $override = self::where('level_1', $category)->orWhere('level_2', $category)->orWhere('level_3', $category)
                ->first();

            return $override ? $override->image : false;
        });
    }
}
