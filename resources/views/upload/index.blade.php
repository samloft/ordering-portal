@extends('layout.master')

@section('page.title', 'Order Upload')

@section('content')
    <div class="w-full mb-5 text-center">
        <h2 class="font-semibold tracking-widest">Order Upload</h2>
        <p class="font-thin">
            Upload your order for a faster ordering process
        </p>
    </div>

    <div class="bg-white rounded shadow-md p-6">
        @include('layout.alerts')

        <div class="flex">
            <div class="w-1/3 pr-10">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Order Upload
                </h3>

                <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
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
