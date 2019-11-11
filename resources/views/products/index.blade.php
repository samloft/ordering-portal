@extends('products.master')

@section('page.title', 'Product')

@section('product.content')
    @if(count($links['categories']) > 0)
        <div class="d-flex flex-wrap">
            @foreach($links['categories'] as $category)
                @if($category->type === 'category-large-top')
                    <div class="w-100 mb-3 text-center">
                        <a href="{{ $category->link }}">
                            <img class="img-fluid" src="{{ $category->image }}" alt="{{ $category->name }}">
                        </a>
                    </div>
                @endif
            @endforeach

            @foreach($links['categories'] as $category)
                @if($category->type === 'category')
                    <div class="w-20">
                        <a href="{{ $category->link }}">
                            <img class="img-fluid" src="{{ asset('images/home-links/' . $category->image) }}" alt="{{ $category->name }}">
                        </a>
                    </div>
                @endif
            @endforeach

            @foreach($links['categories'] as $category)
                @if($category->type === 'category-large-bottom')
                    <div class="w-100 mb-3 text-center">
                        <a href="{{ $category->link }}">
                            <img class="img-fluid" src="{{ $category->image }}" alt="{{ $category->name }}">
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    @else
        <h3 class="text-center">{{ __('No category images have been added.') }}</h3>
    @endif
@endsection
