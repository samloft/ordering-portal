<?php

namespace App\Models;

use File;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;
use Storage;

/**
 * App\Models\HomeLink.
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $type
 * @property string $name
 * @property string $image
 * @property string $link
 * @property string $file
 * @property int $position
 * @property string $style
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class HomeLink extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['id', 'type', 'name', 'image', 'link', 'file', 'position', 'style'];

    protected $fillable = [];

    /**
     * Create a new home link.
     *
     * @return \App\Models\HomeLink|bool
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public static function store()
    {
        $stored = static::storeLinkImage(request()->file('file'), request('type'), request('name'));

        $category_link = new self;

        if (request()->file('download-file')) {
            $file_stored = static::storeDownloadFile(request()->file('download-file'));

            if (! $file_stored['status']) {
                return false;
            }

            $category_link->file = $file_stored['name'];
        }

        $category_link->type = request('type');
        $category_link->name = request('type').'-'.request('name');
        $category_link->link = request('url');
        $category_link->position = request('position');
        $category_link->image = $stored['name'];
        $category_link->style = request('style');
        $category_link->save();

        return $category_link;
    }

    /**
     * Takes the given image and stores it in the correct folder
     * based on type.
     *
     * @param $image
     * @param $type
     * @param $name
     *
     * @return array
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public static function storeLinkImage($image, $type, $name): array
    {
        $extension = $image->getClientOriginalExtension();
        $image_name = $type.'-'.str::slug($name, '-').'.'.$extension;
        $image_path = '/'.config('app.name').'/'.$type.'/'.$image_name;

        return ['status' => Storage::put($image_path, File::get($image)), 'name' => $image_name];
    }

    /**
     * @param $file
     *
     * @return array
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public static function storeDownloadFile($file): array
    {
        $name = $file->getClientOriginalName();

        return [
            'status' => Storage::put('/'.config('app.name').'/files/'.$name, File::get($file)),
            'name' => $name,
        ];
    }

    /**
     * Deletes the record with matching image for the given ID.
     *
     * @param $id
     *
     * @return bool|int|null
     * @throws \Exception
     */
    public static function destroy($id)
    {
        $link = self::findOrFail($id);

        Storage::delete('/'.config('app.name').'/images/'.request('type').'/'.$link->image);

        return $link->delete();
    }

    /**
     * List all the home links of type category.
     *
     * @return HomeLink[]|Collection
     */
    public static function categories()
    {
        return self::where('type', 'category')->orderBy('position')->get();
    }

    /**
     * List all the home links of type advert.
     *
     * @return HomeLink[]|Collection
     */
    public static function adverts()
    {
        return self::where('type', 'advert')->orderBy('position', 'asc')->get();
    }

    /**
     * List all the home links of type banner.
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function banners()
    {
        return self::where('type', 'banner')->orderBy('position', 'asc')->get();
    }

    /**
     * Alter positions from given array.
     *
     * @param $items
     *
     * @return bool
     */
    public static function updatePositions($items): bool
    {
        foreach ($items as $item) {
            $link = self::findOrFail($item['id']);

            $link->position = $item['position'];
            $link->save();
        }

        return true;
    }
}
