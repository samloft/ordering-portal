@extends('layout.master')

@section('page.title', 'Order Upload')

@section('content')
    <h1 class="page-title">{{ __('Upload An Order') }}</h1>

    <div class="card card-body">
        <h2 class="section-title">CSV Upload</h2>

        <div class="form-row justify-content-center mb-5">
            <div class="custom-file col-5">
                <label class="custom-file-label" for="customFile">Choose file</label>
                <input type="file" class="custom-file-input" id="customFile">
            </div>
            <div class="col-1">
                <button class="btn btn-primary">{{ __('Upload') }}</button>
            </div>
        </div>

        <span class="text-center">To upload an order please select a CSV file that's in the format, product code followed by quantity (with no headers)
            once uploaded you'll be taken to a page where you can review and confirm your order.</span>

        <hr class="mt-3 mb-3">

        <h2 class="section-title">PDF Upload</h2>

        <div class="alert alert-warning">
            <strong>Warning!</strong> PDF uploads are purely experimental and we cannot guarantee any kind of success. You must check
            the order for any errors. <strong>Use at your own risk!</strong>
        </div>

        <div class="form-row justify-content-center mb-5">
            <div class="custom-file col-5">
                <label class="custom-file-label" for="customFile">Choose file</label>
                <input type="file" class="custom-file-input" id="customFile">
            </div>
            <div class="col-1">
                <button class="btn btn-primary">{{ __('Upload') }}</button>
            </div>
        </div>
    </div>
@endsection