@extends('products.master')

@section('page.title', 'Products')

@section('product.content')
    @if (!$sub_category_list && count($products) === 0)
        <div class="w-full rounded bg-white p-5 shadow mb-5 text-center">
            <h2 class="font-semibold tracking-widest">No products found</h2>
            <p class="font-thin">
                No products exist in this category
            </p>
        </div>
    @else
        @if ($sub_category_list)
            <div class="flex flex-wrap -mx-3">
                @foreach($sub_category_list['list'] as $category)
                    <product-categories :category="{{ json_encode($category, true) }}"
                                        :current="{{ json_encode($sub_category_list['current'], true) }}"
                                        company="{{ config('app.name') }}"
                                        s3="{{ config('app.s3_url') }}"></product-categories>
                @endforeach
            </div>
        @endif

        @if ($products)
            @foreach($products as $product)
                <div class="w-full rounded bg-white p-5 shadow mb-5 text-sm">
                    <div class="flex mb-2">
                        <div class="w-3/4">
                            <h2 class="font-semibold text-lg text-primary mb-2">
                                <a class="flex items-center" href="{{ $product->path() }}"
                                   class="hover:underline">{{ $product->name }} @if($product->not_sold) <span
                                        class="badge badge-danger ml-3">Not Sold</span> @endif</a>
                            </h2>

                            <div class="flex items-center">
                                <expandable-image class="w-32"
                                                  alt="{{ $product->code }}"
                                                  src="{{ $product->image() }}">
                                </expandable-image>

                                <div class="pl-3 pr-10">
                                    <h5>
                                        Product Code:
                                        <span id="product-code"
                                              class="font-semibold text-primary">{{ $product->code }}</span>
                                    </h5>
                                    <h5>
                                        Unit Type:
                                        <span class="font-semibold text-primary">{{ $product->uom }}</span>
                                    </h5>

                                    <h5 class="mt-1">{{ $product->description }}</h5>
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
                                        Trade Price:
                                    </div>
                                    <div class="col text-right">
                                        {{ currency($product->trade_price, 4) }}
                                    </div>
                                </div>
                                <div class="flex justify-between">
                                    <div class="col text-left">
                                        Unit Price:
                                    </div>
                                    <div class="col text-right">
                                        {{ currency($product->prices->price, 4) }}
                                    </div>
                                </div>
                                @if((int) discountPercent() > 0)
                                    <div class="flex justify-between">
                                        <div class="col text-left">
                                            Discount:
                                        </div>
                                        <div class="col text-right">
                                            {{ discountPercent() }}
                                        </div>
                                    </div>
                                @endif
                                <hr>
                                <div class="flex justify-between mt-1 mb-1">
                                    <div class="col text-left">
                                        <strong>Net Price:</strong>
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
                    <div class="flex justify-between items-center">
                        <a href="{{ route('products.show', $product->code) }}">
                            <button class="button button-inverse">
                                View Details & Availability
                            </button>
                        </a>
                        <div class="block">
                            <div class="text-xxs bg-gray-600 text-white pl-1 pr-1 rounded-t">
                                Stock Level
                            </div>
                            <div class="text-center bg-gray-200 p-1 text-xs rounded-b">
                                {{ $product->stock }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="mb-2">
                {{ $products->appends($_GET)->links('layout.pagination') }}
            </div>
        @endif
    @endif
@endsection
