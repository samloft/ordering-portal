<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * App\Models\Price.
 *
 * @mixin \Eloquent
 *
 * @property string $customer_code
 * @property string $product
 * @property float $price
 * @property int $break1
 * @property float $price1
 * @property int $break2
 * @property float $price2
 * @property int $break3
 * @property float $price3
 */
class Price extends Model
{
    protected $primaryKey = 'product';

    public $incrementing = false;
    public $timestamps = false;

    /**
     * Return a list of all products that have a price list.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function products(): Collection
    {
        return self::select('product')->where('product', 'not like', '%*%')->distinct()->orderBy('product')->get();
    }
}
