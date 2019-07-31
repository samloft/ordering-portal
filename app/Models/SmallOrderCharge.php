<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Products
 *
 * @mixin Eloquent
 */
class SmallOrderCharge extends Model
{
    public $table = 'small_order_charge';

    /**
     * Check to see if a small order charge should be applied to an order.
     *
     * @param $order_value
     * @param $country
     * @return int
     */
    public static function value($order_value, $country = null)
    {
        if ($country) {
            $small_order = (new SmallOrderCharge)->where('country', $country)->first();

            if ($small_order) {
                if ($order_value < $small_order->threshold) {
                    return (int)$small_order->charge;
                }

                return 0;
            }
        } else {
            // Country with a null value is a 'Global' option to apply to any country.
            $small_order = (new SmallOrderCharge)->where('country', null)->first();

            if ($small_order) {
                if ($order_value < $small_order->threshold) {
                    return (int)$small_order->charge;
                }
            }

            return 0;
        }

        return 0;
    }

    /**
     * Check to see if any small order charges exist (To know if it should be displayed).
     *
     * @return bool
     */
    public static function enabled()
    {
        $charges = (new SmallOrderCharge)->get();

        if ($charges) {
            return true;
        }

        return false;
    }
}
