@extends('layout.master')

@section('page.title', 'Account')

@section('content')
    <h1 class="page-title">{{ __('Your Account') }}</h1>

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
                            <button class="btn btn-blue">{{ __('Delivery Addresses') }}</button>
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

                <h2 class="section-title mt-3">{{ __('Change Password') }}</h2>
                {{ __('Click below to change your password.') }}
                <div class="text-right mt-2">
                    <a href="{{ route('account.password') }}" class="btn-link">
                        <button class="btn btn-blue">{{ __('Change Password') }}</button>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-7 d-flex align-items-stretch">
            <div class="card card-body">
                <h2 class="section-title">{{ __('Company Details') }}</h2>
                <div class="row">
                    <label class="col-sm-4 col-form-label">{{ __('Account Code') }}</label>
                    <div class="col-sm-8">
                        <input class="form-control-plaintext"
                               placeholder="{{ Auth::user()->customer->customer_code }}">
                    </div>
                </div>

                <div class="row">
                    <label class="col-sm-4 col-form-label">{{ __('Customer Name') }}</label>
                    <div class="col-sm-8">
                        <input class="form-control-plaintext"
                               placeholder="{{ Auth::user()->customer->customer_name }}">
                    </div>
                </div>

                <form method="post" action="{{ route('account.store') }}">
                    <h2 class="section-title mt-3">{{ __('Contact Details') }}</h2>

                    @include('layout.alerts')

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">{{ __('First Name') }}</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="first_name" value="{{ Auth::user()->first_name }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">{{ __('Surname') }}</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="last_name" value="{{ Auth::user()->last_name }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">{{ __('Evening Telephone') }}</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="evening_telephone"
                                   value="{{ Auth::user()->evening_telephone }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">{{ __('Fax') }}</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="fax" value="{{ Auth::user()->fax }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">{{ __('Mobile') }}</label>
                        <div class="col-sm-8">
                            <input class="form-control" name="mobile" value="{{ Auth::user()->mobile }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">{{ __('Email') }}</label>
                        <div class="col-sm-8">
                            <input class="form-control-plaintext" placeholder="{{ Auth::user()->email }}">
                            <small class="form-text text-danger">{{ __('To update your account email, please contact the sales office.') }}</small>
                        </div>
                    </div>

                    <div class="text-right">
                        <button class="btn btn-primary">{{ __('Save Changes') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection