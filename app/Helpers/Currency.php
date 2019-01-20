<?php

/**
 *
 * Gets the currency symbol to use based on the logged in customer.
 *
 * @return string            Currency symbol if one matches,
 *                           otherwise - default to £
 *
 */
function currency()
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

    return $currency_code;
}
