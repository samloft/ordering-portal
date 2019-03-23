<?php

namespace App\Models\OrderTracking;

use Carbon\Carbon;
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
     * Gets the list of all orders for current customer, if a search is passed, only
     * return the results from the search.
     *
     * @param $search
     * @param $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function list($search, $request)
    {
        if ($search) {
            return (new Header)->where('customer_code', Auth::user()->customer_code)
                ->when($request, function ($query) use ($request) {
                    if ($request->order_number) {
                        $query->where('order_no', 'like', '%' . $request->order_number . '%');
                    }

                    if ($request->order_ref) {
                        $query->where('customer_order_no', 'like', '%' . $request->order_ref . '%');
                    }

                    if ($request->status) {
                        $query->where('status', $request->status);
                    }

                    if ($request->date_from) {
                        $date_from = Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');

                        $query->where('date_received', '>=', $date_from);
                    }

                    if ($request->date_to) {
                        $date_to = Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');

                        $query->where('date_received', '<=', $date_to);
                    }
                })
                ->orderBy('date_received', 'desc')->paginate(10);
        }

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
