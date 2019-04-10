<?php

namespace App\Models\OrderTracking;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Auth;

/**
 * App\Models\Addresses
 *
 * @mixin Eloquent
 */
class Header extends Model
{
    protected $table = 'order_tracking_header';

    /**
     * @return HasMany
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
     * @return LengthAwarePaginator
     */
    public static function list($search, $request)
    {
        if ($search) {
            return (new Header)->where('customer_code', Auth::user()->customer->customer_code)
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

        return (new Header)->where('customer_code', Auth::user()->customer->customer_code)
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
        return (new Header)->where('customer_code', Auth::user()->customer->customer_code)
            ->where('order_no', $order)->first();
    }

    /**
     * Get all the backorders for the logged in customer.
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Builder[]|Collection
     */
    public static function backOrders()
    {
        return (new Header)
            ->selectRaw('order_tracking_header.order_no, order_tracking_header.date_received, order_tracking_lines.product, order_tracking_lines.line_qty, order_tracking_lines.long_description, MIN(expected_stock.due_date) as due_date')
            ->leftJoin('order_tracking_lines', 'order_tracking_header.order_no', '=', 'order_tracking_lines.order_no')
            ->leftJoin('expected_stock', 'order_tracking_lines.product', '=', 'expected_stock.product')
            ->where('customer_code', Auth::user()->customer->customer_code)
            ->whereNotIn('status', ['Invoiced', 'Cancelled'])
            ->where('order_tracking_header.order_no', 'like', '%/%')
            ->where('order_tracking_lines.product', 'not like', '%M19%')
            ->groupBy('order_tracking_header.order_no', 'order_tracking_header.date_received', 'order_tracking_lines.product', 'order_tracking_lines.line_qty', 'order_tracking_lines.long_description')
            ->get();
    }
}
