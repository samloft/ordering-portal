@extends('layout.master')

@section('page.title', 'Addresses')

@section('content')
    <h1 class="page-title">{{ __('New Delivery Address') }}</h1>

    <div class="form-row justify-content-center">
        <div class="col-lg-7">
            <div class="card card-body">
                @include('layout.alerts')

                <div id="text-error"></div>

                <div class="input-group">
                    <input type="text" class="form-control" name="postcode_lookup">
                    <div class="input-group-append">
                        <button type="button" id="postcode-lookup"
                                class="input-group-text">{{ __('Lookup Postcode') }}</button>
                    </div>
                </div>
                <small class="form-text text-muted mb-4">{{ __('You will still need to enter company name & address line 2 manually') }}</small>

                <div class="mb-3">
                    <span class="required"></span> <span class="text-muted">{{ __('Denotes a required field') }}</span>
                </div>

                <form method="post" action="{{ route('account.address.store') }}">
                    <div class="form-group">
                        <label>{{ __('Company Name') }}<span class="required"></span></label>
                        <input class="form-control" placeholder="{{ __('Company Name') }}"
                               value="{{ isset($address_details->address_line_1) ? $address_details->address_line_1 : (old('company_name') ? old('company_name') : Auth::user()->customer->customer_name) }}"
                               name="company_name">
                    </div>

                    <div class="form-group">
                        <label>{{ __('Address Line 2') }}<span class="required"></span></label>
                        <input class="form-control" placeholder="{{ __('Address Line 2') }}" name="address_line_2"
                               value="{{ old('address_line_2') ? old('address_line_2') : ($address_details ? $address_details->address_line_2 : null) }}">
                    </div>

                    <div class="form-group">
                        <label>{{ __('Address Line 3') }}<span class="required"></span></label>
                        <input class="form-control" placeholder="{{ __('Address Line 3') }}" name="address_line_3"
                               value="{{ old('address_line_3') ? old('address_line_3') : ($address_details ? $address_details->address_line_3 : null) }}">
                    </div>

                    <div class="form-group">
                        <label>{{ __('Address Line 4') }}</label>
                        <input class="form-control" placeholder="{{ __('Address Line 4') }}" name="address_line_4"
                               value="{{ old('address_line_4') ? old('address_line_4') : ($address_details ? $address_details->address_line_4 : null) }}">
                    </div>

                    <div class="form-group">
                        <label>{{ __('Address Line 5') }}</label>
                        <input class="form-control" placeholder="{{ __('Address Line 5') }}" name="address_line_5"
                               value="{{ old('address_line_5') ? old('address_line_5') : ($address_details ? $address_details->address_line_5 : null) }}">
                    </div>

                    <div class="form-group">
                        <label>{{ __('Country') }}<span class="required"></span></label>
                        <select class="form-control" name="country_id" autocomplete="off">
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}" {{ old('country_id') ? ($country->id == old('country_id') ? 'selected' : '') : ($address_details ? ($country->id == $address_details->country_id ? 'selected' : '') : '') }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>{{ __('Postcode') }}<span class="required"></span></label>
                        <input class="form-control" placeholder="{{ __('Postcode') }}" name="postcode"
                               value="{{ old('postcode') ? old('postcode') : ($address_details ? $address_details->post_code : null) }}">
                    </div>

                    <div class="form-check form-check-inline mb-3">
                        <input class="form-check-input" type="checkbox" name="default" {{ old('postcode') ? 'checked' : ($address_details ? ($address_details->default == 1 ? 'checked' : '') : '') }}>
                        <label class="form-check-label">{{ __('Default Address') }}</label>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <a href="{{ route('account.addresses') }}" class="btn-link">
                                <button type="button" class="btn btn-blue">{{ __('Cancel') }}</button>
                            </a>
                        </div>
                        <div class="col-lg-6 text-right">
                            <input name="id" value="{{ $address_details ? $address_details->id : '' }}" hidden>
                            <button type="submit" class="btn btn-primary">{{ isset($address_details->id) ? 'Update' : 'Create' }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#postcode-lookup').on('click', function (e) {
            e.preventDefault();
            $('#text-error').empty();

            let postcode = $('input[name="postcode_lookup"]').val();

            $.get('https://api.postcodes.io/postcodes/' + postcode).done(function (response) {
                $('input[name="postcode"]').val(response.result.postcode);
                $('input[name="address_line_3"]').val(response.result.parish.replace(', unparished area', ''));
                $('input[name="address_line_4"]').val(response.result.admin_county);
                $('input[name="address_line_5"]').val(response.result.region);
            }).fail(function () {
                $('#text-error').text('Invalid Postcode');
                console.log('Invalid Postcode');
            });
        });
    </script>
@endsection