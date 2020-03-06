@extends('products.master')

@section('page.title', 'View Product')

@section('product.content')
    @if ($product)

        <div class="w-full rounded bg-white p-5 shadow mb-5 text-sm">
            <div class="flex mb-2">
                <div class="w-3/4">
                    <h2 class="font-semibold text-2xl text-primary mb-2">
                        {{ $product->name }} @if($product->not_sold) <span
                            class="badge badge-danger ml-3">Not Sold</span> @endif
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
                    @if(!$product->not_sold)
                        @if ($product->prices->break1 > 0 || $product->prices->break2 > 0 || $product->prices->break3 > 0)
                            <h5 class="text-gray-600 text-center uppercase tracking-widest">Bulk Rates</h5>

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
                                {{ currency($product->prices->price, 4) }}
                            </div>
                        </div>

                        @if((int) discountPercent() > 0)
                            <div class="flex justify-between">
                                <div class="col text-left">
                                    {{ __('Discount:') }}
                                </div>
                                <div class="col text-right">
                                    {{ discountPercent() }}
                                </div>
                            </div>
                        @endif

                        <hr>
                        <div class="flex justify-between mt-1 mb-1">
                            <div class="col text-left">
                                <strong>{{ __('Net Price:') }}</strong>
                            </div>
                            <div class="col text-right">
                                <strong>{{ currency(discount($product->prices->price), 4) }}</strong>
                            </div>
                        </div>
                        <hr>
                        <add-basket :product="{{ json_encode($product, true) }}"></add-basket>
                    @endif
                </div>
            </div>
            <div class="flex justify-end">
                <div class="block">
                    <div class="text-xxs bg-gray-600 text-white pl-1 pr-1 rounded-t">
                        {{ __('Stock Level') }}
                    </div>
                    <div class="text-center bg-gray-200 p-1 text-xs rounded-b">
                        {{ $product->stock }}
                    </div>
                </div>
            </div>

            @if(trim($product->note) !== '')
                @if($product->note === 'Superseeded')
                    <h3 class="text-red-600 tracking-wide font-semibold text-lg">
                        Superseeded {!! $product->link1 ? 'by <a class="hover:underline" href="'.route('products.show', ['product' => trim($product->link1)]).'">'.trim($product->link1).'</a>' : '' !!}</h3>
                @else
                    <div class="bg-gray-200 mt-3 rounded p-6">
                        <h5 class="font-semibold mb-3">Notes:</h5>

                        <p>{{ $product->note }}</p>
                    </div>
                @endif
            @endif

            @if ($product->luckins_code)
                <div class="flex items-center">
                    <img class="w-24 mt-1 mr-3" src="{{ asset('images/luckins.png') }}"
                         alt="Luckins">
                    <div class="rounded border border-primary pl-1 pr-1">
                        {{ $product->luckins_code }}
                    </div>
                </div>
            @endif

            <div class="mt-5">
                @if($product->length)
                    <div class="flex border-b border-primary mb-3">
                        <div class="w-1/3 text-gray-400">Length (mm):</div>
                        <div>{{ $product->length }}</div>
                    </div>
                @endif
                @if($product->width)
                    <div class="flex border-b border-primary mb-3">
                        <div class="w-1/3 text-gray-400">Width (mm):</div>
                        <div>{{ $product->width }}</div>
                    </div>
                @endif
                @if($product->height)
                    <div class="flex border-b border-primary mb-3">
                        <div class="w-1/3 text-gray-400">Height (mm):</div>
                        <div>{{ $product->height }}</div>
                    </div>
                @endif
                @if($product->net_weight)
                    <div class="flex border-b border-primary mb-3">
                        <div class="w-1/3 text-gray-400">Weight (kg):</div>
                        <div>{{ $product->net_weight }}</div>
                    </div>
                @endif
            </div>
        </div>

        @if (count($product->expectedStock) > 0)
            <h5 class="mb-3 font-semibold">Expected Stock</h5>

            <div class="table-container">
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
            </div>
        @endif
    @else
        <div class="w-full rounded bg-white p-5 shadow mb-5 text-center">
            <h2 class="font-semibold tracking-widest">{{ __('Product not found') }}</h2>
            <p class="font-thin">
                {{ __('No product was found for this code') }}
            </p>
        </div>
    @endif

    <div class="text-right mt-4">
        <button class="button button-inverse" onclick="window.history.back();">Return to products</button>
    </div>
@endsection
