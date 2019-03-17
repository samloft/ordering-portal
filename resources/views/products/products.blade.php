@extends('layout.master')

@section('page.title', 'Products')

@section('content')
    <div class="row">
        @include('products.sidebar')

        <div class="col">
            @include('products.breadcrumbs')

            @if (!isset($sub_category_list) && count($products) == 0)
                <div class="card card-body text-center">
                    <h4>{{ __('No products found.') }}</h4>
                </div>
            @else
                @if (isset($sub_category_list))
                    <div class="d-flex flex-wrap product-category-images">
                        @foreach($sub_category_list as $key => $category)
                            <div class="category w-20">
                                <a href="/products/{{ ($categories['level_1'] <> '' ? $categories['level_1'] . '/' : '') . ($categories['level_2'] <> '' ? $categories['level_2'] . '/' : '') . $sub_category_list[$key]['slug'] }}">
                                    @if (isset($sub_category_list[$key]['category_image']))
                                        <div class="sub-category-image">
                                            <img src="{{ isset($sub_category_list[$key]['image']) ? asset('product_images/' . $sub_category_list[$key]['image']) : 'https://scolmoreonline.com/assets/images/no-image.png' }}"
                                                 alt="{{ $key }}">
                                        </div>
                                    @else
                                        <div class="sub-category-image"
                                             data-products=@json($sub_category_list[$key]['product_list'])>
                                            <div class="spinner">
                                                <div class="bounce1"></div>
                                                <div class="bounce2"></div>
                                                <div class="bounce3"></div>
                                            </div>
                                        </div>
                                    @endif
                                    <span class="text-center">{{ $key }}</span>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if (count($products) > 0)
                    @foreach($products as $product)
                        <div class="card card-body product-list mb-2">
                            <div class="row">
                                <div class="col">
                                    <h2 class="section-title">
                                        <a href="/products/view/{{ encodeUrl($product->product) }}">{{ $product->name }}</a>
                                    </h2>

                                    <div class="row product-details">
                                        <div class="col-sm-auto">
                                            <div class="product-list-image">
                                                <img id="enlarge-image" alt="{{ $product->product }}"
                                                     src="{{ \Storage::disk('public')->exists('product_images/' . encodeUrl($product->product) . '.png') ? asset('product_images/' . encodeUrl($product->product) . '.png') : asset('images/no-image.png') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg pt-2 pl-0">
                                            <h5>
                                                {{ __('Product Code: ') }}
                                                <span id="product-code" class="primary-font">{{ $product->product }}</span>
                                            </h5>
                                            <h5>
                                                {{ __('Unit Type: ') }}
                                                <span class="primary-font">{{ $product->uom }}</span>
                                            </h5>

                                            <h5>{{ $product->description }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 text-right product-pricing">
                                    <div class="row">
                                        <div class="col text-left">
                                            {{ __('Trade Price:') }}
                                        </div>
                                        <div class="col text-right">
                                            {{ currency($product->trade_price, 4) }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-left">
                                            {{ __('Unit Price:') }}
                                        </div>
                                        <div class="col text-right">
                                            {{ currency($product->price, 4) }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-left">
                                            {{ __('Discount:') }}
                                        </div>
                                        <div class="col text-right">
                                            {{ __('2%') }}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col text-left">
                                            <strong>{{ __('Net Price:') }}</strong>
                                        </div>
                                        <div class="col text-right">
                                            <strong>{{ currency(($product->price * ((100 - 2) / 100)), 4) }}</strong>
                                        </div>
                                    </div>
                                    <hr>
                                    <form id="product-add-basket-products" class="m-0" method="post">
                                        <div class="input-group input-group-sm product-basket">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">{{ __('Qty:') }}</span>
                                            </div>
                                            <input class="form-control form-control-sm mr-1" name="quantity"
                                                   value="{{ $product->order_multiples }}" autocomplete="off">
                                            <span class="input-group-btn">
                                            <input name="product" value="{{ $product->product }}" autocomplete="off"
                                                   hidden>
                                <button class="btn btn-sm btn-primary" type="submit">{{ __('Add To Basket') }}</button>
                            </span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <a href="{{ route('products.show', $product->product) }}">
                                        <button class="btn btn-sm btn-blue">{{ __('View Details & Availability') }}</button>
                                    </a>
                                </div>
                                <div class="col-lg-3 text-right">
                                    <div class="input-group input-group-sm stock-levels">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{ __('Stock Level') }}</span>
                                        </div>
                                        <input class="form-control form-control-sm"
{{--                                               value="{{ $product->stock->quantity ? $product->stock->quantity : 0 }}"--}}
                                               value="{{ $product->quantity ? $product->quantity : 0 }}"
                                               readonly>
                                        <span class="input-group-btn">
                            </span>
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

    <div id="img-modal" class="img-modal">
        <span class="close">&times;</span>
        <img class="img-modal-content" id="product-image" alt="Image Coming Soon">
        <div id="caption"></div>
    </div>
@endsection
