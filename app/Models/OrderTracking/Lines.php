<?php

namespace App\Models\OrderTracking;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

/**
 * App\Models\Addresses
 *
 * @mixin Eloquent
 */
class Lines extends Model
{
    protected $table = 'order_tracking_lines';

    /**
     * Get all the product lines for a order tracking header.
     *
     * @param $order_number
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Builder[]|Collection
     */
    public static function show($order_number)
    {
        return (new Lines)->where('order_no', $order_number)
            ->leftJoin('prices', 'prices.product', '=', 'order_tracking_lines.product')
            ->where('prices.customer_code', Auth::user()->customer->customer_code)
            ->get();
    }

    /**
     * Get all the current order lines (For copy to basket).
     *
     * @param $order_number
     * @return array
     */
    public static function copy($order_number): array
    {
        return (new Lines)->selectRaw('product, line_qty as quantity')->where('order_no', $order_number)->get()->toArray();
    }
}
