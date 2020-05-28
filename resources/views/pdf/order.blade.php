@extends('layout.master-pdf')

@section('report.title', 'Order Confirmation')

@section('content')
    <div class="row mb-20">
        <div class="col-33">
            <b>Account Code:</b> {{ $order['customer_code'] }}<br>

            @if($order['placed_by'])
                <b>Placed By:</b> {{ $order['placed_by'] }}<br>
            @endif

            <b>Order Number:</b> {{ $order['order_no'] }}<br>
            <b>Order Date:</b> {{ $order['ordered'] }}<br>
            <b>Order Reference:</b> {{ $order['reference'] }}<br>
            <b>Delivery Method:</b> {{ $order['delivery'] }}<br>
        </div>

        <div class="col-33">
            <div>
                <b>Invoice Address</b>
            </div>
            <div>{{ $order['invoice_address']['line_1'] }}</div>
            <div>{{ $order['invoice_address']['line_2'] }}</div>
            <div>{{ $order['invoice_address']['line_3'] }}</div>
            <div>{{ $order['invoice_address']['line_4'] }}</div>
        </div>

        <div class=col-33">
            <div>
                <b>Delivery Address</b>
            </div>
            <div>{{ $order['delivery_address']['line_1'] }}</div>
            <div>{{ $order['delivery_address']['line_2'] }}</div>
            <div>{{ $order['delivery_address']['line_3'] }}</div>
            <div>{{ $order['delivery_address']['line_4'] }}</div>
            <div>{{ $order['delivery_address']['line_5'] }}</div>
        </div>
    </div>

    @if($order['collection_message'])
        <div class="mb-20" style="text-align: center; text-decoration: underline; font-weight: 600;">
            {{ $order['collection_message'] }}
        </div>
    @endif

    <table>
        <thead>
        <tr>
            <th scope="col">Product</th>
            <th scope="col">Name</th>
            <th scope="col">Quantity</th>
            <th scope="col">Discount</th>
            <th scope="col">Net Price</th>
            <th scope="col">Line Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order['lines'] as $line)
            <tr>
                <td>{{ $line['product'] }}</td>
                <td>{{ $line['description'] }}</td>
                <td class="text-right">{{ $line['line_qty'] }}</td>
                <td class="text-right">{{ $line['discount'] }}</td>
                <td class="text-right">{{ $line['net_price'] }}</td>
                <td class="text-right">{{ $line['line_val'] }}</td>
            </tr>
        @endforeach
        <tfoot>
        <tr>
            <th colspan="4" class="text-left border-0">Notes</th>
            <th colspan="1" class="text-right">Goods</th>
            <td class="text-right">{{ $order['values']['goods'] }}</td>
        </tr>
        @if($order['values']['discount'])
            <tr>
                <td colspan="4" class="text-left border-0 font-thin">{{ $order['notes'] }}</td>
                <th colspan="1" class="text-right">Discount</th>
                <td class="text-right">- {{ $order['values']['discount'] }}</td>
            </tr>
        @endif
        <tr>
            @if(!$order['values']['discount'])
                <td colspan="4" class="text-left border-0 font-thin">{{ $order['notes'] }}</td>
                <th colspan="1" class="text-right">Shipping</th>
            @else
                <th colspan="5" class="text-right">Shipping</th>
            @endif
            <td class="text-right">{{ $order['values']['shipping'] }}</td>
        </tr>
        <tr>
            <th colspan="5" class="text-right">Sub total</th>
            <td class="text-right">{{ $order['values']['sub_total'] }}</td>
        </tr>
        <tr>
            <th colspan="5" class="text-right">Small Order Charge</th>
            <td class="text-right">{{ $order['values']['small_order_charge'] }}</td>
        </tr>
        <tr>
            <th colspan="5" class="text-right">VAT</th>
            <td class="text-right">{{ $order['values']['vat'] }}</td>
        </tr>
        <tr>
            <th colspan="5" class="text-right">Total</th>
            <td class="text-right">{{ $order['values']['total'] }}</td>
        </tr>
        </tfoot>
    </table>
@endsection
