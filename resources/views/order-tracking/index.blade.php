@extends('layout.master')

@section('page.title', 'Order Tracking')

@section('content')
    <h1 class="page-title">{{ __('Order Tracking') }}</h1>

    <div class="row">
        <div class="col-lg-4 d-flex align-items-stretch">
            <div class="card card-body">
                <h2 class="section-title">{{ __('Search Orders') }}</h2>

                <div class="form-group">
                    <label>{{ __('Order Number') }}</label>
                    <input class="form-control">
                </div>

                <div class="form-group">
                    <label>{{ __('Order Reference') }}</label>
                    <input class="form-control">
                </div>

                <div class="form-group">
                    <label>{{ __('Order Status') }}</label>
                    <select class="form-control">
                        <option value=""></option>
                    </select>
                </div>

                <label>{{ __('Date Range') }}</label>

                <button class="btn btn-blue btn-block">{{ __('Search Orders') }}</button>
            </div>
        </div>
        <div class="col-lg-8 d-flex align-items-stretch">
            <div class="card card-body">
                <h2 class="section-title">{{ __('Search Results') }}</h2>

                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">{{ __('Order Number') }}</th>
                        <th scope="col">{{ __('Order Reference') }}</th>
                        <th scope="col">{{ __('Order Status') }}</th>
                        <th scope="col">{{ __('Order Date') }}</th>
                        <th scope="col" class="text-right">{{ __('Order Total') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr class="clickable" onclick="window.location = '{{ route('order-tracking.show', [trim($order->order_no)]) }}';">
                            <td>{{ $order->order_no }}</td>
                            <td>{{ $order->customer_order_no }}</td>
                            <td>{{ $order->status }}</td>
                            <td>{{ \Carbon\Carbon::parse($order->date_received)->format('d/m/Y') }}</td>
                            <td class="text-right">{{ currency($order->value, 2) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $orders->appends($_GET)->links('layout.pagination') }}
            </div>
        </div>
    </div>
@endsection