<?php

namespace App\Http\Controllers;

use App\Exports\ConfirmationPDF;
use App\Models\Address;
use App\Models\Basket;
use App\Models\DeliveryMethod;
use App\Models\GlobalSettings;
use App\Models\OrderHeader;
use App\Models\OrderLine;
use App\Notifications\OrderPlacedNotification;
use Illuminate\Support\Facades\Cache;
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
        Cache::forget('basket-'.auth()->user()->customer->code.'-'.auth()->id());

        if (! auth()->user()->can_order) {
            return redirect(route('basket'))->with('error', 'You do not have permission to place orders, if you believe this is in error, please contact the sales office');
        }

        $delivery_methods = DeliveryMethod::orderBy('price')->get();
        $basket = Basket::show(old('shipping') ?: 1);
        $checkout_notice = GlobalSettings::checkoutNotice();
        $account = request('account');

        if ($basket['line_count'] === 0) {
            return redirect(route('basket'))->with('error', 'You have no items in your basket to checkout with.');
        }

        $default_address = Address::getDefault();

        return view('checkout.index', compact('default_address', 'basket', 'delivery_methods', 'checkout_notice', 'account'));
    }

    /**
     * Place the customers order.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Throwable
     */
    public function store()
    {
        Cache::forget('basket-'.auth()->user()->customer->code.'-'.auth()->id());

        if (! auth()->user()->can_order) {
            return redirect(route('basket'))->with('error', 'You do not have permission to place orders, if you believe this is in error, please contact the sales office');
        }

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
            'address_line_1' => $delivery_address['company_name'],
            'address_line_2' => $delivery_address['address_line_2'],
            'address_line_3' => $delivery_address['address_line_3'],
            'address_line_4' => $delivery_address['address_line_4'],
            'address_line_5' => $delivery_address['post_code'],
            'goods_total' => removeCurrencySymbol($basket['summary']['goods_total']) - removeCurrencySymbol($basket['summary']['order_discount']),
            'delivery_method' => $basket['summary']['shipping']['identifier'],
            'delivery_code' => $basket['summary']['shipping']['code'],
            'delivery_cost' => removeCurrencySymbol($basket['summary']['shipping']['cost']),
            'small_order_charge' => removeCurrencySymbol($basket['summary']['small_order_charge']),
            'vat' => removeCurrencySymbol($basket['summary']['vat']),
            'value' => removeCurrencySymbol($basket['summary']['goods_total']) + removeCurrencySymbol($basket['summary']['shipping']['cost']) + removeCurrencySymbol($basket['summary']['small_order_charge']),
            'promotion_discount' => removeCurrencySymbol($basket['summary']['order_discount']),
            'imported' => false,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $lines = [];

        foreach ($basket['lines'] as $line) {
            $lines[] = [
                'order_number' => $order_number,
                'product' => $line['product'],
                'description' => $line['name'],
                'long_description' => $line['description'],
                'quantity' => $line['quantity'],
                'stock_type' => $line['type'],
                'net_price' => $line['unit_price'],
                'total' => ($line['unit_price'] * $line['quantity']),
                'created_at' => date('Y-m-d H:i:s'),
            ];
        }

        $promotions = [];

        foreach ($basket['promotion_lines'] as $promotion_line) {
            if (isset($promotion_line['product'])) {
                $promotions[] = [
                    'order_number' => $order_number,
                    'product' => $promotion_line['product'],
                    'description' => $promotion_line['name'],
                    'long_description' => $promotion_line['description'],
                    'quantity' => $promotion_line['quantity'],
                    'stock_type' => 'PROMO',
                    'net_price' => 0,
                    'total' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                ];
            }
        }

        $collection_message = false;

        if (stripos($header['delivery_method'], 'COLLECT') !== false) {
            $collection_messages = GlobalSettings::collectionMessages();

            if ($collection_messages['default']) {
                $header['delivery_method'] = $collection_messages['default'];
            } else {
                foreach ($collection_messages['times'] as $message) {
                    $time = date('H:i:s');

                    if ($time >= $message['start'] && $time <= $message['end']) {
                        $collection_message = $message['message'];
                        $header['delivery_method'] = $message['identifier'];
                    }
                }
            }
        }

        DB::transaction(static function () use ($header, $lines, $promotions) {
            OrderLine::insert($lines);
            OrderLine::insert($promotions);

            unset($header['goods_total']);

            OrderHeader::insert($header);

            Basket::clear();
        }, 5);

        auth()->user()->notify(new OrderPlacedNotification($header, $collection_message));

        if (session('address')) {
            session()->forget('address');
        }

        return view('checkout.completed', compact('order_number', 'header', 'lines'));
    }

    /**
     * @param null $order_number
     *
     * @return mixed
     */
    public function confirmation($order_number = null)
    {
        $order_number = $order_number ?? request('order_number');

        $order = OrderHeader::where('customer_code', auth()->user()->customer->code)
            ->where('order_number', decodeUrl($order_number))->firstOrFail();

        return (new ConfirmationPDF($order))->download(false);
    }

    /**
     * Validate checkout details.
     *
     * @return mixed
     */
    public function validation()
    {
        return request()->validate([
            'reference' => 'required|max:20',
            'shipping' => 'required|exists:delivery_methods,id',
            'name' => 'required|max:37',
            'mobile' => 'max:37|nullable',
            'terms' => 'accepted',
        ]);
    }
}
