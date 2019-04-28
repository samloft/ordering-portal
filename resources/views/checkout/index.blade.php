@extends('layout.master')

@section('page.title', 'Checkout')

@section('content')
    @include('layout.progress', ['progress_title' => 'Checkout', 'progress_amount' => 2])

    <form method="post" action="{{ route('checkout.order') }}">
        <div class="row">
            <div class="col-lg-5 d-flex align-items-stretch">
                <div class="card card-body">
                    <h2 class="section-title">{{ __('Delivery Address') }}</h2>
                    <div class="address">
                        @if (session('address'))
                            <div class="address">
                                <span>{{ session('address.address_details.company_name') }}</span>
                                <span>{{ session('address.address_details.address_2') }}</span>
                                <span>{{ session('address.address_details.address_3') }}</span>
                                <span>{{ session('address.address_details.address_4') }}</span>
                                <span>{{ session('address.address_details.address_5') }}</span>
                                <span>{{ session('address.address_details.postcode') }}</span>
                            </div>
                        @elseif ($default_address)
                            <div class="address">
                                <span>{{ $default_address->company_name }}</span>
                                <span>{{ $default_address->address_line_2 }}</span>
                                <span>{{ $default_address->address_line_3 }}</span>
                                <span>{{ $default_address->address_line_4 }}</span>
                                <span>{{ $default_address->address_line_5 }}</span>
                                <span>{{ $default_address->post_code }}</span>
                            </div>
                        @else
                            <span class="text-muted">{{ __('No default delivery address set, click below to add one.') }}</span>
                        @endif

                        <div class="text-right mt-2">
                            <a href="{{ route('account.addresses', ['checkout' => true]) }}" class="btn-link">
                                <button type="button" class="btn btn-blue">{{ __('Change Delivery Address') }}</button>
                            </a>
                        </div>
                    </div>

                    <h2 class="section-title mt-3">{{ __('Invoice Address') }}</h2>
                    <div class="address">
                        <span>{{ Auth::user()->customer->invoice_customer_name }}</span>
                        <span>{{ Auth::user()->customer->invoice_customer_address_line_1 }}</span>
                        <span>{{ Auth::user()->customer->invoice_customer_address_line_2 }}</span>
                        <span>{{ Auth::user()->customer->invoice_customer_address_line_3 }}</span>
                        <span>{{ Auth::user()->customer->invoice_customer_address_line_4 }}</span>
                        <span>{{ Auth::user()->customer->invoice_customer_address_line_5 }}</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 d-flex align-items-stretch">
                <div class="card card-body">
                    @include('layout.alerts')

                    <h2 class="section-title">{{ __('Order Details') }}</h2>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">{{ __('Order Reference') }}</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="reference" autocomplete="off" value="{{ old('reference') }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">{{ __('Order Notes') }}</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="notes" autocomplete="off" value="{{ old('notes') }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">{{ __('Shipping') }}</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="shipping" autocomplete="off">
                                @foreach($delivery_methods as $delivery_method)
                                    <option value="{{ $delivery_method->uuid }}"
                                            data-cost="{{ $delivery_method->price }}" {{ $delivery_method == old('shipping') ? 'selected' : '' }}>
                                        {{ $delivery_method->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <h2 class="section-title">{{ __('Contact Details') }}</h2>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">{{ __('First Name') }}</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="first_name" value="{{ old('first_name') ? old('first_name') : Auth::user()->first_name }}" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">{{ __('Surname') }}</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="last_name" value="{{ old('last_name') ? old('last_name') : Auth::user()->last_name }}" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">{{ __('Telephone') }}</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="telephone" value="{{ old('telephone') ? old('telephone') : Auth::user()->telephone }}" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">{{ __('Evening Telephone') }}</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="evening_telephone" value="{{ old('evening_telephone') ? old('evening_telephone') : Auth::user()->evening_telephone }}" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">{{ __('Fax') }}</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="fax" value="{{ old('fax') ? old('fax') : Auth::user()->fax }}" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">{{ __('Mobile') }}</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="mobile" value="{{ old('mobile') ? old('mobile') : Auth::user()->mobile }}" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-check form-check-inline mb-3">
                        <input class="form-check-input" type="checkbox"
                               name="terms" {{ old('terms') ? 'checked' : '' }} autocomplete="off">
                        <label class="form-check-label">{{ __('I have read and agree to the terms & conditions') }}</label>
                    </div>

                    <div class="alert alert-warning">
                        {{ __('Optional checkout note here... Like delivery cut-offs') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-body mt-3 summary">
            <h2 class="section-title">{{ __('Order Summary') }}</h2>

            <div class="row">
                <div class="col">Goods Total</div>
                <div class="col text-right"><span id="goods_total">{{ $basket['summary']['goods_total'] }}</span></div>
            </div>
            <div class="row">
                <div class="col">Shipping</div>
                <div class="col text-right"><span id="shipping">{{ $basket['summary']['shipping'] }}</span></div>
            </div>
            <div class="row">
                <div class="col">Sub Total</div>
                <div class="col text-right"><span id="sub_total">{{ $basket['summary']['sub_total'] }}</span></div>
            </div>
            <div class="row">
                <div class="col">Small Order Charge*</div>
                <div class="col text-right"><span
                            id="small_order_charge">{{ $basket['summary']['small_order_charge'] }}</span></div>
            </div>
            <div class="row">
                <div class="col">VAT</div>
                <div class="col text-right"><span id="vat">{{ $basket['summary']['vat'] }}</span></div>
            </div>
            <hr>
            <div class="row basket-total">
                <div class="col">Order Total</div>
                <div class="col text-right"><span id="total">{{ $basket['summary']['total'] }}</span></div>
            </div>

            <div class="small-print">
                <div class="row">
                    <div class="col">
                        {{ __('*orders below £200 attract a £10 small order charge, unless you are collecting your order.') }}
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col">
                    <a href="{{ route('products') }}" class="btn-link">
                        <button class="btn btn-blue">{{ __('Continue Shopping') }}</button>
                    </a>
                    <a href="{{ route('basket') }}" class="btn-link">
                        <button class="btn btn-blue">{{ __('Return To basket') }}</button>
                    </a>
                </div>
                <div class="col text-right">
                    <button type="submit" class="btn btn-primary">{{ __('Place Order') }}</button>
                </div>
            </div>
        </div>
    </form>
@endsection