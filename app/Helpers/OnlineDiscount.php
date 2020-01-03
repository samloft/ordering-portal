<?php

/**
 * Take the given value and reduce it by the sites/customers online
 * discount percentage.
 *
 * @param int $value
 * @param int $discount_percent
 *
 * @return float|int
 */
function discount($value = 0, $discount_percent = 2)
{
    return $value * ((100 - $discount_percent) / 100);
}
