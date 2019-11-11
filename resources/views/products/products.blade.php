@extends('layout.master')

@section('page.title', 'Product')

@section('content')
    <div class="flex">
        @include('products.sidebar')

        <div class="w-3/4">
            @include('products.breadcrumbs')

            @if (!isset($sub_category_list) && count($products) === 0)
                <div class="card card-body text-center">
                    <h4>{{ __('No products found.') }}</h4>
                </div>
            @else
                @if (isset($sub_category_list))
                    <div class="flex flex-wrap -mx-3">
                        @foreach($sub_category_list as $key => $category)
                            <div class="w-1/5 px-3">
                                <a href="/products/{{ ($categories['level_1'] <> '' ? $categories['level_1'] . '/' : '') . ($categories['level_2'] <> '' ? $categories['level_2'] . '/' : '') . $sub_category_list[$key]['slug'] }}">
                                    <div
                                        class="bg-white relative text-center rounded-lg mb-6 shadow-md hover:shadow-lg">
                                        <div class="h-40">
                                            <img
                                                class="h-32 mx-auto"
                                                src="{{ isset($sub_category_list[$key]['image']) ? asset('product_images/' . $sub_category_list[$key]['image']) : 'https://scolmoreonline.com/assets/images/no-image.png' }}"
                                                alt="{{ $key }}">
                                        </div>
                                        {{--                                        @if (isset($sub_category_list[$key]['category_image']))--}}
                                        {{--                                            <div class="sub-category-image">--}}
                                        {{--                                                <img--}}
                                        {{--                                                    src="{{ isset($sub_category_list[$key]['image']) ? asset('product_images/' . $sub_category_list[$key]['image']) : 'https://scolmoreonline.com/assets/images/no-image.png' }}"--}}
                                        {{--                                                    alt="{{ $key }}">--}}
                                        {{--                                            </div>--}}
                                        {{--                                        @else--}}
                                        {{--                                            <div class="sub-category-image"--}}
                                        {{--                                                 data-products=@json($sub_category_list[$key]['product_list'])>--}}
                                        {{--                                                <div class="spinner">--}}
                                        {{--                                                    <div class="bounce1"></div>--}}
                                        {{--                                                    <div class="bounce2"></div>--}}
                                        {{--                                                    <div class="bounce3"></div>--}}
                                        {{--                                                </div>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        @endif--}}
                                        <div class="absolute inset-x-0 bottom-0 bg-gray-200 rounded-b-lg py-2 text-sm">
                                            <span>{{ $key }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if (count($products) > 0)
                    @foreach($products as $product)
                        <div class="w-full rounded bg-white p-5 shadow mb-5 text-sm">
                            <div class="flex mb-2">
                                <div class="w-3/4">
                                    <h2 class="font-semibold text-lg text-primary mb-2">
                                        <a href="/products/view/{{ encodeUrl($product->code) }}">{{ $product->name }}</a>
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
        </div>

    </div>
@endsection
