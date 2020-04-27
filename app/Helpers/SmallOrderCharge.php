<?php

use App\Models\GlobalSettings;

/**
 * Check to see if an order qualifies for a small order charge.
 *
 * @param $order_value
 * @param null $delivery
 *
 * @return array
 */
function smallOrderCharge($order_value, $delivery = null)
{
    $small_order_data = json_decode(GlobalSettings::smallOrderCharge(), true);

    switch (true) {
        case $delivery && $small_order_data['exclude_on_collection'] && str_contains(strtoupper($delivery->title), 'COLLECT'):
        case $delivery && $small_order_data['exclude_on_charge_delivery'] && $delivery->price > 0:
        case !$delivery && ($order_value > $small_order_data['threshold']):
            $charge = 0.00;
            break;
        default:
            $charge = $small_order_data['charge'];
    }

    return [
        'original' => $small_order_data,
        'threshold' => $small_order_data['threshold'],
        'charge' => $charge,
        'exclude_collection' => $small_order_data['exclude_on_collection'],
        'exclude_charged_delivery' => $small_order_data['exclude_on_charge_delivery'],
    ];
}
