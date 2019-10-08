@extends('layout.master')

@section('page.title', 'Order Upload')

@section('content')
    <h1 class="text-center font-semi-bold text-2xl mb-3">
        {{ __('Order Upload') }}
        <span class="block text-lg font-thin">{{ __('Upload your order for a faster ordering process') }}</span>
    </h1>

    <div class="bg-white rounded shadow-md p-6">
        @include('layout.alerts')

        <div class="flex">
            <div class="w-1/3 pr-10">
                Order Upload

                <p class="text-gray-500 text-md mt-2">
                    Upload your order with a simple CSV file, entering product code in column A and quantity in column B
                </p>
            </div>

            <div class="w-2/3">
                <form method="post" action="{{ route('upload-validate') }}" enctype="multipart/form-data">
                    <order-upload></order-upload>
                </form>
            </div>
        </div>
    </div>
@endsection
