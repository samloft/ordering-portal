@extends('layout.master')

@section('page.title', 'Order Upload')

@section('content')
    <div class="w-full mb-5 text-center">
        <h2 class="font-semibold tracking-widest">{{ __('Order Upload') }}</h2>
        <p class="font-thin">
            {{ __('Upload your order for a faster ordering process') }}
        </p>
    </div>

    <div class="bg-white rounded shadow-md p-6">
        @include('layout.alerts')

        <div class="flex">
            <div class="w-1/3 pr-10">
                Order Upload

                <p class="text-gray-500 text-sm mt-2">
                    Upload your order with a simple CSV file, entering product code in column A and quantity in column B
                </p>
            </div>

            <div class="w-2/3">
                <form method="post" action="{{ route('upload-validate') }}" enctype="multipart/form-data" class="mb-0">
                    <order-upload></order-upload>
                </form>
            </div>
        </div>
    </div>
@endsection
