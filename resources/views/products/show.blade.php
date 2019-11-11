@extends('products.master')

@section('page.title', 'View Product')

@section('product.content')
    @if ($product)

        <div class="w-full rounded bg-white p-5 shadow mb-5 text-sm">
            <div class="flex mb-2">
                <div class="w-3/4">
                    <h2 class="font-semibold text-2xl text-primary mb-2">
                        <a href="/products/view/{{ encodeUrl($product->code) }}">{{ $product->name }}</a>
                    </h2>

                    <div class="flex">
                        <expandable-image class="w-64"
                                          alt="{{ $product->code }}"
                                          src="{{ $product->image() }}">
                        </expandable-image>

                        <div class="pl-3 pr-10 flex-0 text-lg">
                            <h5 class="mb-3">
                                {{ __('Product Code: ') }}
                                <div id="product-code"
                                     class="font-semibold text-primary">{{ $product->code }}</div>
                            </h5>
                            <h5 class="mb-3">
                                {{ __('Unit Type: ') }}
                                <div class="font-semibold text-primary">{{ $product->uom }}</div>
                            </h5>

                            <h5>{{ $product->description }}</h5>
                        </div>
                    </div>
                </div>

                <div class="w-1/4">
                    @if ($product->prices->break1 > 0 || $product->prices->break2 > 0 || $product->prices->break3 > 0)
                        <table class="bulk-rates">
                            <thead>
                            <tr>
                                <th>Qty</th>
                                <th>Discount %</th>
                                <th class="text-right">Net Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            @for ($i = 0; $i < 4; $i++)
                                @php
                                    $break = 'break' . $i; $price = 'price' . $i;
                                @endphp

                                @if ($product->prices->$break > 0)
                                    <tr>
                                        <td>{{ $product->prices->$break }}</td>
                                        <td>{{ bulkDiscount($product->prices->price, $product->prices->$price) }}</td>
                                        <td class="text-right">{{ currency(discount($product->prices->$price), 4) }}</td>
                                    </tr>
                                @endif
                            @endfor
                            </tbody>
                        </table>
                    @endif

                    <div class="flex justify-between">
                        <div class="col text-left">
                            {{ __('Trade Price:') }}
                        </div>
                        <div class="col text-right">
                            {{ currency($product->trade_price, 4) }}
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <div class="col text-left">
                            {{ __('Unit Price:') }}
                        </div>
                        <div class="col text-right">
                            {{ currency($product->price, 4) }}
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <div class="col text-left">
                            {{ __('Discount:') }}
                        </div>
                        <div class="col text-right">
                            {{ __('2%') }}
                        </div>
                    </div>
                    <hr>
                    <div class="flex justify-between mt-1 mb-1">
                        <div class="col text-left">
                            <strong>{{ __('Net Price:') }}</strong>
                        </div>
                        <div class="col text-right">
                            <strong>{{ currency(($product->price * ((100 - 2) / 100)), 4) }}</strong>
                        </div>
                    </div>
                    <hr>
                    <form id="product-add-basket-products" method="post">
                        <div class="flex justify-between items-center mt-3">
                            <span>{{ __('Qty:') }}</span>
                            <input class="w-10 " name="quantity"
                                   value="{{ $product->order_multiples }}" autocomplete="off">
                            <input name="product" value="{{ $product->code }}" autocomplete="off"
                                   hidden>
                            <button class="button button-primary"
                                    type="submit">{{ __('Add To Basket') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="flex justify-end">
                <div class="block">
                    <div class="text-xxs bg-gray-600 text-white pl-1 pr-1 rounded-t">
                        {{ __('Stock Level') }}
                    </div>
                    <div class="text-center bg-gray-200 p-1 text-xs rounded-b">
                        {{ $product->quantity ?: 0 }}
                    </div>
                </div>
            </div>
        </div>

        @if ($product->expectedStock)
            <h5 class="mb-3 font-semibold">Expected Stock</h5>
            <table class="table table-expected">
                <thead>
                <tr>
                    <th class="text-center">Expected Date</th>
                    <th class="text-center">Expected Quantity</th>
                </tr>
                </thead>
                <tbody>
                @foreach($product->expectedStock as $stock)
                    <tr>
                        <td class="text-center">{{ $stock->due_date->format('d-m-Y') }}</td>
                        <td class="text-center">{{ $stock->quantity }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    @else
        <div class="card card-body no-product">
            Oops, no product :(
        </div>
    @endif

    <div class="text-right mt-4">
        <button class="button button-inverse" onclick="window.history.back();">Return to products</button>
    </div>
@endsection
