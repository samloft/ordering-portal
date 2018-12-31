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
            @else
                <div class="card card-body no-product">
                    Oops, no product :(
                </div>
            @endif
        </div>
    </div>
@endsection