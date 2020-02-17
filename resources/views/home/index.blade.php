@extends('layout.master')

@section('page.title', 'Home')

@section('content')
    <div class="flex">
            @include('home.adverts')
        <div class="w-3/4">
            @include('home.categories')
        </div>
    </div>
@endsection
