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
        <div class="w-8/12">
            <basket-table :products="{{ json_encode($basket['lines'], true) }}"></basket-table>
            {{--            <table class="mb-3">--}}
            {{--                <thead>--}}
            {{--                <tr>--}}
            {{--                    <th>{{ __('Product') }}</th>--}}
            {{--                    <th>{{ __('Unit') }}</th>--}}
            {{--                    <th class="text-right">{{ __('Net Price') }}</th>--}}
            {{--                    <th class="text-center">{{ __('Quantity') }}</th>--}}
            {{--                    <th class="text-right">{{ __('Total Price') }}</th>--}}
            {{--                </tr>--}}
            {{--                </thead>--}}
            {{--                <tbody class="row-sm">--}}
            {{--                @foreach($basket['lines'] as $line)--}}
            {{--                    <tr {{ ($line['stock'] < $line['quantity']) ? 'class=bg-red-200' : ''}} id="{{ $line['product'] }}">--}}
            {{--                        <td>--}}
            {{--                            <div class="flex items-center">--}}
            {{--                                <img class="h-10 mr-2" src="{{ $line['image'] }}" alt="{{ $line['name'] }}">--}}
            {{--                                <h2 class="leading-none">--}}
            {{--                                    <a href="{{ route('products.show', ['product' => $line['product']]) }}"><span--}}
            {{--                                            class="text-primary font-medium">{{ $line['product'] }}</span>--}}
            {{--                                        <br><span class="text-xs">{{ $line['name'] }}</span></a>--}}
            {{--                                </h2>--}}
            {{--                            </div>--}}
            {{--                        </td>--}}
            {{--                        <td><span class="badge badge-info">{{ ucfirst(strtolower($line['uom'])) }}</span></td>--}}
            {{--                        <td class="text-right">{{ $line['unit_price'] }}</td>--}}
            {{--                        <td class="text-center">--}}
            {{--                            <input name="line_qty" class="w-20 h-6 text-right" value="{{ $line['quantity'] }}"--}}
            {{--                                   autocomplete="off">--}}
            {{--                            <div class="leading-none text-primary">--}}
            {{--                                <small id="basket_line__update" class="quantity-update">Update</small> <small--}}
            {{--                                    id="basket-line__remove" class="quantity-remove">Remove</small>--}}
            {{--                            </div>--}}
            {{--                        </td>--}}
            {{--                        <td class="text-right">{{ $line['price'] }}</td>--}}
            {{--                    </tr>--}}
            {{--                @endforeach--}}
            {{--                </tbody>--}}
            {{--            </table>--}}

            {{--            <div class="flex justify-between">--}}
            {{--                <div>--}}
            {{--                    <a href="{{ route('products') }}">--}}
            {{--                        <button class="button button-inverse">{{ __('Continue Shopping') }}</button>--}}
            {{--                    </a>--}}
            {{--                    <button id="empty-basket" class="button button-inverse">{{ __('Empty basket') }}</button>--}}
            {{--                </div>--}}

            {{--                <button id="save-basket" class="button button-primary">{{ __('Save Basket') }}</button>--}}
            {{--            </div>--}}
        </div>

        <div class="w-4/12 ml-10">
            <div class="bg-white rounded shadow-md p-6 text-center mb-5">
                <label class="font-medium">{{ __('Quick Buy') }}</label>
                <quick-buy></quick-buy>
            </div>

            <div class="bg-white rounded shadow-md p-6 mb-5">
                <basket-summary :summary="{{ json_encode($basket['summary'], true) }}"></basket-summary>

                <div class="mt-3 text-xs">
                    {{ __('*orders below £200 attract a £10 small order charge, unless you are collecting your order or paying a delivery charge.') }}
                </div>

                <a href="{{ route('checkout') }}">
                    <button class="flex justify-between button button-primary button-block mt-6 text-left">
                        {{ __('Checkout') }}
                        <span class="ml-auto">🛒</span>
                    </button>
                </a>
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
    {{--    <script>--}}
    {{--        $('#empty-basket').on('click', function () {--}}
    {{--            Swal.fire({--}}
    {{--                title: "Empty Basket?",--}}
    {{--                text: "Are you sure? This cannot be un-done.",--}}
    {{--                icon: "warning",--}}
    {{--                buttons: true,--}}
    {{--                showCancelButton: true,--}}
    {{--                dangerMode: true,--}}
    {{--            })--}}
    {{--                .then((willDelete) => {--}}
    {{--                    if (willDelete) {--}}
    {{--                        location.href = '{{ route('basket.empty') }}';--}}
    {{--                    }--}}
    {{--                });--}}
    {{--        });--}}

    {{--        $('#save-basket').on('click', async function () {--}}
    {{--            const {value: reference} = await Swal.fire({--}}
    {{--                title: 'Add a reference for your saved basket',--}}
    {{--                input: 'text',--}}
    {{--                showCancelButton: true,--}}
    {{--                inputValidator: (value) => {--}}
    {{--                    if (!value) {--}}
    {{--                        return 'You need to enter a reference.'--}}
    {{--                    }--}}
    {{--                }--}}
    {{--            });--}}

    {{--            if (reference) {--}}
    {{--                $.post('/saved-baskets/store', {--}}
    {{--                    reference: reference--}}
    {{--                }).done(function (response) {--}}
    {{--                    return Swal.fire('Success', 'Your basket has been saved.', 'success');--}}
    {{--                }).fail(function (response) {--}}
    {{--                    return Swal.fire('Error', 'Unable to save this basket, please try again.', 'error');--}}
    {{--                });--}}
    {{--            }--}}
    {{--        });--}}
    {{--    </script>--}}
@endsection
