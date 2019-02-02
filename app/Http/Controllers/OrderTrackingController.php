<?php

namespace App\Http\Controllers;

use App\Models\OrderTracking\Header;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $orders = Header::list();

        return view('order-tracking.index', compact('orders'));
    }

    /**
     * Show details for the given order number.
     *
     * @param $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($order)
    {
        $order = Header::show($order);

        return view('order-tracking.show', compact('order'));
    }
}
