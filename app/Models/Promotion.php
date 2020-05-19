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
 * @property string $name
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
        'name',
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
     * Return all promotions that have not yet ended.
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
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function active()
    {
        return self::where('start_date', '<=', Carbon::now()->format('Y-m-d'))->where(static function ($query) {
            $query->where('end_date', '>=', Carbon::now()->format('Y-m-d'));
            $query->orWhere('end_date', null);
        })->get();
    }

    /**
     * Calculate how many promotions a customer can potentially claim.
     *
     * @param $promotions
     * @param $type
     * @param $data
     *
     * @return array
     */
    public static function calculate($promotions, $type, $data): array
    {
        $customer_promotions = [];

        foreach ($promotions as $promotion) {
            if (! $promotion->restrictions || in_array(auth()->user()->customer->{$promotion->restrictions}, $promotion->{$promotion->restrictions.'s'}, true)) {
                if ($type === 'value' && $promotion->type === 'value') {
                    $customer_promotions[] = self::checkValue($promotion, $data);
                } elseif ($type === 'product' && $promotion->type === 'product') {
                    $customer_promotions[] = self::checkProduct($promotion, $data);
                }
            }
        }

        return $customer_promotions;
    }

    /**
     * Check to see if the customer has qualified for a value based promotion
     * or if they are within a percent to justify notifying them.
     *
     * @param $promotion
     * @param $goods_total
     *
     * @return array|bool
     */
    public static function checkValue($promotion, $goods_total)
    {
        if ($goods_total >= ($promotion->minimum_value * 0.75) && $goods_total <= $promotion->minimum_value) {
            $reward_type = null;

            if ($promotion->value_reward === 'percent') {
                $reward_type = $promotion->value_percent.'% discount off your order';
            } else {
                $qty = self::calculateClaimAmount($promotion, $goods_total);

                if ($qty > 0) {
                    $reward_type = $qty.' '.$promotion->promotion_product.'\'s';
                }
            }

            if ($reward_type) {
                return [
                    'reached' => false,
                    'potential_promotion' => true,
                    'message' => 'You are only '.currency($promotion->minimum_value - $goods_total, 2).' away from getting '.$reward_type,
                ];
            }
        }

        if ($goods_total >= $promotion->minimum_value) {
            if ($promotion->value_reward === 'percent') {
                return [
                    'reached' => true,
                    'type' => 'percent',
                    'value' => ($goods_total / 100) * $promotion->value_percent,
                ];
            }

            if ($promotion->value_reward === 'product') {
                $qty = self::calculateClaimAmount($promotion, $goods_total);

                if ($qty > 0) {
                    $promotion_image = Product::checkImage($promotion->promotion_product)['image'];

                    return [
                        'reached' => true,
                        'type' => 'product',
                        'product' => $promotion->promotion_product,
                        'quantity' => $qty,
                        'name' => 'FOC promotional item',
                        'description' => $promotion->name,
                        'price' => currency(0.00, 2),
                        'image' => $promotion_image,
                    ];
                }
            }
        }

        return false;
    }

    /**
     * Check to see if the customer has qualified for a product based promotion
     * or if they are within a percent to justify notifying them.
     *
     * @param $promotion
     * @param $line
     *
     * @return array|bool
     */
    public static function checkProduct($promotion, $line)
    {
        $qty = self::calculateClaimAmount($promotion, $promotion->product_qty);

        if ($line->product === $promotion->product) {
            if ($line->quantity >= ($promotion->product_qty * 0.75) && $line->quantity < $promotion->product_qty && $qty > 0) {
                return [
                    'reached' => false,
                    'potential_promotion' => true,
                    'message' => 'You are only '.($promotion->product_qty - $line->quantity).' '.$promotion->product.'\'s away from getting '.$qty.' '.$promotion->promotion_product.'\'s',
                ];
            }

            if ($line->quantity >= $promotion->product_qty && $qty > 0) {
                $promotion_image = Product::checkImage($promotion->promotion_product)['image'];

                return [
                    'reached' => true,
                    'product' => $promotion->promotion_product,
                    'type' => 'product',
                    'quantity' => $promotion->promotion_qty * $qty,
                    'name' => 'FOC promotional item',
                    'description' => $promotion->name,
                    'price' => currency(0.00, 2),
                    'image' => $promotion_image,
                ];
            }
        }

        return false;
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
            $amount = floor($amount / $promotion->minimum_value);
        } else {
            $potential_claims = floor($amount / $promotion->product_qty);
        }

        if (! $promotion->max_claims) {
            if ($amount > 0) {
                return $promotion->claim_type === 'per_order' ? $promotion->promotion_qty : floor($amount / $promotion->promotion_qty);
            }

            return 0;
        }

        $claimed = OrderHeader::promotion($promotion->product, $promotion->start_date, $promotion->end_date) / $promotion->promotion_qty;

        if ($promotion->max_claims > $claimed) {
            $claims_left = ($promotion->max_claims - $claimed);

            $claim_count = ($claims_left < $potential_claims) ? $claims_left : $potential_claims;

            return $promotion->claim_type === 'per_order' ? $promotion->promotion_qty : ($promotion->promotion_qty * number_format($claim_count, 0));
        }

        return 0;
    }
}
