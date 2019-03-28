@extends('layout.master')

@section('page.title', 'Products')

@section('content')
    <div class="row">
        @include('products.sidebar')

        <div class="col">
            @include('home.categories')
        </div>
    </div>
@endsection
