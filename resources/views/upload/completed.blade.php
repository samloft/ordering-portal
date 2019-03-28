@extends('layout.master')

@section('page.title', 'Order Upload Completion')

@section('content')
    <h1 class="page-title">{{ __('Upload An Order (Completed)') }}</h1>

    <div class="card card-body text-center">
        <h5 class="mt-5 mb-5">Your order has been successfully imported into the basket, you can now continue adding to
            this basket if you wish.</h5>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('upload') }}" class="btn-link">
            <button class="btn btn-blue">{{ __('Upload another order') }}</button>
        </a>
        <a href="{{ route('products') }}" class="btn-link">
            <button class="btn btn-blue">{{ __('Add products to order') }}</button>
        </a>
        <a href="{{ route('basket') }}" class="btn-link">
            <button class="btn btn-blue">{{ __('View your basket') }}</button>
        </a>
    </div>
@endsection