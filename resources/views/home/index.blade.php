@extends('layout.master')

@section('page.title', 'Home')

@section('content')
    <div class="row">
        @if(count($links['adverts']) > 0)
            @include('home.adverts')
        @endif

        <div class="col">
            @include('home.categories')
        </div>
    </div>
@endsection
