<?php

namespace App\Models;

use Auth;
use Eloquent;
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
}
