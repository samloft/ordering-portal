@extends('layout.master')

@section('page.title', 'Product Data')

@section('content')
    <product-data :product_data="{{ json_encode($product_data, true) }}" :brands="{{ json_encode($brands, true) }}"></product-data>
@endsection
