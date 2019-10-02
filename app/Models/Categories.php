<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Categories
 *
 * @mixin Eloquent
 */
class Categories extends Model
{
    protected $primaryKey = 'product';

    public $incrementing = false;

    /**
     * @return HasMany
     */
    public function prices(): HasMany
    {
        return $this->hasMany(Prices::class, 'product', 'product');
    }

    /**
     * Create an array of all possible categories from the customers price list.
     *
     * @return array
     */
    public static function list(): array
    {
        $category_results = self::select([
            'cat1_level1',
            'cat1_level2',
            'cat1_level3',
            'cat1_level4',
            'cat1_level5',
        ])->whereHas('prices', static function ($query) {
            $query->where('customer_code', auth()->user()->customer->code);
        })->groupBy('cat1_level1', 'cat1_level2', 'cat1_level3', 'cat1_level4', 'cat1_level5')->get();

        $array = [];

        foreach ($category_results as $category) {
            if (trim($category->cat1_level1) !== '') {
                $array[strtoupper(trim($category->cat1_level1))]
                [trim($category->cat1_level2)]
                [trim($category->cat1_level3)]
                [trim($category->cat1_level4)]
                [trim($category->cat1_level5)] = [];
            }
        }

        $categories = [];

        foreach ($array as $key => $value) {
            $categories[] = [
                'level' => 1,
                'name' => $key,
                'url' => encodeUrl($key),
                'sub' => [],
            ];

            end($categories);
            $level_1 = key($categories);

            foreach ($array[$key] as $key1 => $value1) {
                if ($key1 !== '') {
                    $categories[$level_1]['sub'][] = [
                        'level' => 2,
                        'name' => $key1,
                        'url' => encodeUrl($key1),
                        'sub' => [],
                    ];
                }

                end($categories[$level_1]['sub']);
                $level_2 = key($categories[$level_1]['sub']);

                foreach ($array[$key][$key1] as $key2 => $value2) {
                    if ($key2 !== '') {
                        $categories[$level_1]['sub'][$level_2]['sub'][] = [
                            'level' => 3,
                            'name' => $key2,
                            'url' => encodeUrl($key2),
                        ];
                    }
                }
            }
        }

        return $categories;
    }

    /**
     * Get sub categories for the given category level.
     *
     * @param $level
     * @param $main
     * @param $category
     * @return array
     */
    public static function subCategories($level, $main, $category): array
    {
        $sub_categories = [];

        $subs = static::where('cat1_level1', $main)->where('cat1_level'.$level, $category)->whereHas('prices', static function ($query) {
            $query->where('customer_code', auth()->user()->customer->code);
        })->orderBy('cat1_level'.$level)->orderBy('product')->get();

        $products = [];

        foreach ($subs as $sub) {
            $cat_level = 'cat1_level'.($level + 1);

            if (isset($sub->$cat_level) && trim($sub->$cat_level) !== '') {
                $products[] = [
                    'product' => encodeUrl($sub->product),
                    'category' => trim($sub->$cat_level),
                    'product_list' => [],
                ];

                $sub_categories[trim($sub->$cat_level)] = [
                    'slug' => encodeUrl($sub->$cat_level),
                ];
            }
        }

        ksort($sub_categories);

        foreach ($sub_categories as $key => $value) {
            $count = 0;
            $product_list = null;

            foreach ($products as $product) {
                if (($product['category'] === $key) && $count <= 4) {
                    // Grab the first 4 products and add them to the array (For category images).
                    $sub_categories[$key]['product_list'][] = encodeUrl($product['product']);
                    $count++;
                }
            }
        }

        return $sub_categories;
    }
}
