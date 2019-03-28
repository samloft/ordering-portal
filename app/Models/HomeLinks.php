<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\HomeLinks
 *
 * @mixin \Eloquent
 */
class HomeLinks extends Model
{
    protected $table = 'home_links';

    /**
     * Return row for the given ID.
     *
     * @param $id
     * @return HomeLinks|Model|object|null
     */
    public static function show($id)
    {
        return (new HomeLinks)->where('id', $id)->first();
    }

    /**
     * Create a new home link.
     *
     * @param $request
     * @return bool
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public static function store($request)
    {
        $stored = static::storeLinkImage($request->file('image'), $request->type, $request->name);

        if (!$stored['status']) {
            return false;
        }

        $data = [
            'type' => $request->type,
            'name' => $request->type . '-' . $request->name,
            'link' => $request->link,
            'position' => static::nextPosition($request->type),
            'image' => $stored['name'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        return (new HomeLinks)->insert($data);
    }

    /**
     * Update the given home link with new data.
     *
     * @param $request
     * @return bool
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public static function edit($request)
    {
        $data = [
            'link' => $request->link,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($request->image) {
            $stored = static::storeLinkImage($request->file('image'), $request->type, $request->name);

            if (!$stored['status']) {
                return false;
            }

            $data['image'] = $stored['image'];
        }

        return (new HomeLinks)->where('id', $request->id)->update($data);
    }

    /**
     * Takes the given image and stores it in the correct folder
     * based on type.
     *
     * @param $image
     * @param $type
     * @param $name
     * @return array
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public static function storeLinkImage($image, $type, $name)
    {
        $extension = $image->getClientOriginalExtension();
        $image_name = $type . '-' . str_slug($name) . '.' . $extension;
        $image_path = 'images/home-links/' . $image_name;

        return ['status' => Storage::disk('public')->put($image_path, File::get($image)), 'name' => $image_name];
    }

    /**
     * Deletes the record with matching image for the given ID.
     *
     * @param array|\Illuminate\Support\Collection|int $id
     * @return bool|int|null
     * @throws \Exception
     */
    public static function destroy($id)
    {
        $link = static::show($id);

        Storage::disk('public')->delete('images/home-links/' . $link->image);

        return (new HomeLinks)->where('id', $id)->delete();
    }

    /**
     * Return all the category links for the home page.
     *
     * @return HomeLinks[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function categories()
    {
        return (new HomeLinks)->where('type', 'like', 'category%')->orderBy('position', 'asc')->get();
    }

    /**
     * Return all the advert links for the home page.
     *
     * @return HomeLinks[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function adverts()
    {
        return (new HomeLinks)->where('type', 'advert')->orderBy('position', 'asc')->get();
    }

    /**
     * Alter positions from given array.
     *
     * @param $items
     * @return bool
     */
    public static function updatePositions($items)
    {
        foreach ($items as $item) {
            (new HomeLinks)->where('id', $item['id'])->update(['position' => $item['position']]);
        }

        return true;
    }

    /**
     * Get the highest position for the given type and increment
     * by 1 for the next position.
     *
     * @param $type
     * @return HomeLinks|Model|int|object|null
     */
    public static function nextPosition($type)
    {
        $max_position = (new HomeLinks)->select('position')->where('type', $type)->orderBy('position', 'desc')->first();

        return $max_position ? ($max_position->position + 1) : 1;
    }
}
