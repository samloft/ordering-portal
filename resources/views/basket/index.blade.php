@extends('layout.master')

@section('page.title', 'Basket')

@section('content')
    <div class="w-full mb-5 text-center">
        <h2 class="font-semibold tracking-widest">{{ __('Basket') }}</h2>
        <p class="font-thin">
            {{ __('View your basket.') }}
        </p>
    </div>

    @include('layout.alerts')

    <div class="flex items-start justify-end mb-5">
        <div class="w-8/12">
            <basket-table :products="{{ json_encode($basket, true) }}"></basket-table>
        </div>

        <div class="w-4/12 ml-10">
            <div class="bg-white rounded shadow-md p-6 text-center mb-5">
                <label class="font-medium">{{ __('Quick Buy') }}</label>
                <quick-buy></quick-buy>
            </div>

            <div class="bg-white rounded shadow-md p-6 mb-5">
                <basket-summary :summary="{{ json_encode($basket['summary'], true) }}"></basket-summary>

                <div class="mt-3 text-xs">
                    {{ __('*orders below £200 attract a £10 small order charge, unless you are collecting your order or paying a delivery charge.') }}
                </div>

                <a href="{{ route('checkout') }}">
                    <button class="flex justify-between button button-primary button-block mt-6 text-left">
                        {{ __('Checkout') }}
                        <span class="ml-auto">🛒</span>
                    </button>
                </a>
            </div>

            <div class="alert alert-info" role="alert">
                <div class="alert-body text-sm leading-none">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="alert-icon">
                        <path class="primary" d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20z"></path>
                        <path class="secondary"
                              d="M11 12a1 1 0 0 1 0-2h2a1 1 0 0 1 .96 1.27L12.33 17H13a1 1 0 0 1 0 2h-2a1 1 0 0 1-.96-1.27L11.67 12H11zm2-4a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"></path>
                    </svg>
                    <div>
                        <p class="alert-title">{{ __('Please Note:') }}</p>
                        <p class="alert-text">{{ __('Lines marked in red have a chance of going onto backorder.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
