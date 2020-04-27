<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\OrderHeader.
 *
 * @mixin \Eloquent
 * @property string $order_number
 * @property string $customer_code
 * @property int $user_id
 * @property string $reference
 * @property string $notes
 * @property string $name
 * @property string $telephone
 * @property string $mobile
 * @property string $address_line_1
 * @property string $address_line_2
 * @property string $address_line_3
 * @property string $address_line_4
 * @property string $address_line_5
 * @property string $delivery_method
 * @property string $delivery_code
 * @property float $delivery_cost
 * @property float $small_order_charge
 * @property float $vat
 * @property float $value
 * @property float $promotion_discount
 * @property int $imported
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $deleted_at
 */
class OrderHeader extends Model
{
    protected $table = 'order_header';

    public $incrementing = false;

    public $primaryKey = 'order_number';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * Return all the line for the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lines(): HasMany
    {
        return $this->hasMany(OrderLine::class, 'order_number', 'order_number');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check to see if the customer has claimed the product before
     * if they have return the total quantity.
     *
     * @param $product
     * @param $start_date
     * @param $end_date
     *
     * @return int
     */
    public static function promotion($product, $start_date, $end_date = null): int
    {
        $claimed_promos = self::where('customer_code', auth()->user()->customer->code)->with('lines')
            ->whereHas('lines', static function (
                $query
            ) use ($product) {
                $query->where('stock_type', 'PROMO');
                $query->where('product', $product);
            })->where('created_at', '>=', $start_date)->where(static function ($query) use ($end_date) {
                if ($end_date) {
                    $query->where('created_at', '<=', $end_date);
                }
            })->get();

        $claim_qty = 0;

        if ($claimed_promos) {
            foreach ($claimed_promos as $claimed_promo) {
                foreach ($claimed_promo->lines as $line) {
                    if ($line->stock_type === 'PROMO' && $line->product = $product) {
                        $claim_qty += $line->quantity;
                    }
                }
            }
        }

        return $claim_qty;
    }
}
