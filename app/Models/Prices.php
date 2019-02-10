<?php

namespace App\Models;

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
}
