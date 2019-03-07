<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer
 *
 * @mixin \Eloquent
 */
class Prices extends Model
{
    protected $primaryKey = 'product';
    public $incrementing = false;

    /**
     * Return a list of all products that have a price list.
     *
     * @return Prices[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function productList()
    {
        return (new Prices)->select('product')->groupBy('product')->orderBy('product', 'asc')->get();
    }

    /**
     * Checks that a product is on a customers price list.
     *
     * @param $product_code
     * @return bool
     */
    public static function product($product_code)
    {
        $exists = (new Prices)->where('customer_code', Auth::user()->customer_code)->where('product', $product_code)->first();

        return $exists ? true : false;
    }
}
