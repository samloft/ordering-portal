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

    $value_output = $value ? number_format($value, $decimals) : '';

    return $currency_code.$value_output;
}

/**
 * Remove and none numbers or commas or digits from a value and
 * return it as a float.
 *
 * @param $value
 *
 * @return float
 */
function removeCurrencySymbol($value)
{
    return (float) preg_replace('/[^0-9.]/', '', $value);
}
