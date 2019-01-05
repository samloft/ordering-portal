@extends('layout.master')

@section('page.title', 'Products')

@section('content')
    <div class="row">
        @include('products.sidebar')

        <div class="col">
            @include('products.breadcrumbs')

            @if (count($products) > 0)
                @foreach($products as $product)
                    <div class="card card-body product-list mb-2">
                        <div class="row">
                            <div class="col">
                                <h2 class="section-title">
                                    <a href="{{ route('products.show', $product->product) }}">{{ $product->name }}</a>
                                </h2>

                                <div class="row product-details">
                                    <div class="col-sm-auto">
                                        <img src="https://scolmoreonline.com/product_images/DPBN024BK.png">
                                    </div>
                                    <div class="col-lg pt-2 pl-0">
                                        <h5>Product Code: <span class="primary-font">{{ $product->product }}</span></h5>
                                        <h5>Unit Type: <span class="primary-font">{{ $product->uom }}</span></h5>
                                        <h5>{{ $product->description }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 text-right product-pricing">
                                <div class="row">
                                    <div class="col text-left">
                                        Trade Price:
                                    </div>
                                    <div class="col text-right">
                                        £{{ number_format($product->trade_price, 4) }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col text-left">
                                        Unit Price:
                                    </div>
                                    <div class="col text-right">
                                        £{{ number_format($product->prices->price, 4) }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col text-left">
                                        Discount:
                                    </div>
                                    <div class="col text-right">
                                        2%
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col text-left">
                                        <strong>Net Price:</strong>
                                    </div>
                                    <div class="col text-right">
                                        <strong>£{{ number_format(($product->prices->price * ((100-2) / 100)), 4) }}</strong>
                                    </div>
                                </div>
                                <hr>
                                <div class="input-group input-group-sm product-basket">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Qty:</span>
                                    </div>
                                    <input class="form-control form-control-sm mr-1" value="1">
                                    <span class="input-group-btn">
                                <button class="btn btn-sm btn-primary" type="button">Add To Basket</button>
                            </span>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <button class="btn btn-sm btn-blue">Enlarge Image</button>
                                <button class="btn btn-sm btn-blue">View Details & Availability</button>
                            </div>
                            <div class="col-lg-3 text-right">
                                <div class="input-group input-group-sm stock-levels">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Stock Level</span>
                                    </div>
                                    <input class="form-control form-control-sm" value="1" readonly>
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
            @else
                Categories
            @endif
        </div>

    </div>
@endsection
