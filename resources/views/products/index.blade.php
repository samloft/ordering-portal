@extends('layout.master')

@section('page.title', 'Product')

@section('content')
    <div class="flex">
        @include('products.sidebar')

        <div class="w-auto">
            @include('home.categories')
        </div>
    </div>
@endsection
