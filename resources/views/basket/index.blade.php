@extends('layout.master')

@section('page.title', 'Basket')

@section('content')
    <div class="w-full mb-5 text-center">
        <h2 class="font-semibold tracking-widest">{{ __('Basket') }}</h2>
        <p class="font-thin">
            {{ __('View your basket.') }}
        </p>
    </div>

    @include('layout.alerts')

    <div class="flex items-start justify-end mb-5">
        <table class="w-8/12">
            <thead>
            <tr>
                <th>{{ __('Product') }}</th>
                <th>{{ __('Unit') }}</th>
                <th class="text-right">{{ __('Net Price') }}</th>
                <th class="text-center">{{ __('Quantity') }}</th>
                <th class="text-right">{{ __('Total Price') }}</th>
            </tr>
            </thead>
            <tbody class="row-sm">
            @foreach($basket['lines'] as $line)
                <tr {{ ($line['stock'] < $line['quantity']) ? 'class=bg-red-200' : ''}} id="{{ $line['product'] }}">
                    <td>
                        <div class="flex items-center">
                            <img class="h-10 mr-2" src="{{ $line['image'] }}" alt="{{ $line['name'] }}">
                            <h2 class="leading-none">
                                <a href="{{ route('products.show', ['product' => $line['product']]) }}"><span class="text-primary font-medium">{{ $line['product'] }}</span>
                                    <br><span class="text-xs">{{ $line['name'] }}</span></a>
                            </h2>
                        </div>
                    </td>
                    <td><span class="badge badge-info">{{ ucfirst(strtolower($line['uom'])) }}</span></td>
                    <td class="text-right">{{ $line['unit_price'] }}</td>
                    <td class="text-center">
                        <input name="line_qty" class="w-20 h-6 text-right" value="{{ $line['quantity'] }}"
                               autocomplete="off">
                        <div class="leading-none text-primary">
                            <small id="basket_line__update" class="quantity-update">Update</small> <small
                                id="basket-line__remove" class="quantity-remove">Remove</small>
                        </div>
                    </td>
                    <td class="text-right">{{ $line['price'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="w-4/12 ml-10">
            <div class="bg-white rounded shadow-md p-2 text-center mb-5">
                <form id="product-add-basket-checkout" class="m-0" method="post">
                    <label class="font-medium">{{ __('Quick Buy') }}</label>
                    <div class="flex justify-center">
                        <input id="quick-buy" class="w-48 mr-1" name="product"
                               placeholder="Enter Product Code" autocomplete="off">
                        <input type="text" class="w-12 mr-1" name="quantity" value="1">
                        <button class="button button-primary">{{ __('Add To Basket') }}</button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded shadow-md p-6 mb-5">
                <div class="flex justify-between">
                    <div>{{ __('Goods Total') }}</div>
                    <div id="basket__goods-total" class="text-right">{{ $basket['summary']['goods_total'] }}</div>
                </div>
                <div class="flex justify-between">
                    <div>{{ __('Shipping') }}</div>
                    <div id="basket__shipping" class="text-right">{{ $basket['summary']['shipping'] }}</div>
                </div>
                <div class="flex justify-between">
                    <div>{{ __('Sub Total') }}</div>
                    <div id="basket__sub-total" class="text-right">{{ $basket['summary']['sub_total'] }}</div>
                </div>
                <div class="flex justify-between">
                    <div>{{ __('Small Order Charge*') }}</div>
                    <div id="basket__small-order-charge"
                         class="text-right">{{ $basket['summary']['small_order_charge'] }}</div>
                </div>
                <div class="flex justify-between">
                    <div>{{ __('VAT') }}</div>
                    <div id="basket__vat" class="text-right">{{ $basket['summary']['vat'] }}</div>
                </div>
                <hr>
                <div class="flex justify-between">
                    <div>{{ __('Order Total') }}</div>
                    <div id="basket__total" class="text-right">{{ $basket['summary']['total'] }}</div>
                </div>
                <hr>
                <div class="mt-3 text-xs">
                    {{ __('*orders below £200 attract a £10 small order charge, unless you are collecting your order or paying a delivery charge.') }}
                </div>
            </div>

            <div class="alert alert-info" role="alert">
                <div class="alert-body text-sm leading-none">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="alert-icon">
                        <path class="primary" d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20z"></path>
                        <path class="secondary"
                              d="M11 12a1 1 0 0 1 0-2h2a1 1 0 0 1 .96 1.27L12.33 17H13a1 1 0 0 1 0 2h-2a1 1 0 0 1-.96-1.27L11.67 12H11zm2-4a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"></path>
                    </svg>
                    <div>
                        <p class="alert-title">{{ __('Please Note:') }}</p>
                        <p class="alert-text">{{ __('Lines marked in red have a chance of going onto backorder.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#empty-basket').on('click', function () {
            Swal.fire({
                title: "Empty Basket?",
                text: "Are you sure? This cannot be un-done.",
                icon: "warning",
                buttons: true,
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        location.href = '{{ route('basket.empty') }}';
                    }
                });
        });

        $('#save-basket').on('click', async function () {
            const {value: reference} = await Swal.fire({
                title: 'Add a reference for your saved basket',
                input: 'text',
                showCancelButton: true,
                inputValidator: (value) => {
                    if (!value) {
                        return 'You need to enter a reference.'
                    }
                }
            });

            if (reference) {
                $.post('/saved-baskets/store', {
                    reference: reference
                }).done(function (response) {
                    return Swal.fire('Success', 'Your basket has been saved.', 'success');
                }).fail(function (response) {
                    return Swal.fire('Error', 'Unable to save this basket, please try again.', 'error');
                });
            }
        });
    </script>
@endsection
