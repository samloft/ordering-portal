@extends('layout.master')

@section('page.title', 'Checkout')

@section('content')
    <div class="w-full mb-5 text-center">
        <h2 class="font-semibold tracking-widest">Checkout</h2>

        <p class="font-thin">Complete your order</p>
    </div>

    <form method="post" action="{{ route('checkout.order') }}">
        <div class="md:flex">
            <div class="md:w-1/2">
                <div class="bg-white rounded shadow-md p-3 xl:p-6 text-center mb-5 lg:mr-2">
                    <h4 class="text-primary">Delivery Address</h4>

                    @if (session('address'))
                        <div class="xl:w-3/4 text-center bg-gray-200 lg:p-4 rounded mx-auto">
                            <div>{{ session('address.company_name') }}</div>
                            <div>{{ session('address.address_line_2') }}</div>
                            <div>{{ session('address.address_line_3') }}</div>
                            <div>{{ session('address.address_line_4') }}</div>
                            <div>{{ session('address.address_line_5') }}</div>
                            <div>{{ session('address.post_code') }}</div>
                        </div>
                    @else
                        <div class="xl:w-3/4 text-center bg-gray-200 lg:p-4 rounded mx-auto">
                            <div>{{ auth()->user()->customer->name }}</div>
                            <div>{{ auth()->user()->customer->address_line_1 }}</div>
                            <div>{{ auth()->user()->customer->address_line_2 }}</div>
                            <div>{{ auth()->user()->customer->city }}</div>
                            <div>{{ auth()->user()->customer->country }}</div>
                            <div>{{ auth()->user()->customer->post_code }}</div>
                        </div>
                    @endif

                    <div class="text-center mt-2 mb-2">
                        <a href="{{ route('account.addresses', ['checkout' => true]) }}">
                            <button type="button" class="button button-primary">
                                Change Delivery Address
                            </button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="md:w-1/2">
                <div class="bg-white rounded shadow-md p-3 xl:p-6 mb-5 lg:ml-2">
                    @include('layout.alerts')

                    <div class="text-right mb-2 text-xs">
                        <span class="text-red-600">*</span> indicates a required field
                    </div>

                    <h4 class="text-primary">Order Details</h4>

                    @if (count($past_pending_orders) > 0)
                        <div class="xl:flex items-center mb-3 relative">
                            <label for="group_order" class="w-1/2">Send With Past Order</label>
                            <select id="group_order" name="group_order" autocomplete="off">
                                <option value="">Not Set</option>
                                @foreach($past_pending_orders as $order)
                                    <option value="{{ $order->order_number }}">{{ $order->order_number }} / {{ $order->reference }}</option>
                                @endforeach
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 pt-6 xl:pt-0 text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                     class="fill-current h-4 w-4">
                                    <path
                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"></path>
                                </svg>
                            </div>
                        </div>
                    @endif

                    <div class="xl:flex items-center mb-3">
                        <label for="reference" class="w-1/2">Order Reference <span class="text-red-600">*</span></label>
                        <input id="reference" name="reference" autocomplete="off"
                               maxlength="20"
                               value="{{ old('reference') }}">
                    </div>

                    <div class="xl:flex items-center mb-3">
                        <label for="notes" class="w-1/2">Order Notes</label>
                        <input id="notes" name="notes" autocomplete="off"
                               value="{{ old('notes') }}">
                    </div>

                    <delivery-method :delivery_methods="{{ json_encode($delivery_methods, true) }}"
                                     old_delivery_method="{{ old('shipping') ?? 1 }}"
                                     goods_total="{{ removeCurrencySymbol($basket['summary']['goods_total']) }}"
                                     small_order_threshold="{{ $basket['summary']['small_order_rules']['threshold'] }}">
                    </delivery-method>

                    <h4 class="text-primary mt-3">Contact Details</h4>

                    <div class="xl:flex items-center mb-3">
                        <label for="name" class="w-1/2">Name <span class="text-red-600">*</span></label>
                        <input id="name"
                               name="name"
                               value="{{ old('name') ?: auth()->user()->name }}"
                               maxlength="37"
                               autocomplete="off">
                    </div>

                    <div class="xl:flex items-center mb-3">
                        <label for="telephone" class="w-1/2">Telephone</label>
                        <input id="telephone"
                               name="telephone"
                               value="{{ old('telephone') ?: auth()->user()->telephone }}"
                               autocomplete="off">
                    </div>

                    <div class="xl:flex items-center mb-3">
                        <label for="mobile"
                               class="w-1/2">Mobile {!! session('address') ? '<span class="text-red-600">*</span>' : '' !!}</label>
                        <input id="mobile"
                               name="mobile"
                               value="{{ old('mobile') ?: auth()->user()->mobile }}"
                               maxlength="37"
                               autocomplete="off">
                    </div>

                    <div class="flex mb-3">
                        <label class="checkbox flex items-center">
                            <input type="checkbox" name="terms" class="form-checkbox"
                                   {{ old('terms') ? 'checked' : '' }} autocomplete="off">
                            <span class="ml-2 text-xs xl:text-sm">I have read and agree to the <a
                                    href="{{ route('support.terms') }}"
                                    class="underline" target="_blank">terms & conditions</a> <span class="text-red-600">*</span>
                            </span>
                        </label>
                    </div>

                    @if($checkout_notice)
                        <div role="alert" class="alert alert-info">
                            <div class="alert-body text-sm leading-none items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="alert-icon">
                                    <path d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20z" class="primary"></path>
                                    <path
                                        d="M11 12a1 1 0 0 1 0-2h2a1 1 0 0 1 .96 1.27L12.33 17H13a1 1 0 0 1 0 2h-2a1 1 0 0 1-.96-1.27L11.67 12H11zm2-4a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"
                                        class="secondary"></path>
                                </svg>
                                <div>
                                    <p class="alert-text">{{ $checkout_notice }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="mb-3">
            <h4 class="text-primary">Order Summary</h4>

            <basket-summary :summary="{{ json_encode($basket['summary'], true) }}"></basket-summary>

            @if($basket['summary']['small_order_rules']['original']['threshold'] > 0)
                <div class="mt-3 text-xs">
                    * orders below {{ currency($basket['summary']['small_order_rules']['threshold'], 0) }} attract
                    a {{ currency($basket['summary']['small_order_rules']['original']['charge'], 0) }}

                    @if($basket['summary']['small_order_rules']['exclude_collection'] && $basket['summary']['small_order_rules']['exclude_charged_delivery'])
                        small order charge, unless you are collecting your order or paying a delivery charge.
                    @elseif ($basket['summary']['small_order_rules']['exclude_collection'])
                        small order charge, unless you are collecting your order.
                    @elseif ($basket['summary']['small_order_rules']['exclude_charged_delivery'])
                        small order charge, unless you are paying a delivery charge.
                    @else
                        small order charge.
                    @endif
                </div>
            @endif
        </div>

        <div class="flex justify-between">
            <div class="flex">
                <a href="{{ route('products') }}">
                    <button class="hidden md:block mr-2 button button-secondary">Continue Shopping</button>
                </a>
                <a href="{{ route('basket') }}">
                    <button class="button button-secondary">Return To basket</button>
                </a>
            </div>

            <checkout></checkout>
        </div>
    </form>

    @if(!$account)
        <small-order-notice
            threshold="{{ $basket['summary']['small_order_rules']['threshold'] }}"
            charge="{{ $basket['summary']['small_order_rules']['charge'] }}"
            goods-total="{{ preg_replace('/[^0-9.]/', '', $basket['summary']['goods_total']) }}"
            message="@if($basket['summary']['small_order_rules']['exclude_collection'] && $basket['summary']['small_order_rules']['exclude_charged_delivery'])
                small order charge, unless you are collecting your order or paying a delivery charge.
            @elseif ($basket['summary']['small_order_rules']['exclude_collection'])
                small order charge, unless you are collecting your order.
            @elseif ($basket['summary']['small_order_rules']['exclude_charged_delivery'])
                small order charge, unless you are paying a delivery charge.
            @else
                small order charge.
            @endif"
            currency="{{ currencySymbol() }}"
            validation-errors="{{ !$errors->isEmpty() }}"
        ></small-order-notice>
    @endif
@endsection
