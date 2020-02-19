<?php

/**
 * Gets the currency symbol to use based on the logged in customer.
 *
 * @param int $value
 * @param int $decimals
 *
 * @return string Currency symbol if one matches,
 *                otherwise - default to £
 */
function currency($value = null, $decimals = 4)
{
    $currency = auth()->user()->currency;

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
        case 'AED':
            $currency_code = 'د.إ';
            break;
        default:
            $currency_code = '£';
    }

    $value_output = $value ? number_format($value, $decimals) : number_format(0, 2);

    return $currency_code.$value_output;
}
