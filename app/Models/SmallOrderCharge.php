<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SmallOrderCharge.
 *
 * @mixin Eloquent
 */
class SmallOrderCharge extends Model
{
    /**
     * Check to see if a small order charge should be applied to an order.
     *
     * @param $order_value
     * @param $country
     *
     * @return int
     */
    public static function value($order_value, $country = null): int
    {
        if ($country) {
            $small_order = self::where('country', $country)->first();
        } else {
            $small_order = self::where('country')->first();
        }

        if ($small_order && $order_value < $small_order->threshold) {
            return (int) $small_order->charge;
        }

        return 0;
    }

    /**
     * Check to see if any small order charges exist (To know if it should be displayed).
     *
     * @return bool
     */
    public static function enabled(): bool
    {
        $charges = self::get();

        if ($charges) {
            return true;
        }

        return false;
    }
}
