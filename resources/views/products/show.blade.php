@extends('layout.master')

@section('page.title', 'View Product')

@section('content')
    <div class="row">
        @include('products.sidebar')

        <div class="col">
            @if ($product)
                @include('products.breadcrumbs')

                <div class="card card-body">
                    Product yay!
                </div>

                <h5 class="mt-2">Expected Stock</h5>
                <table class="table table-expected">
                    <thead>
                    <tr>
                        <th class="text-center">Expected Date</th>
                        <th class="text-center">Expected Quantity</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="text-center">01/01/2019</td>
                        <td class="text-center">254</td>
                    </tr>
                    </tbody>
                </table>

                <div class="text-right mt-2">
                    <button class="btn btn-blue" onclick="window.history.back();">Return to products</button>
                </div>
            @else
                <div class="card card-body no-product">
                    Oops, no product :(
                </div>
            @endif
        </div>
    </div>
@endsection