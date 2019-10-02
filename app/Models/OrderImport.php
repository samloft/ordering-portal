<?php

namespace App\Models;

use Eloquent;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrderImport
 *
 * @mixin Eloquent
 */
class OrderImport extends Model
{
    /**
     * Clears down any previous uploaded lines for current logged in user.
     *
     * @return mixed
     * @throws Exception
     */
    public static function clearDown()
    {
        return static::where('user_id', auth()->user()->id)->delete();
    }

    /**
     * Adds an array of all validated products that have been uploaded from CSV.
     *
     * @param $lines
     * @return mixed
     */
    public static function store($lines)
    {
        return static::insert($lines);
    }

    /**
     * Return all order import lines based on customer.
     *
     * @return OrderImport[]|Collection
     */
    public static function show()
    {
        return static::where('customer_code', auth()->user()->customer->code)->get()->toArray();
    }
}
