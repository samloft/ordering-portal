<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * App\Models\Customer
 *
 * @mixin Eloquent
 */
class DeliveryMethods extends Model
{
    /**
     * Return all delivery methods ordered by cheapest > most expensive.
     *
     * @return Collection
     */
    public static function show() : Collection
    {
        return (new DeliveryMethods)->orderBy('price', 'asc')->get();
    }
}
