@extends('layout.master')

@section('page.title', 'Order Upload')

@section('content')
    <h1 class="text-center font-semi-bold text-2xl mb-3">
        {{ __('Order Upload') }}
        <span class="block text-lg font-thin">{{ __('Upload your order for a faster ordering process') }}</span>
    </h1>

    <div class="bg-white rounded shadow p-6 text-center">
        @include('layout.alerts')

{{--        <div class="alert alert-warning mb-5">--}}
{{--            {!! ('<strong>Note!</strong> To upload an order, you must use a <strong>CSV</strong>--}}
{{--            file that\'s in the format,--}}
{{--            product code in the first column and quantity in the second column (No headers).--}}
{{--            Once uploaded you\'ll be taken to a page where you can review and confirm your order.') !!}--}}
{{--        </div>--}}

        <form method="post" action="{{ route('upload-validate') }}" enctype="multipart/form-data">
            <div class="form-row justify-content-center mb-5">
                <div class="input-group">
                    <label class="custom-file-label">{{ __('Choose a CSV file') }}</label>
                    <input type="file" id="order-file" class="custom-file-input" name="input_file">
                </div>

                    <button id="upload-order" class="button button-primary">{{ __('Upload Order') }} <i class="fa fa-download"></i></button>
            </div>
        </form>
    </div>
@endsection
