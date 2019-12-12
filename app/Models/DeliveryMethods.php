<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * App\Models\DeliveryMethods
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
        return self::orderBy('price')->get();
    }

    /**
     * Get delivery details for the given ID.
     *
     * @param $id
     * @return array
     */
    public static function details($id) : array
    {
        $delivery_details = self::where('uuid', $id)->findOrFail();

        // Work out any calculations.
        return [
            'title' => $delivery_details->title,
            'code' => $delivery_details->code,
            'cost' => $delivery_details->price,
        ];
    }
}
