<?php

namespace App\Models\OrderTracking;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Addresses
 *
 * @mixin \Eloquent
 */
class Lines extends Model
{
    protected $table = 'order_tracking_lines';

    /**
     * Get all the current order lines (For copy to basket functionality).
     *
     * @param $order_number
     * @return array
     */
    public static function show($order_number)
    {
        return (new Lines)->selectRaw('product, line_qty as quantity')->where('order_no', $order_number)->get()->toArray();
    }
}
