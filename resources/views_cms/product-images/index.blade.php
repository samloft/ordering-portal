@extends('layouts.master')

@section('title', 'Product Images')
@section('sub-title', 'Check for missing product images and upload new ones.')

@section('content')
    <product-images :products="{{ json_encode($products, true) }}"></product-images>
@endsection
