@extends('layout.master')

@section('page.title', 'Checkout')

@section('content')
    <div class="w-full mb-5 text-center">
        <h2 class="font-semibold tracking-widest">{{ __('Checkout') }}</h2>
        <p class="font-thin">
            {{ __('Complete your order') }}
        </p>
    </div>

    <form method="post" action="{{ route('checkout.order') }}">
        <div class="flex">
            <div class="w-1/2">
                <div class="bg-white rounded shadow-md p-6 text-center mb-5 mr-2">
                    <h4 class="text-primary">{{ __('Delivery Address') }}</h4>

                    @if (session('address'))
                        <div class="w-3/4 text-center bg-gray-200 p-4 rounded mx-auto">
                            <div>{{ session('address.address_details.company_name') }}</div>
                            <div>{{ session('address.address_details.address_2') }}</div>
                            <div>{{ session('address.address_details.address_3') }}</div>
                            <div>{{ session('address.address_details.address_4') }}</div>
                            <div>{{ session('address.address_details.address_5') }}</div>
                            <div>{{ session('address.address_details.postcode') }}</div>
                        </div>
                    @elseif ($default_address)
                        <div class="w-3/4 text-center bg-gray-200 p-4 rounded mx-auto">
                            <div>{{ $default_address->company_name }}</div>
                            <div>{{ $default_address->address_line_2 }}</div>
                            <div>{{ $default_address->address_line_3 }}</div>
                            <div>{{ $default_address->address_line_4 }}</div>
                            <div>{{ $default_address->address_line_5 }}</div>
                            <div>{{ $default_address->post_code }}</div>
                        </div>
                    @else
                        <span class="text-red-400">{{ __('No default delivery address set, click below to add one.') }}</span>
                    @endif

                    <div class="text-center mt-2 mb-2">
                        <a href="{{ route('account.addresses', ['checkout' => true]) }}">
                            <button type="button" class="button button-primary">
                                {{ __('Change Delivery Address') }}
                            </button>
                        </a>
                    </div>

                    <h4 class="text-primary mt-5">{{ __('Invoice Address') }}</h4>

                    <div class="w-3/4 text-center bg-gray-200 p-4 rounded mx-auto">
                        <div>{{ auth()->user()->customer->invoice_name }}</div>
                        <div>{{ auth()->user()->customer->invoice_address_line_1 }}</div>
                        <div>{{ auth()->user()->customer->invoice_address_line_2 }}</div>
                        <div>{{ auth()->user()->customer->invoice_address_line_3 }}</div>
                        <div>{{ auth()->user()->customer->invoice_address_line_4 }}</div>
                        <div>{{ auth()->user()->customer->invoice_address_line_5 }}</div>
                    </div>
                </div>
            </div>
            <div class="w-1/2">
                <div class="bg-white rounded shadow-md p-6 mb-5 ml-2">
                    @include('layout.alerts')

                    <h4 class="text-primary">{{ __('Order Details') }}</h4>

                    <div class="flex items-center mb-3">
                        <label for="reference" class="w-1/2">{{ __('Order Reference') }}</label>
                        <input id="reference" class="bg-gray-100" name="reference" autocomplete="off" value="{{ old('reference') }}">
                    </div>

                    <div class="flex items-center mb-3">
                        <label for="notes" class="w-1/2">{{ __('Order Notes') }}</label>
                        <input id="notes" class="bg-gray-100" name="notes" autocomplete="off" value="{{ old('notes') }}">
                    </div>

                    <div class="flex items-center relative mb-3">
                        <label for="shipping" class="w-1/2">{{ __('Shipping') }}</label>
                        <select id="shipping" class="bg-gray-100" name="shipping" autocomplete="off">
                            @foreach($delivery_methods as $delivery_method)
                                <option value="{{ $delivery_method->uuid }}"
                                        data-cost="{{ $delivery_method->price }}" {{ $delivery_method === old('shipping') ? 'selected' : '' }}>
                                    {{ $delivery_method->title }}
                                </option>
                            @endforeach
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                 class="fill-current h-4 w-4">
                                <path
                                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"></path>
                            </svg>
                        </div>
                    </div>

                    <h4 class="text-primary mt-3">{{ __('Contact Details') }}</h4>

                    <div class="flex items-center mb-3">
                        <label for="name" class="w-1/2">{{ __('Name') }}</label>
                        <input id="name"
                               class="bg-gray-100"
                               name="name"
                               value="{{ old('name') ?: auth()->user()->name }}"
                               autocomplete="off">
                    </div>

                    <div class="flex items-center mb-3">
                        <label for="telephone" class="w-1/2">{{ __('Telephone') }}</label>
                        <input id="telephone"
                               class="bg-gray-100"
                               name="telephone"
                               value="{{ old('telephone') ?: auth()->user()->telephone }}"
                               autocomplete="off">
                    </div>

                    <div class="flex items-center mb-3">
                        <label for="mobile" class="w-1/2">{{ __('Mobile') }}</label>
                        <input id="mobile"
                               class="bg-gray-100"
                               name="mobile"
                               value="{{ old('mobile') ?: auth()->user()->mobile }}"
                               autocomplete="off">
                    </div>

                    <div class="flex mb-3">
                        <label class="checkbox flex items-center">
                            <input type="checkbox" name="terms" class="form-checkbox"
                                   value="{{ old('terms') ? 'checked' : '' }}" autocomplete="off">
                            <span class="ml-2">{{ __('I have read and agree to the terms & conditions') }}</span>
                        </label>
                    </div>

                    <div role="alert" class="alert alert-info">
                        <div class="alert-body text-sm leading-none items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="alert-icon">
                                <path d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20z" class="primary"></path>
                                <path
                                    d="M11 12a1 1 0 0 1 0-2h2a1 1 0 0 1 .96 1.27L12.33 17H13a1 1 0 0 1 0 2h-2a1 1 0 0 1-.96-1.27L11.67 12H11zm2-4a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"
                                    class="secondary"></path>
                            </svg>
                            <div>
                                <p class="alert-text">{{ __('Optional checkout note here... Like delivery cut-offs') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{--        <div class="row">--}}
        {{--            <div class="col-lg-5 d-flex align-items-stretch">--}}
        {{--                <div class="card card-body">--}}
        {{--                    <h2 class="section-title">{{ __('Delivery Address') }}</h2>--}}
        {{--                    <div class="address">--}}
        {{--                        @if (session('address'))--}}
        {{--                            <div class="address">--}}
        {{--                                <span>{{ session('address.address_details.company_name') }}</span>--}}
        {{--                                <span>{{ session('address.address_details.address_2') }}</span>--}}
        {{--                                <span>{{ session('address.address_details.address_3') }}</span>--}}
        {{--                                <span>{{ session('address.address_details.address_4') }}</span>--}}
        {{--                                <span>{{ session('address.address_details.address_5') }}</span>--}}
        {{--                                <span>{{ session('address.address_details.postcode') }}</span>--}}
        {{--                            </div>--}}
        {{--                        @elseif ($default_address)--}}
        {{--                            <div class="address">--}}
        {{--                                <span>{{ $default_address->company_name }}</span>--}}
        {{--                                <span>{{ $default_address->address_line_2 }}</span>--}}
        {{--                                <span>{{ $default_address->address_line_3 }}</span>--}}
        {{--                                <span>{{ $default_address->address_line_4 }}</span>--}}
        {{--                                <span>{{ $default_address->address_line_5 }}</span>--}}
        {{--                                <span>{{ $default_address->post_code }}</span>--}}
        {{--                            </div>--}}
        {{--                        @else--}}
        {{--                            <span class="text-muted">{{ __('No default delivery address set, click below to add one.') }}</span>--}}
        {{--                        @endif--}}

        {{--                        <div class="text-right mt-2">--}}
        {{--                            <a href="{{ route('account.addresses', ['checkout' => true]) }}" class="btn-link">--}}
        {{--                                <button type="button" class="btn btn-blue">{{ __('Change Delivery Address') }}</button>--}}
        {{--                            </a>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}

        {{--                    <h2 class="section-title mt-3">{{ __('Invoice Address') }}</h2>--}}
        {{--                    <div class="address">--}}
        {{--                        <span>{{ Auth::user()->customer->invoice_customer_name }}</span>--}}
        {{--                        <span>{{ Auth::user()->customer->invoice_customer_address_line_1 }}</span>--}}
        {{--                        <span>{{ Auth::user()->customer->invoice_customer_address_line_2 }}</span>--}}
        {{--                        <span>{{ Auth::user()->customer->invoice_customer_address_line_3 }}</span>--}}
        {{--                        <span>{{ Auth::user()->customer->invoice_customer_address_line_4 }}</span>--}}
        {{--                        <span>{{ Auth::user()->customer->invoice_customer_address_line_5 }}</span>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--            <div class="col-lg-7 d-flex align-items-stretch">--}}
        {{--                <div class="card card-body">--}}
        {{--                    @include('layout.alerts')--}}

        {{--                    <h2 class="section-title">{{ __('Order Details') }}</h2>--}}

        {{--                    <div class="form-group row">--}}
        {{--                        <label class="col-sm-4 col-form-label">{{ __('Order Reference') }}</label>--}}
        {{--                        <div class="col-sm-8">--}}
        {{--                            <input class="form-control" name="reference" autocomplete="off" value="{{ old('reference') }}">--}}
        {{--                        </div>--}}
        {{--                    </div>--}}

        {{--                    <div class="form-group row">--}}
        {{--                        <label class="col-sm-4 col-form-label">{{ __('Order Notes') }}</label>--}}
        {{--                        <div class="col-sm-8">--}}
        {{--                            <input class="form-control" name="notes" autocomplete="off" value="{{ old('notes') }}">--}}
        {{--                        </div>--}}
        {{--                    </div>--}}

        {{--                    <div class="form-group row">--}}
        {{--                        <label class="col-sm-4 col-form-label">{{ __('Shipping') }}</label>--}}
        {{--                        <div class="col-sm-8">--}}
        {{--                            <select class="form-control" name="shipping" autocomplete="off">--}}
        {{--                                @foreach($delivery_methods as $delivery_method)--}}
        {{--                                    <option value="{{ $delivery_method->uuid }}"--}}
        {{--                                            data-cost="{{ $delivery_method->price }}" {{ $delivery_method === old('shipping') ? 'selected' : '' }}>--}}
        {{--                                        {{ $delivery_method->title }}--}}
        {{--                                    </option>--}}
        {{--                                @endforeach--}}
        {{--                            </select>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}

        {{--                    <h2 class="section-title">{{ __('Contact Details') }}</h2>--}}

        {{--                    <div class="form-group row">--}}
        {{--                        <label class="col-sm-4 col-form-label">{{ __('First Name') }}</label>--}}
        {{--                        <div class="col-sm-8">--}}
        {{--                            <input class="form-control" name="first_name" value="{{ old('first_name') ? old('first_name') : Auth::user()->first_name }}" autocomplete="off">--}}
        {{--                        </div>--}}
        {{--                    </div>--}}

        {{--                    <div class="form-group row">--}}
        {{--                        <label class="col-sm-4 col-form-label">{{ __('Surname') }}</label>--}}
        {{--                        <div class="col-sm-8">--}}
        {{--                            <input class="form-control" name="last_name" value="{{ old('last_name') ? old('last_name') : Auth::user()->last_name }}" autocomplete="off">--}}
        {{--                        </div>--}}
        {{--                    </div>--}}

        {{--                    <div class="form-group row">--}}
        {{--                        <label class="col-sm-4 col-form-label">{{ __('Telephone') }}</label>--}}
        {{--                        <div class="col-sm-8">--}}
        {{--                            <input class="form-control" name="telephone" value="{{ old('telephone') ? old('telephone') : Auth::user()->telephone }}" autocomplete="off">--}}
        {{--                        </div>--}}
        {{--                    </div>--}}

        {{--                    <div class="form-group row">--}}
        {{--                        <label class="col-sm-4 col-form-label">{{ __('Evening Telephone') }}</label>--}}
        {{--                        <div class="col-sm-8">--}}
        {{--                            <input class="form-control" name="evening_telephone" value="{{ old('evening_telephone') ? old('evening_telephone') : Auth::user()->evening_telephone }}" autocomplete="off">--}}
        {{--                        </div>--}}
        {{--                    </div>--}}

        {{--                    <div class="form-group row">--}}
        {{--                        <label class="col-sm-4 col-form-label">{{ __('Fax') }}</label>--}}
        {{--                        <div class="col-sm-8">--}}
        {{--                            <input class="form-control" name="fax" value="{{ old('fax') ? old('fax') : Auth::user()->fax }}" autocomplete="off">--}}
        {{--                        </div>--}}
        {{--                    </div>--}}

        {{--                    <div class="form-group row">--}}
        {{--                        <label class="col-sm-4 col-form-label">{{ __('Mobile') }}</label>--}}
        {{--                        <div class="col-sm-8">--}}
        {{--                            <input class="form-control" name="mobile" value="{{ old('mobile') ? old('mobile') : Auth::user()->mobile }}" autocomplete="off">--}}
        {{--                        </div>--}}
        {{--                    </div>--}}

        {{--                    <div class="form-check form-check-inline mb-3">--}}
        {{--                        <input class="form-check-input" type="checkbox"--}}
        {{--                               name="terms" {{ old('terms') ? 'checked' : '' }} autocomplete="off">--}}
        {{--                        <label class="form-check-label">{{ __('I have read and agree to the terms & conditions') }}</label>--}}
        {{--                    </div>--}}

        {{--                    <div class="alert alert-warning">--}}
        {{--                        {{ __('Optional checkout note here... Like delivery cut-offs') }}--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}

        <div class="mb-3">
            <h4 class="text-primary">{{ __('Order Summary') }}</h4>

            <div class="flex justify-between">
                <div>Goods Total</div>
                <div><span id="goods_total">{{ $basket['summary']['goods_total'] }}</span></div>
            </div>
            <div class="flex justify-between">
                <div>Shipping</div>
                <div><span id="shipping">{{ $basket['summary']['shipping'] }}</span></div>
            </div>
            <div class="flex justify-between">
                <div>Sub Total</div>
                <div><span id="sub_total">{{ $basket['summary']['sub_total'] }}</span></div>
            </div>
            <div class="flex justify-between">
                <div>Small Order Charge*</div>
                <div><span id="small_order_charge">{{ $basket['summary']['small_order_charge'] }}</span></div>
            </div>
            <div class="flex justify-between">
                <div>VAT</div>
                <div><span id="vat">{{ $basket['summary']['vat'] }}</span></div>
            </div>
            <hr class="mt-2 mb-2">
            <div class="flex justify-between text-lg mb-2">
                <div>Order Total</div>
                <div><span id="total">{{ $basket['summary']['total'] }}</span></div>
            </div>

            <div class="text-xs">
                {{ __('*orders below £200 attract a £10 small order charge, unless you are collecting your order.') }}
            </div>
        </div>

        <div class="flex justify-between">
            <div>
                <a href="{{ route('products') }}">
                    <button class="button button-secondary">{{ __('Continue Shopping') }}</button>
                </a>
                <a href="{{ route('basket') }}">
                    <button class="button button-secondary">{{ __('Return To basket') }}</button>
                </a>
            </div>
            <div>
                <button type="submit" class="button button-primary">{{ __('Place Order') }}</button>
            </div>
        </div>
    </form>
@endsection
