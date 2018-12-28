@extends('layout.master')

@section('page.title', 'Basket')

@section('content')
    <div class="row">
        <div class="col">
            <h1 class="page-title">{{ __('Checkout') }}</h1>
        </div>
        <div class="col text-right">
            Tracking Stuffs
        </div>
    </div>

    <div class="row">
        <div class="col-lg-5 d-flex align-items-stretch">
            <div class="card card-body">
                <h2 class="section-title">{{ __('Delivery Address') }}</h2>
                <div class="address">
                    @if ($default_address)
                        <div class="address">
                            <span>{{ $default_address->address_line_1 }}</span>
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
                        <a href="{{ route('account.addresses') }}" class="btn-link">
                            <button class="btn btn-blue">{{ __('Change Delivery Address') }}</button>
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
                <h2 class="section-title">{{ __('Order Details') }}</h2>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">{{ __('Order Reference') }}</label>
                    <div class="col-sm-8">
                        <input class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">{{ __('Order Notes') }}</label>
                    <div class="col-sm-8">
                        <input class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">{{ __('Shipping') }}</label>
                    <div class="col-sm-8">
                        <select class="form-control">
                            <option value=""></option>
                        </select>
                    </div>
                </div>

                <h2 class="section-title">{{ __('Contact Details') }}</h2>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">{{ __('First Name') }}</label>
                    <div class="col-sm-8">
                        <input class="form-control" value="{{ Auth::user()->first_name }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">{{ __('Surname') }}</label>
                    <div class="col-sm-8">
                        <input class="form-control" value="{{ Auth::user()->last_name }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">{{ __('Telephone') }}</label>
                    <div class="col-sm-8">
                        <input class="form-control" value="{{ Auth::user()->telephone }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">{{ __('Evening Telephone') }}</label>
                    <div class="col-sm-8">
                        <input class="form-control" value="{{ Auth::user()->evening_telephone }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">{{ __('Fax') }}</label>
                    <div class="col-sm-8">
                        <input class="form-control" value="{{ Auth::user()->fax }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">{{ __('Mobile') }}</label>
                    <div class="col-sm-8">
                        <input class="form-control" value="{{ Auth::user()->mobile }}">
                    </div>
                </div>

                <div class="form-check form-check-inline mb-3">
                    <input class="form-check-input" type="checkbox" name="terms" {{ old('terms') ? 'checked' : '' }}>
                    <label class="form-check-label">{{ __('I have read and agree to the terms & conditions') }}</label>
                </div>

                <div class="alert alert-warning">
                    Optional checkout note here... Like delivery cut-offs
                </div>
            </div>
        </div>
    </div>

    <div class="card card-body mt-3 summary">
        <h2 class="section-title">{{ __('Order Summary') }}</h2>

        <div class="row">
            <div class="col">Goods Total</div>
            <div class="col text-right">£0.00</div>
        </div>
        <div class="row">
            <div class="col">Shipping</div>
            <div class="col text-right">£0.00</div>
        </div>
        <div class="row">
            <div class="col">Sub Total</div>
            <div class="col text-right">£0.00</div>
        </div>
        <div class="row">
            <div class="col">Small Order Charge*</div>
            <div class="col text-right">£0.00</div>
        </div>
        <div class="row">
            <div class="col">VAT</div>
            <div class="col text-right">£0.00</div>
        </div>
        <hr>
        <div class="row basket-total">
            <div class="col">Order Total</div>
            <div class="col text-right">£0.00</div>
        </div>

        <div class="small-print">
            <div class="row">
                <div class="col">*orders below £200 attract a £10 small order charge, unless you are collecting
                    your order.
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col">
                <button class="btn btn-blue">{{ __('Continue Shopping') }}</button>
                <button class="btn btn-blue">{{ __('Return To basket') }}</button>
            </div>
            <div class="col text-right">
                <button class="btn btn-primary">{{ __('Place Order') }}</button>
            </div>
        </div>
    </div>
@endsection