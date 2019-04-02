@extends('cms.layout.master')

@section('page.title', 'Company Information')
@section('page.heading', 'Company Information')

@section('content')
    <div class="container-fluid page__container">
        @include('cms.layout.alerts')

        <div class="card card-form">
            <div class="row no-gutters">
                <div class="col-lg-4 card-body">
                    <p><strong class="headings-color">{{ __('Company Details') }}</strong></p>

                    <p class="text-muted">
                        {{ __('Address/Social/App details, these items are shown on things like the website footer,
                               and PDF documents.') }}
                    </p>
                </div>
                <div class="col-lg-8 card-form__body card-body">
                    <form action="{{ route('cms.company-information.store') }}" method="post">
                        <div class="form-group">
                            <label>{{ __('Company Name') }}</label>
                            <input class="form-control" name="address_line_1" autocomplete="off" value="{{ env('ADDRESS_LINE_1') }}">
                        </div>

                        <div class="form-group">
                            <label>{{ __('Address Line 1') }}</label>
                            <input class="form-control" name="address_line_2" autocomplete="off" value="{{ env('ADDRESS_LINE_2') }}">
                        </div>

                        <div class="form-group">
                            <label>{{ __('Address Line 2') }}</label>
                            <input class="form-control" name="address_line_3" autocomplete="off" value="{{ env('ADDRESS_LINE_3') }}">
                        </div>

                        <div class="form-group">
                            <label>{{ __('Address Line 3') }}</label>
                            <input class="form-control" name="address_line_4" autocomplete="off" value="{{ env('ADDRESS_LINE_4') }}">
                        </div>

                        <div class="form-group">
                            <label>{{ __('Address Line 4') }}</label>
                            <input class="form-control" name="address_line_5" autocomplete="off" value="{{ env('ADDRESS_LINE_5') }}">
                        </div>

                        <div class="form-group">
                            <label>{{ __('Postcode') }}</label>
                            <input class="form-control" name="postcode" autocomplete="off" value="{{ env('ADDRESS_POSTCODE') }}">
                        </div>

                        <div class="form-group">
                            <label>{{ __('Telephone') }}</label>
                            <input class="form-control" name="telephone" autocomplete="off" value="{{ env('ADDRESS_TELEPHONE') }}">
                        </div>

                        <div class="form-group">
                            <label>{{ __('Fax') }}</label>
                            <input class="form-control" name="fax" autocomplete="off" value="{{ env('ADDRESS_FAX') }}">
                        </div>

                        <div class="form-group">
                            <label>{{ __('Email') }}</label>
                            <input class="form-control" name="email" autocomplete="off" value="{{ env('ADDRESS_EMAIL') }}">
                        </div>

                        <div class="text-right">
                            <button id="save-adverts" class="btn btn-secondary">{{ __('Save Changes') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection