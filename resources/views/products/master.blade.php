@extends('layout.master')

@section('content')
    <div class="xl:flex">
        @include('products.sidebar')

        <div class="xl:w-3/4">
            @if ($categories['level_1'])
                <div class="font-thin text-gray-700 mb-3 flex items-center text-xs md:text-sm lg:text-base">
                    @if ($categories['level_1'] === 'search')
                        <strong>Search</strong>
                        <svg class="mx-2 fill-current" width="14" height="24" viewBox="0 0 24 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 5L16 12L9 19" stroke-width="2" stroke-linecap="round"
                                  stroke-linejoin="round"/>
                        </svg>
                        {{ $categories['query'] }}
                    @else
                        @if($categories['level_1'])
                            <a class="hover:underline"
                               href="/products/{{ $categories['level_1'] }}">{{ $categories['level_1'] }}</a>
                        @endif

                        @if($categories['level_2'])
                            <svg class="mx-2 fill-current" width="14" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 5L16 12L9 19" stroke-width="2" stroke-linecap="round"
                                      stroke-linejoin="round"/>
                            </svg>

                            <a class="hover:underline"
                               href="/products/{{ $categories['level_1'] }}/{{ $categories['level_2'] }}">{{ $categories['level_2'] }}</a>
                        @endif

                        @if($categories['level_3'])
                            <svg class="mx-2 fill-current" width="14" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 5L16 12L9 19" stroke-width="2" stroke-linecap="round"
                                      stroke-linejoin="round"/>
                            </svg>

                            {{ $categories['level_3'] }}
                        @endif
                    @endif
                </div>
            @endif

            @include('layout.alerts')

            @yield('product.content')
        </div>
    </div>
@endsection
