<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Basket;
use App\Models\DeliveryMethod;
use App\Models\GlobalSettings;
use App\Models\OrderHeader;
use App\Models\OrderLine;
use App\Notifications\OrderPlacedNotification;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Show the checkout page so a user can complete the order.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function index()
    {
        $delivery_methods = DeliveryMethod::show();
        $basket = Basket::show(old('shipping') ?: 'HHH');
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     *
     * @throws \Throwable
     */
    public function store()
    {
        $this->validation();

        $delivery_address = session('address') ?: Address::getDefault();

        if (! $delivery_address) {
            return back()->with('error', 'You must select a delivery address')->withInput(request()->all());
        }

        $basket = Basket::show(request('shipping'));

        $order_number = GlobalSettings::nextOrderNumber();

        $header = [
            'order_number' => $order_number,
            'customer_code' => auth()->user()->customer->code,
            'user_id' => auth()->id(),
            'reference' => request('reference'),
            'notes' => request('notes'),
            'name' => request('name'),
            'telephone' => request('telephone'),
            'mobile' => request('mobile'),
            'address_line_1' => $delivery_address['address_details']['company_name'],
            'address_line_2' => $delivery_address['address_details']['address_2'],
            'address_line_3' => $delivery_address['address_details']['address_3'],
            'address_line_4' => $delivery_address['address_details']['address_4'],
            'address_line_5' => $delivery_address['address_details']['postcode'],
            'delivery_method' => $basket['summary']['shipping']['identifier'],
            'delivery_code' => $basket['summary']['shipping']['code'],
            'delivery_cost' => removeCurrencySymbol($basket['summary']['shipping']['cost']),
            'small_order_charge' => removeCurrencySymbol($basket['summary']['small_order_charge']),
            'value' => removeCurrencySymbol($basket['summary']['total']),
            'imported' => false,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $lines = [];

        foreach ($basket['lines'] as $line) {
            $lines[] = [
                'order_number' => $order_number,
                'product' => $line['product'],
                'description' => $line['name'],
                'quantity' => $line['quantity'],
                'stock_type' => $line['type'],
                'price' => $line['unit_price'],
                'total' => ($line['unit_price'] * $line['quantity']),
                'created_at' => date('Y-m-d H:i:s'),
            ];
        }

        DB::transaction(static function () use ($lines, $header) {
            OrderLine::insert($lines);

            OrderHeader::insert($header);

            Basket::clear();
        }, 5);

        auth()->user()->notify(new OrderPlacedNotification($header));

        if (session('address')) {
            session()->forget('address');
        }

        return view('checkout.completed', compact('order_number'));
    }

    /**
     * @param $order_number
     *
     * @return mixed
     */
    public static function confirmation($order_number = null)
    {
        $order_number = $order_number ?? request('order_number');

        $order = OrderHeader::where('customer_code', auth()->user()->customer->code)->where('order_number', decodeUrl($order_number))->firstOrFail();
        $company_details = json_decode(GlobalSettings::key('company-details'), true);

        return PDF::loadView('pdf.order', compact('order', 'company_details'))->download(decodeUrl($order_number).'.pdf');
    }

    /**
     * Validate checkout details.
     *
     * @return mixed
     */
    public function validation()
    {
        return request()->validate([
            'reference' => 'required',
            'shipping' => 'required|exists:delivery_methods,code',
            'name' => 'required',
            'terms' => 'accepted',
        ]);
    }
}
