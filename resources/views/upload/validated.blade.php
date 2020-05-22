@extends('layout.master')

@section('page.title', 'Order Upload Validation')

@section('content')
    <div class="w-full mb-5 text-center">
        <h2 class="font-semibold tracking-widest">Order Validation</h2>
        <p class="font-thin">
            Your order has been validated, please check it over and click the "Add order to basket" button below to
            finish.
        </p>
    </div>

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
                        <p class="alert-title">{{ $product_lines['errors'] }} Errors Found!</p>
                        <p class="alert-text">Lines in red will not be added to your basket.</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="table-container overflow-scroll">
            <table>
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th class="text-right">Status</th>
                    @if($product_lines['prices_passed'])
                        <th class="text-right">Passed Price (Net)</th>
                        <th class="text-right">Actual Price (Net)</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach ($product_lines['lines'] as $line)
                    @if ($line['product'])
                        <tr class="{{ $line['validation']['error'] ? 'bg-red-100' : '' }}">

                            <td class="{{ $line['validation']['error'] ? 'bg-danger' : ($line['validation']['warning'] ?? 'bg-warning') }}">
                                {{ $line['product'] }}
                            </td>

                            <td class="text-right {{ $line['validation']['error'] ? 'bg-danger' : ($line['validation']['warning'] ?? 'bg-warning') }}">
                                {{ $line['quantity'] }}
                            </td>

                            <td class="text-right {{ $line['validation']['error'] ? 'bg-danger' : ($line['validation']['warning'] ?? 'bg-warning') }}">
                                @if ($line['validation']['error'])
                                    <span class="badge badge-danger"><i class="fas fa-times-circle"></i> {{ $line['validation']['error'] }}</span>
                                @elseif ($line['validation']['warning'])
                                    <span class="badge badge-warning"><i class="fas fa-exclamation-triangle"></i> {{ $line['validation']['warning'] }}</span>
                                @else
                                    <span class="badge badge-success"><i class="text-success fas fa-check-circle"></i> Valid</span>
                                @endif
                            </td>

                            @if($product_lines['prices_passed'])
                                <td class="text-right">
                                    <span class="badge badge-{{ $line['price_match_error'] ? 'danger' : 'success' }}">
                                    {{ $line['passed_price'] ?: '' }}
                                    </span>
                                </td>

                                <td class="text-right">{{ $line['price'] ?: '' }}</td>
                            @endif
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-right mt-5">
        <a href="{{ route('upload-completed') }}">
            <button class="button button-primary">Add Order To Basket</button>
        </a>
    </div>
@endsection
