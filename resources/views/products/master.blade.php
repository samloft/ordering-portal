@extends('layout.master')

@section('content')
    <div class="flex">
        @include('products.sidebar')

        <div class="w-3/4">
            @if ($categories['level_1'])
                <div class="font-thin text-gray-700 mb-3">
                    @if ($categories['level_1'] === 'search')
                        <strong>{{ __('Search') }}</strong> <i class="fas fa-caret-right mx-2"></i> {{ $categories['query'] }}
                    @else
                        {{ $categories['level_1'] ?: '' }}
                        {!! $categories['level_2'] ? ' <i class="fas fa-caret-right mx-2"></i> ' . $categories['level_2'] : '' !!}
                        {!! $categories['level_3'] ? ' <i class="fas fa-caret-right mx-2"></i> ' . $categories['level_3'] : '' !!}
                    @endif
                </div>
            @endif

            @include('layout.alerts')

            @yield('product.content')
        </div>
    </div>
@endsection
