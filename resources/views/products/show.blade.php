@extends('layout.master')

@section('page.title', 'View Product')

@section('content')
    <div class="flex">
        @include('products.sidebar')

        <div class="w-3/4">
            @if ($product)
                @include('products.breadcrumbs')

                <div class="card card-body">
                    <div class="row">
                        <div class="col">
                            <h2 class="section-title">{{ $product->name }}</h2>

                            <div class="row product-details">
                                <div class="col-sm-auto">
                                    <div class="product-view-image">
                                        <img id="enlarge-image"
                                             src="{{ $product->image() }}">
                                    </div>
                                </div>
                                <div class="col-lg pt-2 pl-0">
                                    <h5>Product Code: <span id="product-code"
                                                            class="primary-font">{{ $product->product }}</span></h5>
                                    <h5>Unit Type: <span class="primary-font">{{ $product->uom }}</span></h5>
                                    <h5>Product Description:</h5>
                                    <h5><span class="primary-font">{{ $product->description }}</span></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 text-right product-pricing">
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
                                <hr>
                            @endif

                            <div class="row">
                                <div class="col text-left">
                                    Trade Price:
                                </div>
                                <div class="col text-right">
                                    {{ currency($product->trade_price, 4) }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-left">
                                    Unit Price:
                                </div>
                                <div class="col text-right">
                                    {{ currency($product->prices->price, 4) }}
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
                                    <strong>{{ currency(($product->prices->price * ((100-2) / 100)), 4) }}</strong>
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
                                       value="{{ $product->stock->quantity ?? 0 }}"
                                       readonly>
                                <span class="input-group-btn">
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
                @if (count($expected_stock) > 0)
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

            <div class="text-right mt-4">
                <button class="button button-primary" onclick="window.history.back();">Return to products</button>
            </div>
        </div>
    </div>
@endsection
