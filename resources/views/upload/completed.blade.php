@extends('layout.master')

@section('page.title', 'Order Upload Completion')

@section('content')
    <h1 class="text-center font-semi-bold text-2xl mb-3">
        {{ __('Upload Completed') }}
        <span
            class="block text-lg font-thin">{{ __('Your order upload has been completed') }}</span>
    </h1>

    <div class="bg-white rounded shadow-md p-6">
        <div class="text-center">
            <p>
                {{ __('Your order has been successfully imported into the basket, you can now continue adding to
                this basket if you wish.') }}
            </p>

            <div class="mt-4">
                <a href="{{ route('upload') }}" class="btn-link mr-2">
                    <button class="button">{{ __('Upload another order') }}</button>
                </a>
                <a href="{{ route('products') }}" class="btn-link mr-2">
                    <button class="button button-secondary">{{ __('Add products to order') }}</button>
                </a>
                <a href="{{ route('basket') }}" class="btn-link">
                    <button class="button button-primary">{{ __('View your basket') }}</button>
                </a>
            </div>
        </div>
    </div>
@endsection
