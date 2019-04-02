@extends('cms.layout.master')

@section('page.title', 'Product Images')
@section('page.heading', 'Product Images')

@section('content')
    <div class="container-fluid page__container">
        <div class="card card-form">
            <div class="row no-gutters">
                <div class="col-lg-5 card-body">
                    <p>
                        {{ __('Check for missing product images and upload them.') }}
                    </p>

                    <div class="text-center">
                        <button id="product-images__check" class="btn btn-primary mb-3 mt-3">
                            {{ __('Check Missing Images') }}
                        </button>
                    </div>

                    <div class="product-images__checking alert alert-info text-center p-4 d-none">
                        <i class="fas fa-spinner fa-spin"></i> {{ __('Checking for missing images, please wait.') }}
                    </div>

                    <div class="product-images__error alert alert-danger text-center p-4 d-none">
                        <span class="images-missing__count font-weight-bold"></span>
                        {{ __('product have been found to be missing.') }}
                    </div>

                    <div class="product-images__success alert alert-success text-center p-4 d-none" role="alert">
                        {{ __('No product images have been found to be missing') }}
                    </div>

                    <div class="card card-form product-images__results d-none">
                        <div class="row no-gutters">
                            <div class="col card-form__body">
                                <div class="table-responsive border-bottom">
                                    <table class="table mb-0 thead-border-top-0">
                                        <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Image Required</th>
                                        </tr>
                                        </thead>
                                        <tbody class="list"></tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 card-form__body card-body">
                    <label>{{ __('Product image upload') }}</label>

                    <form action="{{ route('cms.product-images.store') }}"
                          class="dropzone"
                          id="my-awesome-dropzone"></form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#product-images__check').on('click', function () {
            $('.product-images__results tbody').empty();
            $('.product-images__results').addClass('d-none');
            $('.product-images__error').addClass('d-none');
            $('.product-images__success').addClass('d-none');
            $('.product-images__checking').removeClass('d-none');

            checkImages();
        });

        function checkImages() {
            $.post('product-images/check').done(function (response) {
                if (response) {
                    $('.product-images__checking').addClass('d-none');

                    $.each(response, function (index, item) {
                        $('.product-images__results tbody').append(
                            '<tr><td>' + item.product + '</td><td>' + item.file_name + '</td></tr>'
                        );
                    });

                    $('.images-missing__count').text(response.length);
                    $('.product-images__results').removeClass('d-none');
                    $('.product-images__error').removeClass('d-none');
                } else {
                    $('.product-images__success').removeClass('d-none');
                }
            }).fail(function () {
                $('.product-images__checking').addClass('d-none');
                alert('Error getting missing images');
            });
        }
    </script>
@endsection