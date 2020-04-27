<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Page.
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $description
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Page extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['name', 'description'];

    /**
     * Return details for the passed page name.
     *
     * @param $page_name
     *
     * @return mixed
     */
    public static function show($page_name)
    {
        return self::where('name', $page_name)->first();
    }
}
