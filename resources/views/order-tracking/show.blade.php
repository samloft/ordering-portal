@extends('layout.master')

@section('page.title', 'Review Order')

@section('content')
    <div class="w-full mb-5 text-center">
        <h2 class="font-semibold tracking-widest">{{ __('Review Order') }}</h2>
        <p class="font-thin">
            {{ __('Review your order and re-order by copying to basket.') }}
        </p>
    </div>

    <div class="bg-white rounded-lg shadow p-4">

        @include('layout.alerts')

        <div class="flex text-left mt-4 items-center">
            <div class="w-1/2">
                <div class="flex">
                    <div class="font-semibold">{{ __('Order Number') }}</div>
                    <div class="pl-2">{{ $order->order_no }}</div>
                </div>

                <div class="flex">
                    <div class="font-semibold">{{ __('Your Reference') }}</div>
                    <div class="pl-2">{{ $order->customer_order_no }}</div>
                </div>

                <div class="flex">
                    <div class="font-semibold">{{ __('Delivery Service') }}</div>
                    <div class="pl-2">{{ $order->delivery_service }}</div>
                </div>

                <div class="flex items-center">
                    <div class="font-semibold">{{ __('Status') }}</div>
                    <div class="pl-2"><span
                            class="badge badge-{{ str_replace(' ', '_', $order->status) }}">{{ $order->status }}</span>
                    </div>
                </div>

                <div class="flex mt-4">
                    <div class="font-semibold">{{ __('Net Value') }}</div>
                    <div class="pl-2">{{ currency($order->value, 2) }}</div>
                </div>

                <div class="flex">
                    <div class="font-semibold">{{ __('VAT Value') }}</div>
                    <div class="pl-2">{{ currency($order->vat_value, 2) }}</div>
                </div>

                <div class="flex">
                    <div class="font-semibold">{{ __('Total Value') }}</div>
                    <div class="pl-2">{{ currency(($order->value + $order->vat_value), 2) }}</div>
                </div>
            </div>

            <div class="w-1/2 text-center bg-gray-200 p-4 rounded">
                <div>{{ $order->delivery_address1 }}</div>
                <div>{{ $order->delivery_address2 }}</div>
                <div>{{ $order->delivery_address3 }}</div>
                <div>{{ $order->delivery_address4 }}</div>
                <div>{{ $order->delivery_address5 }}</div>
            </div>
        </div>
    </div>

    <div class="flex justify-between mb-3 mt-3">
        <button class="button button-inverse" onclick="window.history.back();">{{ __('Back') }}</button>

        <div>
            <a
                href="{{ route('order-tracking.copy-to-basket', ['order_number' => encodeUrl(trim($order->order_no))]) }}">
                <button class="button button-primary">{{ __('Copy Order To Basket') }}</button>
            </a>

            <order-invoice order="{{ urlencode(trim($order->order_no)) }}"
                           customer_order="{{ urlencode(trim($order->customer_order_no)) }}"></order-invoice>

            <a href="{{ route('order-tracking.pdf', ['order' => encodeUrl($order->order_no)]) }}">
                <button class="button button-primary">{{ __('Print Order Details') }}</button>
            </a>
        </div>
    </div>

    <h2 class="font-semibold tracking-widest mt-3 mb-3">{{ __('Order Lines') }}</h2>

    <div class="table-container">
        <table>
            <thead>
            <tr>
                <th>{{ __('Product Code') }}</th>
                <th>{{ __('Name') }}</th>
                <th class="text-right">{{ __('Quantity') }}</th>
                <th class="text-right">{{ __('Net Price') }}</th>
                <th class="text-right">{{ __('Total Price') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->lines as $line)
                <tr class="{{ $line->price ?: 'bg-red-200' }}">
                    <td>{{ $line->product }}</td>
                    <td>{{ $line->long_description }}</td>
                    <td class="text-right">{{ $line->line_qty }}</td>
                    <td class="text-right">{{ currency($line->net_price) }}</td>
                    <td class="text-right">{{ currency($line->line_val) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="text-right mt-1">
        <small class="text-red-600">* Products marked in red are no longer available for purchase.</small>
    </div>

    @if(count($lines) === 0)
        <h3 class="text-center text-lg font-semibold">No order lines to display.</h3>
    @endif
@endsection

{{--@section('scripts')--}}
{{--    <script>--}}
{{--        $.get('/order-tracking/invoice/{{ urlencode(trim($order->order_no)) }}/{{ urlencode(trim($order->customer_order_no)) }}/').done(function (response) {--}}
{{--            if (response.pdf_exists) {--}}
{{--                $('#invoice-download')--}}
{{--                    .attr('href', '/order-tracking/invoice/{{ urlencode(trim($order->order_no)) }}/{{ urlencode(trim($order->customer_order_no)) }}/true')--}}
{{--                    .removeClass('d-none');--}}
{{--            }--}}
{{--        }).fail(function (response) {--}}
{{--            return console.log(response);--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection--}}
