@extends('layout.master')

@section('page.title', 'View Product')

@section('content')
    <div class="row">
        @include('products.sidebar')

        <div class="col">
            @if ($product)
                @include('products.breadcrumbs')

                <div class="card card-body">
                    <div class="row">
                        <div class="col">
                            <h2 class="section-title">
                                <a href="{{ route('products.show', $product->product) }}">{{ $product->name }}</a>
                            </h2>

                            <div class="row product-details">
                                <div class="col-sm-auto">
                                    <div class="product-list-image">
                                        <img id="enlarge-image"
                                             {{--src="https://scolmoreonline.com/product_images/DPBN024BK.png">--}}
                                             src="{{ @getimagesize('https://scolmoreonline.com/product_images/' . $product->product . '.png') ? 'https://scolmoreonline.com/product_images/' . $product->product . '.png' : 'https://scolmoreonline.com/assets/images/no-image.png' }}">
                                    </div>
                                </div>
                                <div class="col-lg pt-2 pl-0">
                                    <h5>Product Code: <span id="product-code"
                                                            class="primary-font">{{ $product->product }}</span></h5>
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
                            <form id="product-add-basket-products" class="m-0" method="post">
                                <div class="input-group input-group-sm product-basket">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Qty:</span>
                                    </div>
                                    <input class="form-control form-control-sm mr-1" name="quantity"
                                           value="{{ $product->order_multiples }}" autocomplete="off">
                                    <span class="input-group-btn">
                                            <input name="product" value="{{ $product->product }}" autocomplete="off"
                                                   hidden>
                                <button class="btn btn-sm btn-primary" type="submit">Add To Basket</button>
                            </span>
                                </div>
                            </form>

                            <div class="input-group input-group-sm stock-levels mt-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Stock Level</span>
                                </div>
                                <input class="form-control form-control-sm"
                                       value="{{ $product->stock->quantity ? $product->stock->quantity : 0 }}"
                                       readonly>
                                <span class="input-group-btn">
                            </span>
                            </div>
                        </div>
                        {{--<div class="row mt-2">--}}
                        {{--<div class="col-lg-3 text-right">--}}
                        {{--<div class="input-group input-group-sm stock-levels">--}}
                        {{--<div class="input-group-prepend">--}}
                        {{--<span class="input-group-text">Stock Level</span>--}}
                        {{--</div>--}}
                        {{--<input class="form-control form-control-sm"--}}
                        {{--value="{{ $product->stock->quantity ? $product->stock->quantity : 0 }}"--}}
                        {{--readonly>--}}
                        {{--<span class="input-group-btn">--}}
                        {{--</span>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                    </div>
                </div>
                @if ($expected_stock)
                    <div class="card card-body mt-3">
                        <h5 class="mb-3">Expected Stock</h5>
                        <table class="table table-expected">
                            <thead>
                            <tr>
                                <th class="text-center">Expected Date</th>
                                <th class="text-center">Expected Quantity</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($expected_stock as $stock)
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
                <div class="card card-body no-product">
                    Oops, no product :(
                </div>
            @endif

            <div class="text-right mt-2">
                <button class="btn btn-blue" onclick="window.history.back();">Return to products</button>
            </div>
        </div>
    </div>
@endsection