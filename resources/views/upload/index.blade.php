@extends('layout.master')

@section('page.title', 'Order Upload')

@section('content')
    <h1 class="page-title">{{ __('Upload An Order') }}</h1>

    <div class="card card-body">
        @include('layout.alerts')

        <div class="alert alert-warning mb-5">
            {!! ('<strong>Note!</strong> To upload an order, you must use a <strong>CSV</strong>
            file that\'s in the format,
            product code in the first column and quantity in the second column (No headers).
            Once uploaded you\'ll be taken to a page where you can review and confirm your order.') !!}
        </div>

        <form method="post" action="{{ route('upload-validate') }}" enctype="multipart/form-data">
            <div class="form-row justify-content-center mb-5">
                <div class="custom-file col-5">
                    <label class="custom-file-label">{{ __('Choose a CSV file') }}</label>
                    <input type="file" id="order-file" class="custom-file-input" name="input_file">
                </div>
                <div class="col-1">
                    <button id="upload-order" class="btn btn-primary">{{ __('Upload') }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection