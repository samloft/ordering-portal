<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Product.
 *
 * @mixin \Eloquent
 * @property string $type
 * @property string $product
 * @property int $product_qty
 * @property string $value_reward
 * @property string $promotion_product
 * @property int $promotion_qty
 * @property float $minimum_value
 * @property float $value_percent
 * @property string $claim_type
 * @property int $max_claims
 * @property string $restrictions
 * @property string $buying_groups
 * @property string $price_lists
 * @property string $discount_codes
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at
 */
class Promotion extends Model
{
    use SoftDeletes;
    use LogsActivity;

    protected $fillable = [
        'type',
        'product',
        'product_qty',
        'value_reward',
        'promotion_product',
        'promotion_qty',
        'minimum_value',
        'value_percent',
        'claim_type',
        'max_claims',
        'restrictions',
        'buying_groups',
        'price_lists',
        'discount_codes',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'buying_groups' => 'array',
        'price_lists' => 'array',
        'discount_codes' => 'array',
        'start_date' => 'date:d-m-Y',
        'end_date' => 'date:d-m-Y',
    ];

    protected static $logFillable = true;

    /**
     * Set the format that is received for the start date.
     *
     * @param $value
     *
     * @throws \Exception
     */
    public function setStartDateAttribute($value): void
    {
        $this->attributes['start_date'] = (new Carbon($value))->format('Y-m-d');
    }

    /**
     * Set the format that is received for the end date.
     *
     * @param $value
     *
     * @throws \Exception
     */
    public function setEndDateAttribute($value): void
    {
        $this->attributes['end_date'] = $value ? (new Carbon($value))->format('Y-m-d') : null;
    }

    /**
     * Return (paginate) all promotions that have not yet ended.
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function notExpired()
    {
        return self::where('end_date', null)->orWhere('end_date', '>=', Carbon::now()->format('Y-m-d'))->get();
    }

    /**
     * Get all the available promotions for the given customer.
     *
     * @param $customer
     *
     * @return array
     */
    public static function customer($customer): array
    {
        $promotions = self::where('start_date', '<=', Carbon::now()->format('Y-m-d'))->where(static function ($query) {
            $query->where('end_date', '>=', Carbon::now()->format('Y-m-d'));
            $query->orWhere('end_date', null);
        })->get();

        $customer_promotions = [];

        foreach ($promotions as $promotion) {
            if (! $promotion->restrictions || in_array($customer->{$promotion->restrictions}, $promotion->{$promotion->restrictions.'s'}, true)) {
                $customer_promotions[] = $promotion;
            }
        }

        return $customer_promotions;
    }

    /**
     * Check how many times a customer can claim the current promotion.
     *
     * @param $promotion
     * @param $amount
     *
     * @return false|float|int
     */
    public static function calculateClaimAmount($promotion, $amount)
    {
        if ($promotion->type === 'value') {
            $potential_claims = floor($amount / $promotion->minimum_value);
            $amount = number_format($amount / $promotion->minimum_value, 0);
        } else {
            $potential_claims = floor($amount.$promotion->product_qty);
        }

        if (! $promotion->max_claims) {
            return $promotion->claim_type === 'per_order' ? $promotion->promotion_qty : floor($amount / $promotion->product_qty);
        }

        $claimed = OrderHeader::promotion($promotion->product, $promotion->start_date, $promotion->end_date) / $promotion->promotion_qty;

        if ($promotion->max_claims > $claimed) {
            $claims_left = ($promotion->max_claims - $claimed);

            if ($claims_left < $potential_claims) {
                $claim_count = $claims_left;
            } else {
                $claim_count = $potential_claims;
            }

            return $promotion->claim_type === 'per_order' ? $promotion->promotion_qty : ($promotion->promotion_qty * number_format($claim_count, 0));
        }

        return 0;
    }
}
