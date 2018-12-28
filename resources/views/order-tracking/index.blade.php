@extends('layout.master')

@section('page.title', 'Order Tracking')

@section('content')
    <h1 class="page-title">{{ __('Order Tracking') }}</h1>

    <div class="row">
        <div class="col-lg-4 d-flex align-items-stretch">
            <div class="card card-body">
                <h2 class="section-title">{{ __('Search Orders') }}</h2>

                <div class="form-group">
                    <label>{{ __('Order Number') }}</label>
                    <input class="form-control">
                </div>

                <div class="form-group">
                    <label>{{ __('Order Reference') }}</label>
                    <input class="form-control">
                </div>

                <div class="form-group">
                    <label>{{ __('Order Status') }}</label>
                    <select class="form-control">
                        <option value=""></option>
                    </select>
                </div>

                <label>{{ __('Date Range') }}</label>

                <button class="btn btn-blue btn-block">{{ __('Search Orders') }}</button>
            </div>
        </div>
        <div class="col-lg-8 d-flex align-items-stretch">
            <div class="card card-body">
                <h2 class="section-title">{{ __('Search Results') }}</h2>
            </div>
        </div>
    </div>
@endsection