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
     * @return array
     */
    public static function list()
    {
        $category_results = (new Categories)->select('cat1_level1', 'cat1_level2', 'cat1_level3')->whereHas('prices', function ($query) {
            $query->where('customer_code', Auth::user()->customer_code);
        })->where('cat1_level1', '<>', '')->groupBy('cat1_level1', 'cat1_level2', 'cat1_level3')->get();

        $array = [];

        foreach ($category_results as $category) {
            $array[$category->cat1_level1][$category->cat1_level2][$category->cat1_level3] = [];
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

    /**
     * @return Categories[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
//    public static function main()
//    {
//        $categories = (new Categories)->select('cat1_level1', 'cat1_level2')->whereHas('prices', function ($query) {
//            $query->where('customer_code', Auth::user()->customer_code);
//        })->where('cat1_level1', '<>', '')->groupBy('cat1_level1', 'cat1_level2')->get();
//
//        $previous_value = null;
//        $category_list = [];
//        $color = 1;
//
//        foreach ($categories as $key => $value) {
//            if ($value->cat1_level1 != $previous_value) {
//                $category_list[] = [
//                    'name' => $value->cat1_level1,
//                    'url' => urlencode($value->cat1_level1),
//                    'has_sub' => $value->cat1_level2 ? true : false,
//                    'color' => $color,
//                ];
//                $previous_value = $value->cat1_level1;
//                $color++;
//            }
//        }
//
//        return $category_list;
//    }
//
//    public static function level2($category)
//    {
//        $categories = (new Categories)->select('cat1_level2', 'cat1_level3')->whereHas('prices', function ($query) {
//            $query->where('customer_code', Auth::user()->customer_code);
//        })->where('cat1_level2', '<>', '')->where('cat1_level1', urldecode($category))->groupBy('cat1_level2', 'cat1_level3')->get();
//
//        $previous_value = null;
//        $category_list = [];
//
//        foreach ($categories as $key => $value) {
//            if ($value->cat1_level2 != $previous_value) {
//                $category_list[] = [
//                    'name' => $value->cat1_level2,
//                    'url' => urlencode($value->cat1_level2),
//                    'has_sub' => $value->cat1_level3 ? true : false,
//                ];
//                $previous_value = $value->cat1_level2;
//            }
//        }
//
//        return $category_list;
//    }
//
//    public static function level3($category, $sub_category)
//    {
//        $categories = (new Categories)->select('cat1_level3')->whereHas('prices', function ($query) {
//            $query->where('customer_code', Auth::user()->customer_code);
//        })->where('cat1_level3', '<>', '')->where('cat1_level1', urldecode($category))->where('cat1_level2', urldecode($sub_category))
//            ->groupBy('cat1_level3')->get();
//
//        $previous_value = null;
//        $category_list = [];
//
//        foreach ($categories as $key => $value) {
//            if ($value->cat1_level3 != $previous_value) {
//                $category_list[] = [
//                    'name' => $value->cat1_level3,
//                    'url' => urlencode($value->cat1_level3),
//                    'has_sub' => false,
//                ];
//                $previous_value = $value->cat1_level3;
//            }
//        }
//
//        return $category_list;
//    }
//
//    public static function level($level, $cat)
//    {
//        $category = 'cat1_level' . $level;
//        $next_category = 'cat1_level' . ($level + 1);
//
//        $categories = (new Categories)->select($category, $next_category)->whereHas('prices', function ($query) {
//            $query->where('customer_code', Auth::user()->customer_code);
//        })->where($category, '<>', '')->where('cat1_level1', urldecode($cat))->groupBy($category, $next_category)->get();
//
//        $previous_value = null;
//        $category_list = [];
//
//        foreach ($categories as $key => $value) {
//            if ($value->$category != $previous_value) {
//                $category_list[] = [
//                    'name' => $value->$category,
//                    'has_sub' => $value->$next_category ? true : false,
//                ];
//                $previous_value = $value->$category;
//            }
//        }
//
//        return $category_list;
//    }
}
