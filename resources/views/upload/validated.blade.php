@extends('layout.master')

@section('page.title', 'Order Upload Validation')

@section('content')
    <h1 class="page-title">{{ __('Upload An Order (Validation)') }}</h1>

    <div class="card card-body">
        @if ($order['errors'] > 0)
            <div class="alert alert-danger">
                <strong>{{ $order['errors'] }} Errors Found!</strong> Lines in red will not be added to your basket.
            </div>
        @endif

        @if ($order['warnings'] > 0)
            <div class="alert alert-warning">
                <strong>{{ $order['warnings'] }} Warnings Found!</strong> Lines in yellow will be added to your basket,
                but have a warning attached, please check the warning messages below.
            </div>
        @endif

        <table class="table table-striped">
            <thead class="thead-dark">
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th class="text-right">Status</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($order['products'] as $line)
                <tr class="{{ $line['validation'] }}">
                    <td>{{ $line['product']['code'] }}</td>
                    <td>{{ $line['quantity']['amount'] }}</td>
                    <td class="text-right">
                        @if (!$line['product']['valid'])
                            {!! $line['product']['message'] !!}
                        @elseif ($line['quantity']['message'])
                            {!! $line['quantity']['message'] !!}
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="row mt-3">
        <div class="col">
            <button class="btn btn-primary">Back</button>
        </div>
        <div class="col text-right">
            <button class="btn btn-blue">Add Order To Basket</button>
        </div>
    </div>
@endsection