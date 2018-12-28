@extends('layout.master')

@section('page.title', 'Saved Baskets')

@section('content')
    <h1 class="page-title">{{ __('Saved Basket Templates') }}</h1>

    <div class="row">
        <div class="col-lg-4 d-flex align-items-stretch">
            <div class="card card-body">
                <h2 class="section-title">{{ __('Search Templates') }}</h2>

                <div class="form-group">
                    <label>Template Reference</label>
                    <input class="form-control">
                </div>

                <label>Date Range</label>

                <button class="btn btn-blue btn-block">{{ __('Search Saved Baskets') }}</button>
            </div>
        </div>
        <div class="col-lg-8 d-flex align-items-stretch">
            <div class="card card-body">
                <h2 class="section-title">{{ __('Search Results') }}</h2>
            </div>
        </div>
    </div>
@endsection