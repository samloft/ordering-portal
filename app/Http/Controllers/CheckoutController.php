<?php

namespace App\Http\Controllers;

use App\Models\Addresses;
use App\Models\Basket;
use App\Models\DeliveryMethods;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Auth;

class CheckoutController extends Controller
{
    /**
     * Show the checkout page so a user can complete the order.
     *
     * @return Factory|View
     */
    public function index()
    {
        $basket = Basket::show();
        $delivery_methods = DeliveryMethods::show();

        if (!Auth::user()->can_order) {
            return redirect(route('basket'))->with('error', 'You do not have permission to place orders, if you believe this is in error, please contact the sames office');
        }

        if ($basket['line_count'] == 0) {
            return redirect(route('basket'))->with('error', 'You have no items in your basket to checkout with.');
        }

        $default_address = Addresses::getDefault();

        return view('checkout.index', compact('default_address', 'basket', 'delivery_methods'));
    }

    /**
     * Place the customers order.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validation($request);

        if (!$request->terms) {
            return back()->with('error', 'You must accept the terms before you can place your order.')->withInput($request->all());
        }

        dd($request);
    }

    public function complete($order_number)
    {

    }

    /**
     * Validate checkout details.
     *
     * @param $request
     * @return mixed
     */
    public function validation($request)
    {
        return $request->validate([
            'reference' => 'required',
            'shipping' => 'required|exists:delivery_methods,uuid',
            'first_name' => 'required',
            'last_name' => 'required'
        ]);
    }
}
