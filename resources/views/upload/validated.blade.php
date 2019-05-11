@extends('layout.master')

@section('page.title', 'Order Upload Validation')

@section('content')
    <h1 class="page-title">{{ __('Upload An Order (Validation)') }}</h1>

    <div class="card card-body">
        @include('layout.alerts')

        <p>{{ __('Your order has been validated, please check it over and click the "Add order to basket" button below to finish.') }}</p>

        @if ($order['errors'] > 0)
            <div class="alert alert-danger">
                <strong>{{ $order['errors'] . __(' Errors Found!') }}</strong> {{ __('Lines in red will not be added to your basket.') }}
            </div>
        @endif

        @if ($order['warnings'] > 0)
            <div class="alert alert-warning">
                <strong>{{ $order['warnings'] . __(' Warnings Found!') }}</strong> {{ __('Lines in yellow will be added to your basket,
                but have a warning attached, please check the warning messages below.') }}
            </div>
        @endif

        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
            <tr>
                <th>{{ __('Product') }}</th>
                <th>{{ __('Quantity') }}</th>
                <th class="text-right">{{ __('Status') }}</th>
                <th class="text-right">{{ __('Passed Price (Net)') }}</th>
                <th class="text-right">{{ __('Actual Price (Net)') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($order as $line)
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

                        <td class="text-right {{ $line['price_match_error'] ? 'bg-info' : '' }}">{{ $line['passed_price'] ? $line['passed_price'] : '' }}</td>

                        <td class="text-right {{ $line['price_match_error'] ? 'bg-info' : '' }}">{{ $line['price'] ? $line['price'] : '' }}</td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="row mt-3">
        <div class="col">
            <a href="{{ route('upload') }}">
                <button class="btn btn-primary">{{ __('Back') }}</button>
            </a>
        </div>
        <div class="col text-right">
            <a href="{{ route('upload-completed') }}">
                <button class="btn btn-blue">{{ __('Add Order To Basket') }}</button>
            </a>
        </div>
    </div>
@endsection