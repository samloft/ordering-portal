<?php

namespace App\Exports;

use App\Models\Customer;
use App\Models\GlobalSettings;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;

class ConfirmationPDF
{
    protected $order;

    protected $collection_message;

    protected $user_id;

    /**
     * ConfirmationPDF constructor.
     *
     * @param $order
     * @param $collection_message
     * @param $user_id
     */
    public function __construct($order, $collection_message = null, $user_id = null)
    {
        $this->order = $order;

        $this->collection_message = $collection_message;

        $this->user_id = $user_id;
    }

    /**
     * @param bool $tracking
     *
     * @return array
     */
    public function orderDetails($tracking): array
    {
        if ($this->user_id) {
            auth()->loginUsingId($this->user_id);
        }

        if ($tracking) {
            $placed_by = $this->order->original ? $this->order->original->user->name : '';

            $invoice_address = [
                'line_1' => $this->order->invoice_address_1,
                'line_2' => $this->order->invoice_address_2,
                'line_3' => $this->order->invoice_address_3,
                'line_4' => $this->order->invoice_address_4,
            ];

            $delivery_address = [
                'line_1' => $this->order->delivery_address1,
                'line_2' => $this->order->delivery_address2,
                'line_3' => $this->order->delivery_address3,
                'line_4' => $this->order->delivery_address4,
                'line_5' => $this->order->delivery_address5,
            ];

            $discount = 0;
        } else {
            $placed_by = $this->order->user->name;

            $customer = Customer::where('code', $this->order->customer_code)->firstOrFail();

            $invoice_address = [
                'line_1' => $customer->invoice_address_line_1,
                'line_2' => $customer->invoice_address_line_2,
                'line_3' => $customer->invoice_city,
                'line_4' => $customer->invoice_postcode,
            ];

            $delivery_address = [
                'line_1' => $this->order->address_line_1,
                'line_2' => $this->order->address_line_2,
                'line_3' => $this->order->address_line_3,
                'line_4' => $this->order->address_line_4,
                'line_5' => $this->order->address_line_5,
            ];

            $discount = $this->order->promotion_discount;
        }

        $goods_value = 0;

        $order = [
            'order_no' => $this->order->order_number,
            'ordered' => Carbon::parse($this->order->date_received)->format('d/m/Y'),
            'reference' => $this->order->reference,
            'delivery' => $this->order->delivery_method,
            'customer_code' => $this->order->customer_code,
            'placed_by' => $placed_by,
            'invoice_address' => $invoice_address,
            'delivery_address' => $delivery_address,
            'collection_message' => $this->collection_message,
        ];

        $order['lines'] = [];

        if ($this->order->lines) {
            foreach ($this->order->lines as $line) {
                $order['lines'][] = [
                    'product' => $line->product,
                    'description' => substr($line->description, 0, 35),
                    'line_qty' => $line->quantity,
                    'discount' => discountPercent(),
                    'net_price' => currency($line->net_price),
                    'line_val' => currency($line->total),
                ];

                $goods_value += $line->total;
            }
        }

        $order['values'] = [
            'goods' => currency($goods_value, 2),
            'discount' => $discount ? currency($discount, 2) : false,
            'shipping' => currency($this->order->delivery_cost, 2),
            'sub_total' => currency($goods_value + $this->order->delivery_cost - $discount, 2),
            'small_order_charge' => currency($this->order->small_order_charge, 2),
            'vat' => currency($this->order->vat, 2),
            'total' => currency(($this->order->value - $discount) + $this->order->vat, 2),
        ];

        return $order;
    }

    /**
     * @param bool $tracking
     *
     * @return mixed
     */
    public function download($tracking)
    {
        $company_details = json_decode(GlobalSettings::key('company-details'), true);
        $order = $this->orderDetails($tracking);

        return PDF::loadView('pdf.order', compact('order', 'company_details'))->download($order['order_no'].'.pdf');
    }
}
