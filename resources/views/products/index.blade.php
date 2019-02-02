@extends('layout.master')

@section('page.title', 'Products')

@section('content')
    <div class="row">
        @include('products.sidebar')

        <div class="col">
            @if ($categories['level_1'])
                <div class="d-flex flex-wrap product-category-images">
                    @foreach($sub_category_list as $key => $category)
                        <div class="category w-20">
                            <a href="/products/{{ ($categories['level_1'] <> '' ? $categories['level_1'] . '/' : '') . ($categories['level_2'] <> '' ? $categories['level_2'] . '/' : '') . $category['slug'] }}">
                                {{--<img src="https://via.placeholder.com/145">--}}
                                <div class="sub-category-image">
                                    <img src="{{ $category['image'] ? $category['image'] : 'https://scolmoreonline.com/assets/images/no-image.png' }}">
                                </div>
                                <span class="text-center">{{ $key }}</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="d-flex flex-wrap">
                    <div class="w-20">
                        <img class="img-fluid" src="https://scolmoreonline.com/assets/images/deco-plus.jpg">
                    </div>
                    <div class="w-20">
                        <img class="img-fluid" src="https://scolmoreonline.com/assets/images/deco-plus.jpg">
                    </div>
                    <div class="w-20">
                        <img class="img-fluid" src="https://scolmoreonline.com/assets/images/deco-plus.jpg">
                    </div>
                    <div class="w-20">
                        <img class="img-fluid" src="https://scolmoreonline.com/assets/images/deco-plus.jpg">
                    </div>
                    <div class="w-20">
                        <img class="img-fluid" src="https://scolmoreonline.com/assets/images/deco-plus.jpg">
                    </div>
                    <div class="w-20">
                        <img class="img-fluid" src="https://scolmoreonline.com/assets/images/deco-plus.jpg">
                    </div>
                    <div class="w-20">
                        <img class="img-fluid" src="https://scolmoreonline.com/assets/images/deco-plus.jpg">
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
