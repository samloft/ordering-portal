<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrderImport
 *
 * @mixin Eloquent
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
     * Adds an array of all validated products that have been uploaded from CSV.
     *
     * @param $lines
     * @return bool
     */
    public static function store($lines): bool
    {
        return static::insert($lines);
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
