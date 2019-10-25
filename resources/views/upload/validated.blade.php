@extends('layout.master')

@section('page.title', 'Order Upload Validation')

@section('content')
    <h1 class="text-center font-semi-bold text-2xl mb-3">
        {{ __('Order Validation') }}
        <span
            class="block text-lg font-thin">{{ __('Your order has been validated, please check it over and click the "Add order to basket" button below to finish.') }}</span>
    </h1>

    <div class="bg-white rounded shadow-md p-6">
        @include('layout.alerts')

        @if ($product_lines['errors'] > 0)
            <div class="alert alert-danger" role="alert">
                <div class="alert-body">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="alert-icon">
                        <circle cx="12" cy="12" r="10" class="primary"></circle>
                        <path class="secondary"
                              d="M13.41 12l2.83 2.83a1 1 0 0 1-1.41 1.41L12 13.41l-2.83 2.83a1 1 0 1 1-1.41-1.41L10.59 12 7.76 9.17a1 1 0 0 1 1.41-1.41L12 10.59l2.83-2.83a1 1 0 0 1 1.41 1.41L13.41 12z"></path>
                    </svg>
                    <div>
                        <p class="alert-title">{{ $product_lines['errors'] . __(' Errors Found!') }}</p>
                        <p class="alert-text">{{ __('Lines in red will not be added to your basket.') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <table>
            <thead>
            <tr>
                <th>{{ __('Product') }}</th>
                <th>{{ __('Quantity') }}</th>
                <th class="text-right">{{ __('Status') }}</th>
                @if($product_lines['prices_passed'])
                    <th class="text-right">{{ __('Passed Price (Net)') }}</th>
                    <th class="text-right">{{ __('Actual Price (Net)') }}</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach ($product_lines as $line)
                @if ($line['product'])
                    <tr>

                        <td class="{{ $line['validation']['error'] ? 'bg-danger' : ($line['validation']['warning'] ? 'bg-warning' : '') }}">
                            {{ $line['product'] }}
                        </td>

                        <td class="text-right {{ $line['validation']['error'] ? 'bg-danger' : ($line['validation']['warning'] ? 'bg-warning' : '') }}">
                            {{ $line['quantity'] }}
                        </td>

                        <td class="text-right {{ $line['validation']['error'] ? 'bg-danger' : ($line['validation']['warning'] ? 'bg-warning' : '') }}">
                            @if ($line['validation']['error'])
                                {{ $line['validation']['error'] }} <i class="fas fa-times-circle"></i>
                            @elseif ($line['validation']['warning'])
                                {{ $line['validation']['warning'] }} <i class="fas fa-exclamation-triangle"></i>
                            @else
                                Valid <i class="text-success fas fa-check-circle"></i>
                            @endif
                        </td>

                        @if($product_lines['prices_passed'])
                            <td class="text-right {{ $line['price_match_error'] ? 'bg-info' : '' }}">{{ $line['passed_price'] ?: '' }}</td>

                            <td class="text-right {{ $line['price_match_error'] ? 'bg-info' : '' }}">{{ $line['price'] ?: '' }}</td>
                        @endif
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>

        <div class="text-right mt-5">
            <a href="{{ route('upload-completed') }}">
                <button class="button button-primary">{{ __('Add Order To Basket') }}</button>
            </a>
        </div>
    </div>
@endsection
