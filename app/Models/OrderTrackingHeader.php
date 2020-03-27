<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

/**
 * App\Models\OrderTrackingHeader.
 *
 * @mixin Eloquent
 */
class OrderTrackingHeader extends Model
{
    protected $table = 'order_tracking_header';

    public $timestamps = false;

    /**
     * Return all the lines for the order.
     *
     * @return HasMany
     */
    public function lines(): HasMany
    {
        return $this->hasMany(OrderTrackingLine::class, 'order_no', 'order_no')->orderBy('order_line_no');
    }

    /**
     * Gets the list of all orders for current customer, if a search is passed, only
     * return the results from the search.
     *
     * @param $search
     * @param $request
     *
     * @return LengthAwarePaginator
     */
    public static function list($search, $request): LengthAwarePaginator
    {
        if ($search) {
            return self::where('customer_code', auth()->user()->customer->code)->when($request, static function (Eloquent $query
            ) use ($request) {
                if ($request->keyword) {
                    $query->where(static function (Eloquent $query) use ($request) {
                        $query->where('order_no', 'like', '%'.$request->keyword.'%')->orWhere('customer_order_no', 'like', '%'.$request->keyword.'%');
                    });
                }

                if ($request->status) {
                    $query->where('status', $request->status);
                }

                if ($request->start_date) {
                    $date_from = Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d');

                    $query->where('date_received', '>=', $date_from);
                }

                if ($request->end_date) {
                    $date_to = Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');

                    $query->where('date_received', '<=', $date_to);
                }
            })->orderBy('date_received', 'desc')->paginate(10);
        }

        return self::where('customer_code', auth()->user()->customer->code)->orderBy('date_received', 'desc')->paginate(10);
    }

    /**
     * Show order details for order number.
     *
     * @param $order
     *
     * @return OrderTrackingHeader|Model|object|null
     */
    public static function show($order)
    {
        return self::where('customer_code', auth()->user()->customer->code)->where('order_no', $order)->with('lines')->firstOrFail();
    }

    /**
     * Get all the backorders for the logged in customer.
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Builder[]|Collection
     */
    public static function backOrders()
    {
        return self::selectRaw('order_tracking_header.order_no, order_tracking_header.date_received, order_tracking_lines.product, order_tracking_lines.line_qty, order_tracking_lines.long_description, MIN(expected_stock.due_date) as due_date')->leftJoin('order_tracking_lines', 'order_tracking_header.order_no', '=', 'order_tracking_lines.order_no')->leftJoin('expected_stock', 'order_tracking_lines.product', '=', 'expected_stock.product')->where('customer_code', auth()->user()->customer->code)->whereNotIn('status', [
            'Invoiced',
            'Cancelled',
        ])->where('order_tracking_header.order_no', 'like', '%/%')->where('order_tracking_lines.product', 'not like', '%M19%')->groupBy('order_tracking_header.order_no', 'order_tracking_header.date_received', 'order_tracking_lines.product', 'order_tracking_lines.line_qty', 'order_tracking_lines.long_description')->get();
    }
}
