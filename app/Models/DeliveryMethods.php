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
    public static function show(): Collection
    {
        return (new DeliveryMethods)->orderBy('price', 'asc')->get();
    }

    /**
     * Get delivery details for the given ID.
     *
     * @param $id
     * @return array
     */
    public static function details($id) : array
    {
        $delivery_details = (new DeliveryMethods)->where('uuid', $id)->first();

        // Work out any calculations.
        $delivery = [
            'title' => $delivery_details->title,
            'code' => $delivery_details->code,
            'cost' => $delivery_details->price,
        ];

        return $delivery;
    }
}
