@extends('cms.layout.master')

@section('page.title', 'Product Images')

@section('content')
    <div class="container-fluid page__heading-container">
        <div class="page__heading d-flex align-items-center">
            <div class="flex">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Product Images</li>
                    </ol>
                </nav>
                <h1 class="m-0">Product Images</h1>
            </div>
        </div>
    </div>


    <div class="container-fluid page__container">
        <div class="product-image-checking alert alert-info text-center is-loading p-4" role="alert"></div>

        <div class="product-image-error alert alert-danger text-center p-4 d-none" role="alert">
            <span class="images-missing"></span> have been found to be missing.
        </div>

        <div class="product-image-success alert alert-success text-center p-4 d-none" role="alert">
            No product images have been found to be missing
        </div>

        <div class="card card-form product-image-results d-none">
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
                            <tbody class="list">
                            <tr>
                                <td>3 days ago</td>
                                <td>$12,402</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        {{--$(function () {--}}
            {{--var product_list = '@json($products)';--}}

            // $(product_list).each(function (index, item) {
            // $.each(product_list, function (index, item) {
            //     console.log(item);
            //     if (item) {
            {{--@foreach($products as $product)--}}
            {{--$.get('{{ route('products.check-image', ['products' => $product]) }}').done(function (response) {--}}
                {{--if (response.found === false) {--}}
                    {{--$('.product-image-results').show();--}}
                    {{--$('.product-image-results tbody').append(--}}
                        {{--'<tr><td>' + item.product + '</td></tr>'--}}
                    {{--);--}}
                {{--}--}}
            {{--});--}}
            {{--@endforeach--}}
            //     }
            // });
        // });
    </script>
@endsection