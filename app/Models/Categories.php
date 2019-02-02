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
    public $incrementing = false;

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
        $category_results = (new Categories)->select('cat1_level1', 'cat1_level2', 'cat1_level3', 'cat1_level4', 'cat1_level5')
            ->whereHas('prices', function ($query) {
                $query->where('customer_code', Auth::user()->customer_code);
            })->groupBy('cat1_level1', 'cat1_level2', 'cat1_level3', 'cat1_level4', 'cat1_level5')->get();

        $array = [];

        foreach ($category_results as $category) {
            if (trim($category->cat1_level1) <> '') {
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
                'url' => urlencode(str_replace('/', '%2F', $key)),
                'sub' => []
            ];

            end($categories);
            $level_1 = key($categories);

            foreach ($array[$key] as $key1 => $value1) {
                if ($key1 != '') {
                    $categories[$level_1]['sub'][] = [
                        'level' => 2,
                        'name' => $key1,
                        'url' => urlencode(str_replace('/', '%2F', $key1)),
                        'sub' => []
                    ];
                }

                end($categories[$level_1]['sub']);
                $level_2 = key($categories[$level_1]['sub']);

                foreach ($array[$key][$key1] as $key2 => $value2) {
                    if ($key2 != '') {
                        $categories[$level_1]['sub'][$level_2]['sub'][] = [
                            'level' => 3,
                            'name' => $key2,
                            'url' => urlencode(str_replace('/', '%2F', $key2))
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
     * @param $category
     * @return array
     */
    public static function subCategories($level, $category)
    {
        $sub_categories = [];

        $subs = (new Categories)
            ->where('cat1_level' . $level, $category)
            ->whereHas('prices', function ($query) {
                $query->where('customer_code', Auth::user()->customer_code);
            })->get();

        $products = [];

        foreach ($subs as $sub) {
            $cat_level = 'cat1_level' . ($level + 1);

            if (isset($sub->$cat_level) && trim($sub->$cat_level) <> '') {
                $products[] = [
                    'category' => trim($sub->$cat_level),
                    'product' => trim(str_replace('/', '^', $sub->product))
                ];

                $sub_categories[trim($sub->$cat_level)] = [
                    'slug' => urlencode(trim($sub->$cat_level)),
                ];
            }
        }

        foreach ($sub_categories as $key => $value) {
            $count = 0;
            $image = false;

            foreach ($products as $product) {
                if ($product['category'] == $key && $count <= 5) {
                    $image = static::categoryImage($product['product']);
                    $count++;

                    if ($image) {
                        break;
                    }
                }
            }

            $sub_categories[$key]['image'] = $image;
        }

        ksort($sub_categories);

        return $sub_categories;
    }

    public static function categoryImage($product)
    {
        // TODO: Check if override from CMS exists first...
//        $products = (new Categories)->select('product')
//            ->where('cat1_level' . $level, $name)
//            ->whereHas('prices', function ($query) {
//                $query->where('customer_code', Auth::user()->customer_code);
//            })->groupBy('product')
//            ->limit(5);
        $external_link = 'https://scolmoreonline.com/product_images/' . $product . '.png';

        if (@getimagesize($external_link)) {
            return $external_link;
        }

        return false;
    }
}
