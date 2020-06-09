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
 * @property string $order_number
 * @property int $order_line_no
 * @property string $product
 * @property string $description
 * @property int $quantity
 * @property float $price
 * @property float $total
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
        return $this->belongsTo(Price::class, 'product', 'product')
            ->where('customer_code', auth()->user()->customer->code);
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
        return self::selectRaw('product, quantity')->where('order_number', $order_number)->get()->toArray();
    }
}
