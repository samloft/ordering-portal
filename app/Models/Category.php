<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * App\Models\Category.
 *
 * @mixin Eloquent
 * @property string $product
 * @property string $level_1
 * @property string $level_2
 * @property string $level_3
 * @property string $level_4
 * @property string $level_5
 */
class Category extends Model
{
    protected $primaryKey = 'product';

    public $incrementing = false;

    public $timestamps = false;

    /**
     * @return HasMany
     */
    public function prices(): HasMany
    {
        return $this->hasMany(Price::class, 'product', 'product');
    }

    /**
     * @return HasMany
     */
    public function notSoldProducts(): HasMany
    {
        return $this->hasMany(Product::class, 'code', 'product')->where('not_sold', true);
    }

    /**
     * @param $level
     *
     * @return \Illuminate\Support\Collection
     */
    public static function show($level): Collection
    {
        return self::select('level_'.$level)->where('level_'.$level, '!=', null)->where('level_1', '!=', '')
            ->groupBy('level_'.$level)->get();
    }

    /**
     * Create an array of all possible categories from the customers price list.
     *
     * @return array
     */
    public static function list(): array
    {
        $category_results = self::select([
            'level_1',
            'level_2',
            'level_3',
            'level_4',
            'level_5',
        ])->whereHas('prices', static function ($query) {
            $query->where('customer_code', auth()->user()->customer->code);
        })->doesntHave('notSoldProducts')->groupBy('level_1', 'level_2', 'level_3', 'level_4', 'level_5')->get();

        $array = [];

        foreach ($category_results as $category) {
            if (trim($category->level_1) !== '') {
                $array[strtoupper(trim($category->level_1))][trim($category->level_2)][trim($category->level_3)][trim($category->level_4)][trim($category->level_5)] = [];
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
     *
     * @return array
     */
    public static function subCategories($level, $main, $category): array
    {
        $subs = static::where('level_1', $main)->where('level_'.$level, $category)->whereHas('prices', static function (
            $query
        ) {
            $query->where('customer_code', auth()->user()->customer->code);
        })->doesntHave('notSoldProducts')->orderBy('level_'.$level)->orderBy('product')->get();

        $sub_categories = [];
        $cat_level = 'level_'.($level + 1);

        foreach ($subs->unique($cat_level) as $sub) {
            $category = trim($sub->$cat_level);

            if ($category) {
                $sub_categories[$category] = [
                    'key' => $category,
                    'slug' => encodeUrl($category),
                    'override' => CategoryImage::show($category) ?: null,
                    'product_list' => encodeArrayValues($subs->where($cat_level, $category)->pluck('product')->take(4)
                        ->toArray()),
                ];
            }
        }

        ksort($sub_categories);

        return $sub_categories;
    }
    
    /**
     * @param $level_1
     * @param null $level_2
     *
     * @return bool|\Illuminate\Support\Collection
     */
    public static function showLevels($level_1, $level_2 = null)
    {
        if ($level_1 && ! $level_2) {
            return self::select('level_2')->where('level_1', $level_1)->groupBy('level_2')->get();
        }

        if ($level_2) {
            return self::select('level_3')->where('level_1', $level_1)->where('level_2', $level_2)->groupBy('level_3')
                ->get();
        }

        return false;
    }

    /**
     * @return mixed
     */
    public static function brand()
    {
        return self::select([
            'level_1',
        ])->whereHas('prices', static function ($query) {
            $query->where('customer_code', auth()->user()->customer->code);
        })->groupBy('level_1')->get();
    }

    public static function range($brand)
    {
        return self::select([
            'level_2',
        ])->where('level_1', $brand)->whereHas('prices', static function ($query) {
            $query->where('customer_code', auth()->user()->customer->code);
        })->groupBy('level_2')->get();
    }
}
