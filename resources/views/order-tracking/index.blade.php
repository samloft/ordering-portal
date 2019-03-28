@extends('layout.master')

@section('page.title', 'Order Tracking')

@section('content')
    <h1 class="page-title">{{ __('Order Tracking') }}</h1>

    <div class="row">
        <div class="col-lg-4 d-flex align-items-stretch">
            <div class="card card-body">
                <h2 class="section-title">{{ __('Search Orders') }}</h2>

                <form method="get" action="{{ route('order-tracking') }}">

                    <div class="form-group">
                        <label>{{ __('Order Number') }}</label>
                        <input name="order_number" class="form-control" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label>{{ __('Order Reference') }}</label>
                        <input name="order_ref" class="form-control" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label>{{ __('Order Status') }}</label>
                        <select name="status" class="form-control">
                            <option value=""></option>
                            <option value="In Progress">{{ __('In Progress') }}</option>
                            <option value="Despatched">{{ __('Despatched') }}</option>
                            <option value="Invoiced">{{ __('Invoiced') }}</option>
                            <option value="Cancelled">{{ __('Cancelled') }}</option>
                        </select>
                    </div>

                    <label>{{ __('Date Range') }}</label>

                    <div class="row mb-1">
                        <div class="col">
                            <label>{{ __('From') }}</label>
                        </div>
                        <div class="col-lg-8">
                            <input name="date_from" class="form-control form-date" autocomplete="off" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label>{{ __('To') }}</label>
                        </div>
                        <div class="col-lg-8">
                            <input name="date_to" class="form-control form-date" autocomplete="off" readonly>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-blue btn-block">{{ __('Search Orders') }}</button>

                </form>
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
                        <tr class="clickable"
                            onclick="window.location = '{{ route('order-tracking.show', [encodeUrl(trim($order->order_no))]) }}';">
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

@section('scripts')
    <script>
        $(function () {
            $('input[name="date_from"]').datepicker({
                dateFormat: 'dd/mm/yy'
            });

            $('input[name="date_to"]').datepicker({
                dateFormat: 'dd/mm/yy'
            });
        });
    </script>
@endsection