<?php

namespace App\Models;

use Auth;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer
 *
 * @mixin Eloquent
 */
class Prices extends Model
{
    protected $primaryKey = 'product';
    public $incrementing = false;

    /**
     * Return a list of all products that have a price list.
     *
     * @return Prices[]|Collection
     */
    public static function productList()
    {
        return (new Prices)->select('product')->where('product', 'not like', '%*%')->distinct()->orderBy('product', 'asc')->get();
    }

    /**
     * Checks that a product is on a customers price list.
     *
     * @param $product_code
     * @return bool
     */
    public static function product($product_code)
    {
        $exists = (new Prices)->where('customer_code', Auth::user()->customer->customer_code)->where('product', $product_code)->first();

        return $exists ? true : false;
    }

    /**
     * Join product specs on the customer prices (Products they can buy).
     *
     * @return Builder[]|Collection
     */
    public static function productSpecs()
    {
        return (new Prices)->where('customer_code', Auth::user()->customer->customer_code)
            ->join('product_specs', 'prices.product', '=', 'product_specs.product')
            ->where('product_specs.value', '!=', ' ')
            ->get();
    }
}
