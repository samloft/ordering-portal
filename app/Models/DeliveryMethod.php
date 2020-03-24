<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * App\Models\DeliveryMethod.
 *
 * @mixin Eloquent
 */
class DeliveryMethod extends Model
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
     * Get delivery details for the given code.
     *
     * @param $code
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public static function details($code)
    {
        return self::where('code', $code)->first();
    }

    /**
     * @param $request
     *
     * @return bool
     */
    public static function store($request): bool
    {
        $delivery = new self;

        $delivery->code = $request->code;
        $delivery->title = $request->title;
        $delivery->identifier = $request->identifier;
        $delivery->price_low = $request->price_low;
        $delivery->price = $request->price;

        return $delivery->save();
    }

    /**
     * @param $request
     *
     * @return \App\Models\DeliveryMethod|\App\Models\DeliveryMethod[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public static function edit($request)
    {
        $delivery = self::findOrFail($request->id);

        $delivery->update([
            'code' => $request->code,
            'title' => $request->title,
            'identifier' => $request->identifier,
            'price_low' => $request->price_low,
            'price' => $request->price,
        ]);

        return $delivery;
    }
}
