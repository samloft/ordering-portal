<?php

namespace App\Models;

use Eloquent;
use Exception;
use File;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Storage;

/**
 * App\Models\HomeLink.
 *
 * @mixin Eloquent
 */
class HomeLink extends Model
{
    protected $fillable = [];

    /**
     * Return row for the given ID.
     *
     * @param $id
     *
     * @return HomeLink|Model|object|null
     */
    public static function show($id)
    {
        return self::where('id', $id)->first();
    }

    /**
     * Create a new home link.
     *
     * @param $request
     *
     * @return \App\Models\HomeLink|bool
     */
    public static function store($request)
    {
        $stored = static::storeLinkImage($request->file('file'), 'link', $request->name);

        if (! $stored['status']) {
            return false;
        }

        $category_link = new self;

        $category_link->type = 'link';
        $category_link->name = 'link'.'-'.$request->name;
        $category_link->link = $request->url;
        $category_link->position = $request->position;
        $category_link->image = $stored['name'];
        $category_link->save();

        return $category_link;
    }

    /**
     * Update the given home link with new data.
     *
     * @param $request
     *
     * @return bool
     */
    public static function edit($request): bool
    {
        $data = [
            'link' => $request->link,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if ($request->image) {
            $stored = static::storeLinkImage($request->file('image'), $request->type, $request->name);

            if (! $stored['status']) {
                return false;
            }

            $data['image'] = $stored['image'];
        }

        return self::where('id', $request->id)->update($data);
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
     */
    public static function storeLinkImage($image, $type, $name): array
    {
        $extension = $image->getClientOriginalExtension();
        $image_name = $type.'-'.str::slug($name, '-').'.'.$extension;
        $image_path = 'images/home-links/'.$image_name;

        return ['status' => Storage::disk('public')->put($image_path, File::get($image)), 'name' => $image_name];
    }

    /**
     * Deletes the record with matching image for the given ID.
     *
     * @param array|\Illuminate\Support\Collection|int $id
     *
     * @return bool|int|null
     * @throws Exception
     *
     */
    public static function destroy($id)
    {
        $link = static::show($id);

        Storage::disk('public')->delete('images/home-links/'.$link->image);

        return self::where('id', $id)->delete();
    }

    /**
     * Return all the category links for the home page.
     *
     * @return HomeLink[]|Collection
     */
    public static function categories()
    {
        return self::where('type', 'like', 'link%')->orderBy('position')->get();
    }

    /**
     * Return all the advert links for the home page.
     *
     * @return HomeLink[]|Collection
     */
    public static function adverts()
    {
        return self::where('type', 'advert')->orderBy('position', 'asc')->get();
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
            self::where('id', $item['id'])->update(['position' => $item['position']]);
        }

        return true;
    }
}
