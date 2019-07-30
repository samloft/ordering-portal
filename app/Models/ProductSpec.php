<?php

namespace App\models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Products
 *
 * @mixin Eloquent
 */
class ProductSpec extends Model
{
    /**
     * @param $product_code
     * @return mixed
     */
    public static function show($product_code)
    {
        return (new ProductSpec)->where('product', $product_code)
            ->where('value', '!=', '')
            ->get();
    }
}
