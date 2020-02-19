<?php

use App\Models\GlobalSettings;

/**
 * Check to see if a customer has a discount override in the
 * customer_discounts table, if yes return it else return
 * the global discount percent for the site.
 *
 * @return string
 */
function discountPercent()
{
    // Check to see if a customer has an override discount.
    if (auth()->user()->customer->discount) {
        return auth()->user()->customer->discount->percent.'%';
    }

    // If no override return the global site discount.
    return GlobalSettings::discount().'%';
}

/**
 * Take the given value and reduce it by the sites/customers online
 * discount percentage.
 *
 * @param int $value
 *
 * @return float|int
 */
function discount($value = 0)
{
    if (auth()->user()->customer->discount) {
        $discount_percent = auth()->user()->customer->discount->percent;
    } else {
        $discount_percent = GlobalSettings::discount();
    }

    return $value * ((100 - $discount_percent) / 100);
}
