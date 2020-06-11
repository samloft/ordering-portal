<?php

namespace App\Http\Controllers;

use App\Exports\ConfirmationPDF;
use App\Models\Basket;
use App\Models\GlobalSettings;
use App\Models\OrderTrackingHeader;
use App\Models\OrderTrackingLine;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class OrderTrackingController extends Controller
{
    /**
     * Display the order tracking page, showing all orders for the customer if
     * no search parameters, else get results that match the search.
     *
     * @return Factory|View
     */
    public function index()
    {
        $search = request()->all() ? true : false;

        $orders = OrderTrackingHeader::list($search, request());

        return view('order-tracking.index', compact('orders'));
    }

    /**
     * Show details for the given order number.
     *
     * @param $order_number
     *
     * @return Factory|View
     */
    public function show($order_number)
    {
        $order = OrderTrackingHeader::show(decodeUrl($order_number));

        $lines = [];

        foreach ($order->lines as $line) {
            $lines[] = [
                'product' => trim($line->product),
                'long_description' => trim($line->long_description),
                'line_qty' => trim($line->line_qty),
                'net_price' => currency($line->net_price, 4),
                'line_val' => currency($line->line_val, 2),
                'purchasable' => $line->price ? true : false,
            ];
        }

        return view('order-tracking.show', compact('order', 'lines'));
    }

    /**
     * Copy the order lines from a given order number.
     *
     * @return RedirectResponse|Redirector
     */
    public function copy()
    {
        $order_number = request('order_number');

        $order_lines = OrderTrackingLine::copy(urldecode($order_number));

        Basket::store($order_lines);

        return redirect(route('basket'))->with('success', 'Order lines from order '.decodeUrl($order_number).' have been added to your basket');
    }

    /**
     * Make a lookup for the given order number to see if a copy invoice can be found on the
     * document archive.
     *
     * @param $order_number
     * @param $customer_order_number
     * @param bool $download
     *
     * @return array
     */
    public function invoicePdf($order_number, $customer_order_number, $download = false): array
    {
        OrderTrackingHeader::show(urldecode($order_number));

        $customer_code = urlencode(trim(auth()->user()->customer->code));

        $document_url = config('app.archive_url').'DOCID='.GlobalSettings::versionOneDocId().'&S0F=ARCH_USER&S0O=EQ&S0V=&S1F=ARCH_DATE&S1O=EQ&S1V=&S2F=DELIVERY_NOTE_NUMBER&S2O=EQ&S2V='.$order_number.'&S3F=CUSTOMER_CODE&S3O=EQ&S3V='.$customer_code.'&S4F=CUSTOMER_ORDER_NO&S4O=EQ&S4V='.$customer_order_number;

        $document = Http::get($document_url);

        if ($document->status() === 200 && isset($document->headers()['Content-Type']) && $document->headers()['Content-Type'][0] === 'application/pdf') {
            if ($download) {
                header('Content-type: application/pdf');
                header('Content-disposition: attachment;filename='.str_replace('/', '_', urldecode($order_number).'.pdf'));

                echo $document;
            }

            return [
                'pdf_exists' => true,
            ];
        }

        return [
            'pdf_exists' => false,
        ];
    }

    /**
     * @param $order_number
     *
     * @return \Illuminate\Http\Response
     */
    public function orderDetailsPDF($order_number): Response
    {
        $order = OrderTrackingHeader::show(decodeUrl($order_number));

        return (new ConfirmationPDF($order))->download(true);
    }
}
