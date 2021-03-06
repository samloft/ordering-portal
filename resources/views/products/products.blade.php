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
            <div class="flex flex-wrap">
                @foreach($sub_category_list['list'] as $category)
                    <product-categories :category="{{ json_encode($category, JSON_THROW_ON_ERROR | true) }}"
                                        :current="{{ json_encode($sub_category_list['current'], JSON_THROW_ON_ERROR | true) }}"
                                        company="{{ config('app.name') }}"
                                        s3="{{ config('app.s3_url') }}"></product-categories>
                @endforeach
            </div>
        @endif

        @if ($products)
            @foreach($products as $product)
                <div class="w-full rounded bg-white p-5 shadow mb-5 text-xs md:text-sm">
                    <h2 class="md:hidden font-semibold text-primary mb-2">
                        <a class="flex items-center" href="{{ $product->path() }}"
                           class="hover:underline">{{ $product->name }} @if($product->not_sold) <span
                                class="badge badge-danger ml-3">Not Sold</span> @endif</a>
                    </h2>

                    <div class="md:flex md:mb-2">
                        <div class="md:w-3/4">
                            <h2 class="hidden md:block font-semibold text-lg text-primary mb-2">
                                <a class="flex items-center" href="{{ $product->path() }}"
                                   class="hover:underline">{{ $product->name }} @if($product->not_sold) <span
                                        class="badge badge-danger ml-3">Not Sold</span> @endif</a>
                            </h2>

                            <div class="flex items-center">
                                <expandable-image class="flex items-center w-16 h-16 md:h-32 md:w-32"
                                                  alt="{{ $product->code }}"
                                                  src="{{ $product->image() }}">
                                </expandable-image>

                                <div class="pl-3 text-xs md:text-sm md:pr-10">
                                    <h5>
                                        <span class="hidden md:inline-block">Product</span> Code:
                                        <span id="product-code"
                                              class="font-semibold text-primary">{{ $product->code }}</span>
                                    </h5>
                                    <h5>
                                        Unit Type:
                                        <span class="font-semibold text-primary">{{ $product->uom }}</span>
                                    </h5>

                                    <h5 class="mt-1">{{ $product->description }}</h5>

                                    @if($product->stock === 0 && count($product->expectedStock) > 0)
                                        <div class="md:hidden flex justify-end items-center mt-2">
                                            <div class="text-xs bg-gray-600 text-white pl-1 pr-1 rounded-l">
                                                Out of stock
                                            </div>
                                            <div class="text-center bg-gray-200 px-1 rounded-r">
                                                Next
                                                Due {{ \Carbon\Carbon::parse($product->expectedStock->first()->due_date)->format('d-m-Y') }}
                                            </div>
                                        </div>
                                    @else
                                        <div class="md:hidden flex justify-end items-center mt-2">
                                            <div class="text-xs bg-gray-600 text-white pl-1 pr-1 rounded-l">
                                                Stock Level
                                            </div>
                                            <div class="text-center bg-gray-200 px-1 rounded-r">
                                                {{ $product->stock }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="md:w-1/4 mb-3 md:mb-0">
                            @if(!$product->not_sold)
                                @if ($product->prices->break1 > 0 || $product->prices->break2 > 0 || $product->prices->break3 > 0)
                                    <div class="hidden md:block">
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
                                    </div>
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

                                <div class="flex justify-between items-center mt-3 md:mt-0">
                                    <a href="{{ route('products.show', $product->code) }}" class="md:hidden">
                                        <button class="button button-inverse">
                                            View
                                        </button>
                                    </a>

                                    <add-basket :product="{{ json_encode($product, true) }}"></add-basket>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="hidden md:flex justify-between items-center">
                        <a href="{{ route('products.show', $product->code) }}">
                            <button class="button button-inverse">
                                View Details & Availability
                            </button>
                        </a>

                        @if($product->stock === 0 && count($product->expectedStock) > 0)
                            <div class="block">
                                <div class="text-center text-xs bg-gray-600 text-white pl-1 pr-1 rounded-t">
                                    Out of stock
                                </div>
                                <div class="text-center bg-gray-200 p-1 text-xs rounded-b">
                                    Next
                                    Due {{ \Carbon\Carbon::parse($product->expectedStock->first()->due_date)->format('d-m-Y') }}
                                </div>
                            </div>
                        @else
                            <div class="block">
                                <div class="text-xs bg-gray-600 text-white pl-1 pr-1 rounded-t">
                                    Stock Level
                                </div>
                                <div class="text-center bg-gray-200 p-1 text-xs rounded-b">
                                    {{ $product->stock }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach

            <div class="mb-2">
                {{ $products->appends($_GET)->links('layout.pagination') }}
            </div>
        @endif
    @endif
@endsection
