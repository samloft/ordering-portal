@extends('layout.master')

@section('page.title', 'Order Upload Completion')

@section('content')
    <div class="w-full mb-5 text-center">
        <h2 class="font-semibold tracking-widest">Upload Completed</h2>
        <p class="font-thin">
            Your order upload has been completed
        </p>
    </div>

    <div class="bg-white rounded shadow-md p-6">
        <div class="text-center">
            <div class="flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="alert-icon fill-current w-40 mb-5">
                    <circle cx="12" cy="12" r="10"  class="text-teal-200"></circle>
                    <path class="text-teal-600" d="M10 14.59l6.3-6.3a1 1 0 0 1 1.4 1.42l-7 7a1 1 0 0 1-1.4 0l-3-3a1 1 0 0 1 1.4-1.42l2.3 2.3z"></path>
                </svg>
            </div>

            <p>
                Your order has been successfully imported into the basket, you can now continue adding to
                this basket if you wish.
            </p>

            <div class="mt-4">
                <a href="{{ route('upload') }}" class="btn-link mr-2">
                    <button class="button button-inverse">Upload another order</button>
                </a>
                <a href="{{ route('products') }}" class="btn-link mr-2">
                    <button class="button button-secondary">Add products to order</button>
                </a>
                <a href="{{ route('basket') }}" class="btn-link">
                    <button class="button button-primary">View your basket</button>
                </a>
            </div>
        </div>
    </div>
@endsection
