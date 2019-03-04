<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\HomeLinks
 *
 * @mixin \Eloquent
 */
class HomeLinks extends Model
{
    protected $table = 'home_links';

    /**
     * Return all the category links for the home page.
     *
     * @return HomeLinks[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function categories()
    {
        return (new HomeLinks)->where('type', 'category')->orderBy('position', 'asc')->get();
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
}
