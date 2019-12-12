<?php

/**
 *
 * Gets the VAT amount from a given value.
 *
 * @param int $value
 * @param int $vat_percent
 * @return float|int
 */
function vatAmount($value = 0, $vat_percent = 20)
{
    return ($vat_percent / 100) * $value;
}

/**
 * Increase the given value by the VAT percent.
 *
 * @param int $value
 * @param int $vat_percent
 * @return float|int
 */
function vatIncluded($value = 0, $vat_percent = 20)
{
    return $value * (1 + $vat_percent / 100);
}
