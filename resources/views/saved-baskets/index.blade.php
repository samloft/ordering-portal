@extends('layout.master')

@section('page.title', 'Saved Baskets')

@section('content')
    <h1 class="page-title">{{ __('Saved Basket Templates') }}</h1>

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