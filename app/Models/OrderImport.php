<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\OrderImport
 *
 * @mixin \Eloquent
 */
class OrderImport extends Model
{
    /**
     * Clears down any previous uploaded lines for current logged in user.
     *
     * @return mixed
     * @throws \Exception
     */
    public static function clearDown()
    {
        return (new OrderImport)->where('user_id', Auth::user()->id)->delete();
    }

    /**
     * Adds an array of all validated products that have been uploaded from CSV.
     *
     * @param $lines
     * @return mixed
     */
    public static function store($lines)
    {
        return (new OrderImport)->insert($lines);
    }

    /**
     * Return all order import lines based on customer.
     *
     * @return OrderImport[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function show()
    {
        return (new OrderImport)->where('customer_code', Auth::user()->customer_code)->get()->toArray();
    }
}
