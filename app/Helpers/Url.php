<?php

/**
 * An array of all characters that need to be encoded from a URL and
 * what they should be replaced with.
 *
 * @return array
 */
function urlCharacters()
{
    return [
        '/' => '_',
        ' ' => '+',
        '+' => '%2B',
    ];
}

/**
 * Encode a URL and remove special characters from the urlCharacters() array.
 * For example links with: / replaced by _.
 *
 * @param $url_string
 *
 * @return string
 */
function encodeUrl($url_string)
{
    $characters = urlCharacters();

    return urlencode(str_replace(array_keys($characters), array_values($characters), trim($url_string)));
}

/**
 * Decode a URL, adding back in special characters from the urlCharacters() array (Flipped).
 * For example links with: ^ replaced with _.
 *
 * @param $url_string
 *
 * @return string
 */
function decodeUrl($url_string)
{
    if (! $url_string) {
        return;
    }

    $characters = urlCharacters();

    return urldecode(str_replace(array_values($characters), array_keys($characters), trim($url_string)));
}
