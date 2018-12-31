<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Products extends Model
{
    protected $table = 'products';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prices()
    {
        return $this->belongsTo(Prices::class, 'product', 'product')->where('customer_code', Auth::user()->customer_code);
    }

    public function categories()
    {
        return $this->belongsTo(Categories::class, 'product', 'product');
    }

    /**
     * @param $categories
     * @return mixed
     */
    public static function list($categories)
    {
        $products = (new Products)->whereHas('prices', function ($query) {
            $query->where('customer_code', Auth::user()->customer_code);
        })->whereHas('categories', function ($query) use ($categories) {
            $query->where('cat1_level1', $categories['level_1'])
                ->where('cat1_level2', $categories['level_2'])
                ->where('cat1_level3', $categories['level_3']);
        })->paginate(10);

        return $products;
    }

    /**
     * @param $product_code
     * @return mixed
     */
    public static function show($product_code)
    {
        return (new Products)->whereHas('prices', function ($query) {
            $query->where('customer_code', Auth::user()->customer_code);
        })->where('product', $product_code)->first();
    }
}
