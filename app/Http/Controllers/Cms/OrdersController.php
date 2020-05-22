<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\OrderHeader;
use Illuminate\Http\RedirectResponse;

class OrdersController extends Controller
{
    /**
     * Display all imported orders.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $orders = OrderHeader::where('imported', true)->orderBy('created_at', 'desc')->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Change an order that has been marked as imported to be re-imported.
     *
     * @param $order_number
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markForImport($order_number): RedirectResponse
    {
        $order = OrderHeader::findOrFail($order_number);

        $order->imported = false;
        $order->save();

        return back()->with('success', 'Order '.$order_number.' has been marked to be re-imported');
    }
}
