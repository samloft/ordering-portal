<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

/**
 * App\Models\OrderTrackingLine.
 *
 * @mixin \Eloquent
 *
 * @property string $order_no
 * @property int $order_line_no
 * @property string $product
 * @property string $long_description
 * @property int $line_qty
 * @property float $net_price
 * @property float $line_val
 */
class OrderTrackingLine extends Model
{
    public $timestamps = false;

    /**
     * Return the price for the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function price(): BelongsTo
    {
        return $this->belongsTo(Price::class, 'product', 'product')->where('customer_code', auth()->user()->customer->code);
    }

    /**
     * Get all the product lines for a order tracking header, with current price if available.
     *
     * @param $order_number
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Builder[]|Collection
     */
    public static function show($order_number)
    {
        return self::where('order_no', $order_number)->with('price')->get();
    }

    /**
     * Get all the current order lines (For copy to basket).
     *
     * @param $order_number
     *
     * @return array
     */
    public static function copy($order_number): array
    {
        return self::selectRaw('product, line_qty as quantity')->where('order_no', $order_number)->get()->toArray();
    }
}
