<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrderImport
 *
 * @mixin \Eloquent
 *
 * @property int $user_id
 * @property string $customer_code
 * @property string $product
 * @property int $quantity
 */
class OrderImport extends Model
{
    /**
     * Clears down any previous uploaded lines for current logged in user/customer combo.
     *
     * @return mixed
     */
    public static function clearDown()
    {
        return static::where('user_id', auth()->user()->id)->where('customer_code', auth()->user()->customer->code)->delete();
    }

    /**
     * Return all order import lines based on customer.
     *
     * @return array
     */
    public static function show(): array
    {
        return static::where('user_id', auth()->user()->id)->where('customer_code', auth()->user()->customer->code)->get()->toArray();
    }
}
