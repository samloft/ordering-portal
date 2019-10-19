<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Price
 *
 * @mixin Eloquent
 */
class Price extends Model
{
    protected $primaryKey = 'product';

    public $incrementing = false;
    public $timestamps = false;

    /**
     * Return a list of all products that have a price list.
     *
     * @return Price[]|Collection
     */
    public static function productList()
    {
        return self::select('product')->where('product', 'not like', '%*%')->distinct()->orderBy('product')->get();
    }

    /**
     * Checks that a product is on a customers price list.
     *
     * @param $product_code
     * @return bool
     */
    public static function product($product_code): bool
    {
        $exists = self::where('customer_code', auth()->user()->customer->code)->where('product', $product_code)->first();

        return $exists ? true : false;
    }

    /**
     * Join product specs on the customer prices (Product they can buy).
     *
     * @return Builder[]|Collection
     */
    public static function productPrices()
    {
        return static::where('customer_code', auth()->user()->customer->code)->join('products', 'prices.product', '=', 'products.product')->get();
    }
}
