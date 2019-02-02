<?php

namespace App\Models\OrderTracking;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Addresses
 *
 * @mixin \Eloquent
 */
class Header extends Model
{
    protected $table = 'order_tracking_header';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lines()
    {
        return $this->hasMany(Lines::class, 'order_no', 'order_no')->orderBy('order_line_no', 'asc');
    }

    /**
     * Gets the list of all orders for current customer.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function list()
    {
        return (new Header)->where('customer_code', Auth::user()->customer_code)
            ->orderBy('date_received', 'desc')->paginate(10);
    }

    /**
     * Show order details for order number
     *
     * @param $order
     * @return Header|Model|object|null
     */
    public static function show($order)
    {
        return (new Header)->where('customer_code', Auth::user()->customer_code)
            ->where('order_no', $order)->first();
    }
}
