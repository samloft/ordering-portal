@extends('layout.master')

@section('page.title', 'Order Tracking')

@section('content')
    <h1 class="page-title">{{ __('Order Tracking') }}</h1>

    <div class="row">
        <div class="col-lg-4">
            <div class="card card-body">
                Search
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card card-body">
                Results
            </div>
        </div>
    </div>
@endsection