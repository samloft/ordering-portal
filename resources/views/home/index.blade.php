@extends('layout.master')

@section('page.title', 'Home')

@section('content')
    <div class="flex">
            @include('home.adverts')
        <div class="w-3/4">
            @include('home.categories')
        </div>
    </div>


    {{--    <div class="text-center">--}}
    {{--        Top Sellers and other stuff here????--}}
    {{--    </div>--}}

    {{--    <div class="flex justify-between">--}}
    {{--        <div></div>--}}
    {{--        <div class="w-1/3">--}}
    {{--            <div class="bg-white rounded-lg shadow p-4 overflow-auto" style="height: 800px;">--}}
    {{--                @foreach($popular_products as $popular_product)--}}
    {{--                    <div class="flex items-center mb-5">--}}
    {{--                        <img class="w-32 mr-3"--}}
    {{--                                          alt="{{ $popular_product->product }}"--}}
    {{--                                          src="https://scolmoreonline.com/product_images/{{ rtrim($popular_product->product) }}.png">--}}

    {{--                        <div class="w-2/3">--}}
    {{--                            <h2 class="font-semibold text-lg text-primary">--}}
    {{--                                <a href="/products/view/{{ encodeUrl($popular_product->product) }}"--}}
    {{--                                   class="hover:underline">{{ $popular_product->product }}</a>--}}
    {{--                            </h2>--}}
    {{--                            <small class="text-gray-500">{{ $popular_product->long_description }}</small>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                @endforeach--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}



    {{--    <div class="row">--}}
    {{--        @if(count($links['adverts']) > 0)--}}
    {{--            @include('home.adverts')--}}
    {{--        @endif--}}

    {{--        <div class="col">--}}
    {{--            @include('home.categories')--}}
    {{--        </div>--}}
    {{--    </div>--}}
@endsection
