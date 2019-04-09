@extends('layout.master')

@section('page.title', 'Review Order')

@section('content')
    <h1 class="page-title">{{ __('Review Order') }}</h1>

    @include('layout.alerts')

    <div class="row">
        <div class="col d-flex align-items-stretch">
            <div class="card card-body">
                <div class="row">
                    <div class="col">
                        <h2 class="section-title">{{ __('Delivery Address') }}</h2>

                        <div class="address">
                            <span>{{ $order->delivery_address1 }}</span>
                            <span>{{ $order->delivery_address2 }}</span>
                            <span>{{ $order->delivery_address3 }}</span>
                            <span>{{ $order->delivery_address4 }}</span>
                            <span>{{ $order->delivery_address5 }}</span>
                        </div>
                    </div>
                    <div class="col">
                        <h2 class="section-title">{{ __('Invoice Address') }}</h2>

                        <div class="address">
                            <span>{{ $order->invoice_address_1 }}</span>
                            <span>{{ $order->invoice_address_2 }}</span>
                            <span>{{ $order->invoice_address_3 }}</span>
                            <span>{{ $order->invoice_address_4 }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col d-flex align-items-stretch">
            <div class="card card-body">
                <h2 class="section-title">{{ __('Order Details') }}</h2>

                <div class="row">
                    <div class="col">{{ __('Order Number') }}</div>
                    <div class="col">{{ $order->order_no }}</div>
                </div>

                <div class="row">
                    <div class="col">{{ __('Your Reference') }}</div>
                    <div class="col">{{ $order->customer_order_no }}</div>
                </div>

                <div class="row">
                    <div class="col">{{ __('Delivery Service') }}</div>
                    <div class="col">{{ $order->delivery_service }}</div>
                </div>

                <div class="row">
                    <div class="col">{{ __('Net Value') }}</div>
                    <div class="col"><strong>{{ currency($order->value, 2) }}</strong></div>
                </div>

                <div class="row">
                    <div class="col">{{ __('VAT Value') }}</div>
                    <div class="col"><strong>{{ currency($order->vat_value, 2) }}</strong></div>
                </div>

                <div class="row">
                    <div class="col">{{ __('Total Value') }}</div>
                    <div class="col"><strong>{{ currency(($order->value + $order->vat_value), 2) }}</strong></div>
                </div>

                <h2 class="section-title mt-3">{{ __('Contact Details') }}</h2>

                <div class="row">
                    <div class="col">{{ __('Name') }}</div>
                    <div class="col">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</div>
                </div>

                <div class="row">
                    <div class="col">{{ __('Email') }}</div>
                    <div class="col">{{ Auth::user()->email }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3 mb-3">
        <div class="col">
            <button class="btn btn-blue" onclick="window.history.back();">{{ __('Back') }}</button>
        </div>
        <div class="col text-right">
            <a class="btn-link"
               href="{{ route('order-tracking.copy-to-basket', ['order_number' => encodeUrl(trim($order->order_no))]) }}">
                <button class="btn btn-primary">{{ __('Copy Order To Basket') }}</button>
            </a>
            <a id="invoice-download" class="btn-link d-none">
                <button class="btn btn-primary">{{ __('Download Copy Invoice') }}</button>
            </a>
            <button class="btn btn-primary">{{ __('Print Order Details') }}</button>
        </div>
    </div>

    <table class="table table-sm table-striped table-hover">
        <thead>
        <tr class="table-dark text-dark">
            <th>{{ __('Product Code') }}</th>
            <th>{{ __('Name') }}</th>
            <th class="text-right">{{ __('Quantity') }}</th>
            <th class="text-right">{{ __('Net Price') }}</th>
            <th class="text-right">{{ __('Total Price') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($lines as $line)
            <tr class="{{ $line['purchasable'] ? '' : 'text-danger' }}">
                <td>{{ $line['product'] }}</td>
                <td>{{ $line['long_description'] }}</td>
                <td class="text-right">{{ $line['line_qty'] }}</td>
                <td class="text-right">{{ $line['net_price'] }}</td>
                <td class="text-right">{{ $line['line_val'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="text-right">
        <small class="text-danger">* Products marked in red are no longer available for purchase.</small>
    </div>

    @if(count($lines) == 0)
        <h3 class="text-center">No order lines to display.</h3>
    @endif
@endsection

@section('scripts')
    <script>
        $.get('/order-tracking/invoice/{{ urlencode(trim($order->order_no)) }}/{{ urlencode(trim($order->customer_order_no)) }}/').done(function (response) {
            if (response.pdf_exists) {
                $('#invoice-download')
                    .attr('href', '/order-tracking/invoice/{{ urlencode(trim($order->order_no)) }}/{{ urlencode(trim($order->customer_order_no)) }}/true')
                    .removeClass('d-none');
            }
        }).fail(function (response) {
            return console.log(response);
        });
    </script>
@endsection