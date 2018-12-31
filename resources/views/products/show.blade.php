@extends('layout.master')

@section('page.title', 'View Product')

@section('content')
    <div class="row">
        @include('products.sidebar')

        <div class="col">
            @if ($product)
                <div class="breadcrumbs">
                    {{ $categories['level_1'] ? $categories['level_1'] : '' }}
                    {!! $categories['level_2'] ? ' <i class="fas fa-caret-right mx-2"></i> ' . $categories['level_2'] : '' !!}
                    {!! $categories['level_3'] ? ' <i class="fas fa-caret-right mx-2"></i> ' . $categories['level_3'] : '' !!}
                </div>

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