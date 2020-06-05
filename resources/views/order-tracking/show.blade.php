@extends('layout.master')

@section('page.title', 'Review Order')

@section('content')
    <div class="w-full mb-5 text-center">
        <h2 class="font-semibold tracking-widest">Review Order</h2>
        <p class="font-thin">
            Review your order and re-order by copying to basket.
        </p>
    </div>

    <div class="bg-white rounded-lg shadow p-4">

        @include('layout.alerts')

        <div class="md:flex text-left mt-4 items-center">
            <div class="md:w-1/2">
                <div class="flex">
                    <div class="font-semibold">Order Number</div>
                    <div class="pl-2">{{ $order->order_number }}</div>
                </div>

                <div class="flex">
                    <div class="font-semibold">Received</div>
                    <div class="pl-2">{{ \Carbon\Carbon::parse($order->date_received)->format('d-m-Y') }}</div>
                </div>

                <div class="flex">
                    <div class="font-semibold">Your Reference</div>
                    <div class="pl-2">{{ $order->reference }}</div>
                </div>

                <div class="flex">
                    <div class="font-semibold">Delivery Service</div>
                    <div class="pl-2">{{ $order->delivery_method }}</div>
                </div>

                <div class="flex items-center">
                    <div class="font-semibold">Status</div>
                    <div class="pl-2"><span
                            class="badge badge-{{ str_replace(' ', '_', strtolower($order->status)) }}">{{ $order->status }}</span>
                    </div>
                </div>

                <div class="flex mt-4">
                    <div class="font-semibold">Net Value</div>
                    <div class="pl-2">{{ currency($order->value, 2) }}</div>
                </div>

                <div class="flex">
                    <div class="font-semibold">VAT Value</div>
                    <div class="pl-2">{{ currency($order->vat, 2) }}</div>
                </div>

                <div class="flex">
                    <div class="font-semibold">Total Value</div>
                    <div class="pl-2">{{ currency(($order->value + $order->vat), 2) }}</div>
                </div>
            </div>

            <div class="md:w-1/2 mt-3 md:mt-0">
                <div class="text-center bg-gray-200 p-4 rounded">
                    <div>{{ $order->delivery_address1 }}</div>
                    <div>{{ $order->delivery_address2 }}</div>
                    <div>{{ $order->delivery_address3 }}</div>
                    <div>{{ $order->delivery_address4 }}</div>
                    <div>{{ $order->delivery_address5 }}</div>
                </div>

                @if($order->original && $order->original->notes)
                    <div class="mt-3 p-4 border border-gray-300 border-dashed rounded">
                        <h5 class="mb-1 font-medium">Notes:</h5>
                        <p>{{ $order->original->notes }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="md:flex justify-between mb-3 mt-3">
        <div class="flex justify-end md:flex-none mb-3 md:mb-0">
            <button class="button button-inverse" onclick="window.history.back();">Back</button>
        </div>

        <div class="flex">
            @if(count($lines) > 0)
                <a class="mr-2"
                   href="{{ route('order-tracking.copy-to-basket', ['order_number' => encodeUrl(trim($order->order_number))]) }}">
                    <submit-button before-text="Copy Order To Basket"
                                   after-text="Copying Order To Basket"></submit-button>
                </a>
            @endif

            <order-invoice order="{{ urlencode(trim($order->order_number)) }}"
                           customer_order="{{ urlencode(trim($order->reference)) }}"></order-invoice>

            <a class="ml-2" href="{{ route('order-tracking.pdf', ['order' => encodeUrl($order->order_number)]) }}"
               target="_blank">
                <button class="button button-primary">Print Order Details</button>
            </a>
        </div>
    </div>

    <h2 class="font-semibold tracking-widest mt-3 mb-3">Order Lines</h2>

    @if(count($lines) === 0)
        <div class="bg-white rounded-lg shadow p-4">
            <h3 class="text-center text-lg font-semibold">No order lines to display.</h3>
        </div>
    @else
        <div class="table-container">
            <table>
                <thead>
                <tr>
                    <th>
                        <span class="hidden md:block">Product Code</span>
                        <span class="md:hidden">Product</span>
                    </th>
                    <th class="hidden md:block">Name</th>
                    <th class="text-right">Quantity</th>
                    <th class="hidden md:block text-right">Net Price</th>
                    <th class="text-right">Total Price</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->lines as $line)
                    <tr class="{{ $line->price ?: 'bg-red-200' }}">
                        <td>{{ $line->product }}</td>
                        <td class="hidden md:block">{{ $line->description }}</td>
                        <td class="text-right">{{ $line->quantity }}</td>
                        <td class="hidden md:block text-right">{{ currency($line->net_price) }}</td>
                        <td class="text-right">{{ currency($line->total) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-red-600 my-3 text-xs leading-none">
            * Items marked in red are no longer available for purchase and will not be added.
        </div>
    @endif
@endsection
