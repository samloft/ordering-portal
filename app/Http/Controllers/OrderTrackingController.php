<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\OrderTracking\Header;
use App\Models\OrderTracking\Lines;
use App\Models\Prices;
use Auth;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search = $request ? true : false;

        $orders = Header::list($search, $request);

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
        $order = Header::show(decodeUrl($order));

        if (!$order) {
            abort(404);
        }

        $lines = [];

        foreach ($order->lines as $line) {
            $lines[] = [
                'product' => trim($line->product),
                'long_description' => trim($line->long_description),
                'line_qty' => trim($line->line_qty),
                'net_price' => currency($line->net_price, 4),
                'line_val' => currency($line->line_val, 2),
                'purchasable' => Prices::product(trim($line->product)),
            ];
        }

        return view('order-tracking.show', compact('order', 'lines'));
    }

    /**
     * Copy the order lines from a given order number.
     *
     * @param $order_number
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function copy($order_number)
    {
        $order_lines = Lines::show(urldecode($order_number));
        $added_to_basket = Basket::store($order_lines);

        if ($added_to_basket) {
            return redirect(route('basket'))->with('success', 'Order lines from order ' . $order_number . ' have been added to your basket');
        } else {
            return back()->with('error', 'An error occurred when copying this order to the basket, please try again');
        }
    }

    public function invoicePdf($order_number, $customer_order_number, $download = false)
    {
        $authorized = Header::show(urldecode($order_number));

        if (!$authorized) {
            return [
                'pdf_exists' => false,
                'error' => 'You do not have permission to view this invoice'
            ];
        }

        $customer_code = urlencode(trim(Auth::user()->customer_code));

        $document_url = 'http://documents.scolmore.com/v1/dbwebq.exe?DbQCMD=LOGIN&DbQCMDNext=SEARCH&SID=36d4afe300&DbQuser=administrator&DbQPass=administrator&DOCID=' . env('V1_DOCID') . '&S0F=ARCH_USER&S0O=EQ&S0V=&S1F=ARCH_DATE&S1O=EQ&S1V=&S2F=DELIVERY_NOTE_NUMBER&S2O=EQ&S2V=' . $order_number . '&S3F=CUSTOMER_CODE&S3O=EQ&S3V=' . $customer_code . '&S4F=CUSTOMER_ORDER_NO&S4O=EQ&S4V=' . $customer_order_number;

        $pdf_file = file_get_contents($document_url);

        if (preg_match("/^%PDF-1.4/", $pdf_file)) {
            if ($download) {
                header("Content-type: application/pdf");
                header("Content-disposition: attachment;filename=" . str_replace('/', '_', urldecode($order_number) . ".pdf"));

                echo $pdf_file;
            }

            return [
                'pdf_exists' => true,
            ];
        }

        return [
            'pdf_exists' => false,
        ];
    }
}
