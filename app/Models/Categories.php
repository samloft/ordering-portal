<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

/**
 * App\Models\Categories
 *
 * @mixin \Eloquent
 */
class Categories extends Model
{
    protected $primaryKey = 'product';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prices()
    {
        return $this->hasMany(Prices::class, 'product', 'product');
    }

    /**
     * Create an array of all possible categories from the customers price list.
     *
     * @return array
     */
    public static function list()
    {
        $category_results = (new Categories)->select('cat1_level1', 'cat1_level2', 'cat1_level3')->whereHas('prices', function ($query) {
            $query->where('customer_code', Auth::user()->customer_code);
        })->where('cat1_level1', '<>', '')->groupBy('cat1_level1', 'cat1_level2', 'cat1_level3')->get();

        $array = [];

        foreach ($category_results as $category) {
            if (trim($category->cat1_level1) <> '') {
                $array[$category->cat1_level1][$category->cat1_level2][$category->cat1_level3] = [];
            }
        }

        $categories = [];

        foreach ($array as $key => $value) {
            $categories[] = [
                'name' => $key,
                'url' => urlencode(str_replace('/', '%2F', $key)),
                'sub' => []
            ];

            end($categories);
            $level_1 = key($categories);

            foreach ($array[$key] as $key1 => $value1) {
                $categories[$level_1]['sub'][] = [
                    'name' => $key1,
                    'url' => urlencode(str_replace('/', '%2F', $key1)),
                    'sub' => []
                ];

                end($categories[$level_1]['sub']);
                $level_2 = key($categories[$level_1]['sub']);

                foreach ($array[$key][$key1] as $key2 => $value2) {
                    if ($key2 != '') {
                        $categories[$level_1]['sub'][$level_2]['sub'][] = [
                            'name' => $key2,
                            'url' => urlencode(str_replace('/', '%2F', $key2))
                        ];
                    }
                }
            }
        }

        return $categories;
    }

    public static function showLevel1($level1)
    {
        return (new Categories)->selectRaw('cat1_level2 as name')->where('cat1_level1', $level1)
            ->whereHas('prices', function ($query) {
                $query->where('customer_code', Auth::user()->customer_code);
            })->groupBy('cat1_level2')->get();
    }

    public static function showLevel2($level2)
    {
        return (new Categories)->selectRaw('cat1_level3 as name')->where('cat1_level2', $level2)
            ->whereHas('prices', function ($query) {
                $query->where('customer_code', Auth::user()->customer_code);
            })->groupBy('cat1_level3')->get();
    }
}
