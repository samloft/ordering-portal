<?php

/**
 *
 * Gets the currency symbol to use based on the logged in customer.
 *
 * @param integer $value
 * @param int $decimals
 *
 * @return string            Currency symbol if one matches,
 *                           otherwise - default to £
 */
function currency($value = null, $decimals = 4)
{
    $currency = Auth::user()->currency;

    switch ($currency) {
        case 'GBP':
            $currency_code = '£';
            break;
        case 'EUR':
            $currency_code = '€';
            break;
        case 'USD':
            $currency_code = '$';
            break;
        default:
            $currency_code = '£';
    }

    $value_output = $value ? number_format($value, $decimals) : '';

    return $currency_code . $value_output;
}
