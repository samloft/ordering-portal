@extends('products.master')

@section('page.title', 'Products')

@section('product.content')
    @if (!$sub_category_list && count($products) === 0)
        <div class="w-full rounded bg-white p-5 shadow mb-5 text-center">
            <h2 class="font-semibold tracking-widest">{{ __('No products found') }}</h2>
            <p class="font-thin">
                {{ __('No products exist in this category') }}
            </p>
        </div>
    @else
        @if ($sub_category_list)
                <product-categories :categories="{{ json_encode($sub_category_list, true) }}"></product-categories>
        @endif

        @if ($products)
            @foreach($products as $product)
                <div class="w-full rounded bg-white p-5 shadow mb-5 text-sm">
                    <div class="flex mb-2">
                        <div class="w-3/4">
                            <h2 class="font-semibold text-lg text-primary mb-2">
                                <a href="/products/view/{{ encodeUrl($product->code) }}" class="hover:underline">{{ $product->name }}</a>
                            </h2>

                            <div class="flex items-center">
                                <expandable-image class="w-32"
                                                  alt="{{ $product->code }}"
                                                  src="{{ $product->image() }}">
                                </expandable-image>

                                <div class="pl-3 pr-10">
                                    <h5>
                                        {{ __('Product Code: ') }}
                                        <span id="product-code"
                                              class="font-semibold text-primary">{{ $product->code }}</span>
                                    </h5>
                                    <h5>
                                        {{ __('Unit Type: ') }}
                                        <span class="font-semibold text-primary">{{ $product->uom }}</span>
                                    </h5>

                                    <h5 class="mt-1">{{ $product->description }}</h5>
                                </div>
                            </div>
                        </div>

                        <div class="w-1/4">
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
                            <add-basket :product="{{ json_encode($product, true) }}"></add-basket>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <a href="{{ route('products.show', $product->code) }}">
                            <button class="button button-inverse">
                                {{ __('View Details & Availability') }}
                            </button>
                        </a>
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
            @endforeach

            <div class="mb-2">
                {{ $products->appends($_GET)->links('layout.pagination') }}
            </div>
        @endif
    @endif
@endsection
