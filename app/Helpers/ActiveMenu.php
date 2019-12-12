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
function activeMenu(string $route_name, string $class_name = 'active')
{
    return strpos(request()->route()->getName(), $route_name) !== false ? $class_name : '';
}
