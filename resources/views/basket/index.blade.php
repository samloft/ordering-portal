@extends('layout.master')

@section('page.title', 'Basket')

@section('content')
    <div class="row">
        <div class="col">
            <h1 class="page-title">{{ __('Basket') }}</h1>
        </div>
        <div class="col text-right">
            Tracking Stuffs
        </div>
    </div>

    @include('layout.alerts')

    <div class="row">
        <div class="col-lg-7"></div>
        <div class="col-lg-5 justify-content-end">
            <div class="card card-body quick-buy-basket">
                <form id="product-add-basket-checkout" method="post">
                    <div class="form-group">
                        <label class="font-weight-bold">{{ __('Quick Buy') }}</label>
                        <div class="row">
                            <div class="col">
                                <input id="quick-buy" class="form-control" name="product" placeholder="Enter Product Code" autocomplete="off">
                            </div>
                            <div class="col-2">
                                <input type="text" class="form-control text-center" name="quantity" value="1">
                            </div>
                            <div class="col-4">
                                <button class="btn btn-block btn-primary" type="submit">{{ __('Add To Basket') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <table class="table table-basket">
        <thead>
        <tr>
            <th>{{ __('Product') }}</th>
            <th>{{ __('Code') }}</th>
            <th>{{ __('Unit') }}</th>
            <th class="text-right">{{ __('Stock (†)') }}</th>
            <th class="text-right">{{ __('Net Price') }}</th>
            <th class="text-center">{{ __('Quantity') }}</th>
            <th class="text-right">{{ __('Total Price') }}</th>
        </tr>
        </thead>
        @if (count($basket['lines']) > 0)
            <tbody>
            @foreach($basket['lines'] as $line)
                <tr {{ $line['stock'] < $line['quantity'] ? 'class=bg-warning' : '' }}>
                    <td>
                        <div class="basket-image__container d-inline-block">
                            <img class="basket-image" src="{{ \Storage::disk('public')->exists('product_images/' . $line['image']) ? asset('product_images/' . $line['image']) : asset('images/no-image.png')  }}" alt="{{ $line['name'] }}">
                        </div>
                        <h2 class="section-title d-inline-block">
                            <a href="{{ route('products.show', ['product' => $line['product']]) }}">{{ $line['name'] }}</a>
                        </h2>
                    </td>
                    <td>{{ $line['product'] }}</td>
                    <td>{{ $line['uom'] }}</td>
                    <td class="text-right">{{ $line['stock'] }}</td>
                    <td class="text-right">{{ $line['unit_price'] }}</td>
                    <td class="quantity-column">
                        <input name="line_qty" class="form-control form-quantity" value="{{ $line['quantity'] }}">
                        <span class="quantity-options">
                            <span class="quantity-update">Update</span> <span class="quantity-remove">Remove</span>
                        </span>
                    </td>
                    <td class="text-right">{{ $line['price'] }}</td>
                </tr>
            @endforeach
            </tbody>
        @endif
    </table>

    @if (count($basket['lines']) == 0)
        <div class="text-center mb-5">
            <h2>{{ __('No items are in your basket') }}</h2>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-7">
            <div class="alert alert-warning p-1">
                {{ __('Please Note: Lines marked in this colour have a chance of going onto backorder.') }}
            </div>
        </div>
        <div class="col-lg-5 justify-content-end">
            <div class="card card-body basket-summary">
                <div class="row">
                    <div class="col">{{ __('Goods Total') }}</div>
                    <div class="col text-right">{{ $basket['summary']['goods_total'] }}</div>
                </div>
                <div class="row">
                    <div class="col">{{ __('Shipping') }}</div>
                    <div class="col text-right">{{ $basket['summary']['shipping'] }}</div>
                </div>
                <div class="row">
                    <div class="col">{{ __('Sub Total') }}</div>
                    <div class="col text-right">{{ $basket['summary']['sub_total'] }}</div>
                </div>
                <div class="row">
                    <div class="col">{{ __('Small Order Charge*') }}</div>
                    <div class="col text-right">{{ $basket['summary']['small_order_charge'] }}</div>
                </div>
                <div class="row">
                    <div class="col">{{ __('VAT') }}</div>
                    <div class="col text-right">{{ $basket['summary']['vat'] }}</div>
                </div>
                <hr>
                <div class="row basket-total">
                    <div class="col">{{ __('Order Total') }}</div>
                    <div class="col text-right">{{ $basket['summary']['total'] }}</div>
                </div>
                <hr>
                <div class="small-print">
                    <div class="row">
                        <div class="col">
                            {{ __('*orders below £200 attract a £10 small order charge, unless you are collecting your order.') }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            {{ __('† Stock levels are only accurate at the time the product is first added to the basket.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col">
            <a href="{{ route('products') }}">
                <button class="btn btn-blue">{{ __('Continue Shopping') }}</button>
            </a>
            <button id="empty-basket" class="btn btn-blue">{{ __('Empty basket') }}</button>
        </div>
        <div class="col text-right">
            <button class="btn btn-primary">{{ __('Save Basket') }}</button>
            <a href="{{ route('checkout') }}">
                <button class="btn btn-primary">{{ __('Checkout') }}</button>
            </a>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#empty-basket').on('click', function () {
            swal({
                title: "Empty Basket?",
                text: "Are you sure? This cannot be un-done.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        location.href = '{{ route('basket.empty') }}';
                    }
                });
        });
    </script>
@endsection