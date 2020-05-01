@extends('layout.master')

@section('page.title', 'Thank you for your order')

@section('content')
    <div class="w-full mb-5 text-center">
        <h2 class="font-semibold tracking-widest">Order Completed</h2>
        <p class="font-thin">
            Thank you for your order.
        </p>
    </div>

    <div class="bg-white rounded-lg shadow p-4 text-center">
        <h3 class="text-primary text-2xl font-semibold mb-10">Your order number is <span
                class="font-bold underline">{{ $order_number }}</span></h3>

        <p class="mb-10">Your order confirmation has been emailed to your account email address.</p>

        <a href="{{ route('products') }}">
            <button class="button button-primary w-40">Continue Shopping</button>
        </a>

        <a href="{{ route('checkout.confirmation', ['order_number' => $order_number]) }}" target="_blank">
            <button class="button button-secondary w-40">Print Order Confirmation</button>
        </a>
    </div>
@endsection

@section('scripts')
    @if($google_analytics && config('app.debug') === false)
        <script>
            window.dataLayer = window.dataLayer || [];
            dataLayer.push({
                'transactionId': '{{ $order_number }}',
                'transactionAffiliation': '{{ $header['customer_code'] }}',
                'transactionTotal': {{ $header['goods_total'] }},
                'transactionTax': {{ $header['vat'] }},
                'transactionShipping': {{ $header['delivery_cost'] }},
                @foreach($lines as $line)
                'transactionProducts': [{
                    'sku': '{{ $line['product'] }}',
                    'name': '{{ $line['description'] }}',
                    'price': {{ $line['net_price'] }},
                    'quantity': {{ $line['quantity'] }}
                },
                @endforeach
            });
        </script>
    @endif
@endsection
