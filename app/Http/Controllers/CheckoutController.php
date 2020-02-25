<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Basket;
use App\Models\DeliveryMethod;
use App\Models\GlobalSettings;
use Auth;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    /**
     * Show the checkout page so a user can complete the order.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function index()
    {
        $basket = Basket::show();
        $delivery_methods = DeliveryMethod::show();
        $checkout_notice = GlobalSettings::checkoutNotice();

        if (! auth()->user()->can_order) {
            return redirect(route('basket'))->with('error', 'You do not have permission to place orders, if you believe this is in error, please contact the sames office');
        }

        if ($basket['line_count'] === 0) {
            return redirect(route('basket'))->with('error', 'You have no items in your basket to checkout with.');
        }

        $default_address = Address::getDefault();

        return view('checkout.index', compact('default_address', 'basket', 'delivery_methods', 'checkout_notice'));
    }

    /**
     * Place the customers order.
     *
     * @param Request $request
     *
     * @return \App\Http\Controllers\Array
     */
    public function store(Request $request): array
    {
        $this->validation($request);

        if (! $request->terms) {
            return back()->with('error', 'You must accept the terms before you can place your order.')->withInput($request->all());
        }

        $delivery = DeliveryMethod::details($request->shipping);

        $order_details = [
            'header' => [
                'reference'         => $request->reference,
                'notes'             => $request->notes,
                'shipping'          => $delivery,
                'first_name'        => $request->first_name,
                'last_name'         => $request->last_name,
                'telephone'         => $request->telephone,
                'evening_telephone' => $request->evening_telephone,
                'fax'               => $request->fax,
                'mobile'            => $request->mobile,
                'delivery_address'  => session('address') ?: Address::getDefault()->getAttributes(),
            ],
            'details' => Basket::show($delivery['cost']),
        ];

        // After checkout complete
        if (session('address')) {
            session()->forget('address');
        }

        return $order_details;
    }

    public function complete($order_number)
    {
    }

    public function generateOrderFile()
    {
    }

    /**
     * Validate checkout details.
     *
     * @param $request
     *
     * @return mixed
     */
    public function validation($request)
    {
        return $request->validate([
            'reference'  => 'required',
            'shipping'   => 'required|exists:delivery_methods,uuid',
            'first_name' => 'required',
            'last_name'  => 'required',
        ]);
    }
}
