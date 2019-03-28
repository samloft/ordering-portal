<?php

/**
 *
 * Set active css class if the specific URI is current URI
 *
 * @param string $route_name A specific route name
 * @param string $class_name Css class name, optional
 * @return string            Css class name if it's current URI,
 *                           otherwise - empty string
 */
function setActive(string $route_name, string $class_name = 'active')
{
    return strstr(\Request::route()->getName(), $route_name) ? $class_name : '';
}
