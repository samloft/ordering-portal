<?php

use App\Models\GlobalSettings;

/**
 * Check to see if an order qualifies for a small order charge.
 *
 * @param $order_value
 * @param null $delivery
 *
 * @return float
 */
function smallOrderCharge($order_value, $delivery = null)
{
    $small_order_data = json_decode(GlobalSettings::smallOrderCharge(), true);

    if ($order_value > $small_order_data['threshold']) {
        return 0.00;
    }

    // If a delivery is passed, we must be on the checkout/checking out.
    if ($delivery) {
        // If we exclude small order charges on collections return 0.
        if ($small_order_data['exclude_on_collection'] && str_contains(strtoupper($delivery->title), 'COLLECT')) {
            return 0.00;
        }

        // If we exclude small order when a delivery is payed for return 0.
        if ($small_order_data['exclude_on_charge_delivery'] && $delivery->price > 0) {
            return 0.00;
        }
    }

    // No delivery passed or the small order charge should be passed.
    return $small_order_data['charge'];
}
