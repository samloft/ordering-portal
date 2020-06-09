<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

/**
 * App\Models\OrderTrackingHeader.
 *
 * @mixin \Eloquent
 * @property string $order_number
 * @property string $base_order
 * @property string $reference
 * @property string $status
 * @property string $type
 * @property string $customer_code
 * @property string $invoice_customer
 * @property \Illuminate\Support\Carbon $date_received
 * @property \Illuminate\Support\Carbon $date_required
 * @property \Illuminate\Support\Carbon $date_despatched
 * @property \Illuminate\Support\Carbon $date_invoiced
 * @property string $invoice_no
 * @property string $delivery_address1
 * @property string $delivery_address2
 * @property string $delivery_address3
 * @property string $delivery_address4
 * @property string $delivery_address5
 * @property float $value
 * @property string $invoice_address_1
 * @property string $invoice_address_2
 * @property string $invoice_address_3
 * @property string $invoice_address_4
 * @property string $consignment
 * @property float $vat
 * @property float $small_order_charge
 * @property string $delivery_cost
 * @property float $delivery_charge
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
        return $this->hasMany(OrderTrackingLine::class, 'order_number', 'order_number')->orderBy('order_line_no');
    }

    /**
     * Get the original placed order for things like order notes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function original(): HasOne
    {
        return $this->hasOne(OrderHeader::class, 'order_number', 'order_number');
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
            return self::where('customer_code', auth()->user()->customer->code)->when($request, static function ($query
            ) use ($request) {
                if ($request->keyword) {
                    $query->where(static function ($query) use ($request) {
                        $query->where('order_number', 'like', '%'.$request->keyword.'%')
                            ->orWhere('reference', 'like', '%'.$request->keyword.'%');
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

        return self::where('customer_code', auth()->user()->customer->code)->orderBy('date_received', 'desc')
            ->paginate(10);
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
        return self::where('customer_code', auth()->user()->customer->code)->where('order_number', $order)
            ->with('lines')->with('lines.price')->with('original')->firstOrFail();
    }

    /**
     * Get all the backorders for the logged in customer.
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Builder[]|Collection
     */
    public static function backOrders()
    {
        return self::selectRaw('order_tracking_header.order_number, order_tracking_header.date_received, order_tracking_lines.product, order_tracking_lines.quantity, order_tracking_lines.description, MIN(expected_stock.due_date) as due_date')
            ->leftJoin('order_tracking_lines', 'order_tracking_header.order_number', '=', 'order_tracking_lines.order_number')
            ->leftJoin('expected_stock', 'order_tracking_lines.product', '=', 'expected_stock.product')
            ->where('customer_code', auth()->user()->customer->code)->whereNotIn('status', [
                'Invoiced',
                'Cancelled',
            ])->where('order_tracking_header.order_number', 'like', '%/%')
            ->where('order_tracking_lines.product', 'not like', '%M19%')
            ->groupBy('order_tracking_header.order_number', 'order_tracking_header.date_received', 'order_tracking_lines.product', 'order_tracking_lines.quantity', 'order_tracking_lines.description')
            ->get();
    }
}
