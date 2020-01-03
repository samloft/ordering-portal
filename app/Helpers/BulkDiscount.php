<?php

/**
 * Work out the percentage saving between two values.
 *
 * @param $price
 * @param $discount_price
 *
 * @return float|int
 */
function bulkDiscount($price, $discount_price)
{
    $saving_percent = (1 - $discount_price / $price) * 100;

    return number_format($saving_percent, 2).'%';
}
