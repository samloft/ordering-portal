@extends('layout.master')

@section('page.title', 'Home')

@section('content')
    <div class="flex">
        @if(count($adverts) > 0)
            @include('home.adverts')
        @endif
        <div class="{{ count($adverts) > 0 ? 'md:w-3/4' : 'w-full' }} sm:w-full">
            @include('home.categories')
        </div>
    </div>
@endsection
