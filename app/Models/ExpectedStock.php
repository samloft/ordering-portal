<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ExpectedStock
 *
 * @mixin \Eloquent
 */
class ExpectedStock extends Model
{
    protected $table = 'expected_stock';
    protected $dates = ['due_date'];

    public $timestamps = false;

    /**
     * Get all expected stock from the passed product code
     *
     * @param $product
     * @return mixed
     */
    public static function show($product)
    {
        return self::selectRaw('SUM(quantity) as quantity, due_date')
            ->where('product', $product)
            ->groupBy('due_date')
            ->orderBy('due_date', 'asc')
            ->get();
    }
}
