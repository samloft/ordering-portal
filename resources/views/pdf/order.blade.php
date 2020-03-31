@extends('layout.master-pdf')

@section('report.title', 'Order Confirmation')

@section('content')
    <div class="row mb-20">
        <div class="col-33">
            <b>Account Code:</b> {{ auth()->user()->customer->code }}<br>
            <b>Customer:</b> {{ auth()->user()->customer->name }}<br>
            <b>Placed By:</b> {{ auth()->user()->name }}<br>
            <b>Order Number:</b> {{ $order->order_no }}<br>
            <b>Order Date:</b> {{ \Carbon\Carbon::parse($order->date_received)->format('d/m/Y') }}<br>
            <b>Order Reference:</b> {{ $order->customer_order_no }}<br>
            <b>Delivery Method:</b> {{ $order->delivery_service }}<br>
        </div>

        <div class="col-33">
            <div>
                <b>Invoice Address</b>
            </div>
            <div>{{ $order->invoice_address_1 }}</div>
            <div>{{ $order->invoice_address_2 }}</div>
            <div>{{ $order->invoice_address_3 }}</div>
            <div>{{ $order->invoice_address_4 }}</div>
        </div>

        <div class=col-33">
            <div>
                <b>Delivery Address</b>
            </div>
            <div>{{ $order->delivery_address1 }}</div>
            <div>{{ $order->delivery_address2 }}</div>
            <div>{{ $order->delivery_address3 }}</div>
            <div>{{ $order->delivery_address4 }}</div>
            <div>{{ $order->delivery_address5 }}</div>
        </div>
    </div>

    <table>
        <thead>
        <tr>
            <th>Product Code</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Discount</th>
            <th>Net Price</th>
            <th>Line Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order->lines as $line)
            <tr>
                <td>{{ $line->product }}</td>
                <td>{{ substr($line->long_description, 0, 35) }}</td>
                <td class="text-right">{{ $line->line_qty }}</td>
                <td class="text-right">{{ discountPercent() }}</td>
                <td class="text-right">{{ currency($line->net_price) }}</td>
                <td class="text-right">{{ currency($line->line_val) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="row mt-20">
        <div class="col-66">
            <b class="mb-20">Order Notes</b><br>
        </div>
        <div class="col-33">
            Summary

            <ul>
                <li>
                    <div style="width: 150px;">Goods</div>
                    <div>{{ currency($order->value, 2) }}</div>
                </li>
                <li>THINGS</li>
                <li>STUFF</li>
            </ul>
        </div>
    </div>
@endsection
