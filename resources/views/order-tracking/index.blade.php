@extends('layout.master')

@section('page.title', 'Order Tracking')

@section('content')

    <div class="w-full mb-5 text-center">
        <h2 class="font-semibold tracking-widest">{{ __('Order Tracking') }}</h2>
        <p class="font-thin">
            {{ __('Check the current status of your orders') }}
        </p>
    </div>

    <div class="bg-white rounded-lg shadow p-4">

        <form method="get" action="{{ route('order-tracking') }}">
            <label for="keyword">Keyword</label>
            <input id="keyword" class="bg-gray-100" name="keyword" placeholder="E.G Order number or order reference" value="{{ request('keyword') }}">

            <div class="flex mt-3 mb-3">

                <div class="w-1/3 mr-2">
                    <label for="start-date">From Date</label>
                    <date-picker input_name="start_date" old_value="{{ request('start_date') }}"></date-picker>
                </div>

                <div class="w-1/3 mr-2">
                    <label for="end-date">To Date</label>
                    <date-picker input_name="end_date" old_value="{{ request('end_date') }}"></date-picker>
                </div>

                <div class="w-1/3 relative">
                    <label for="status">Status</label>
                    <select id="status" class="bg-gray-100" name="status">
                        <option value="" {{ request('status') === '' ? 'selected' : '' }}>Any</option>
                        <option value="In Progress" {{ request('status') === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="Despatched"{{ request('status') === 'Despatched' ? 'selected' : '' }}>Despatched</option>
                        <option value="Invoiced"{{ request('status') === 'Invoiced' ? 'selected' : '' }}>Invoiced</option>
                        <option value="Cancelled"{{ request('status') === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <div
                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700 pt-6">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                        </svg>
                    </div>
                </div>

            </div>

            <div class="text-center mt-6">
                <a href="{{ route('order-tracking') }}">
                    <button type="button" class="button button-danger w-40">{{ __('Reset') }}</button>
                </a>
                <button class="button button-primary w-40">{{ __('Search') }}</button>
            </div>
        </form>
    </div>

    <h2 class="font-semibold tracking-widest mt-3 mb-3">{{ __('Search Results') }}</h2>

    @if(!$orders->isEmpty())
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th>{{ __('Order Number') }}</th>
                <th>{{ __('Reference') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Ordered') }}</th>
                <th class="text-right">{{ __('Value') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr class="cursor-pointer hover:bg-gray-200"
                    onclick="window.location = '{{ route('order-tracking.show', [encodeUrl(trim($order->order_no))]) }}';">
                    <td>{{ $order->order_no }}</td>
                    <td>{{ $order->customer_order_no }}</td>
                    <td><span
                            class="badge badge-{{ str_replace(' ', '_', $order->status) }}">{{ $order->status }}</span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($order->date_received)->format('d/m/Y') }}</td>
                    <td class="text-right">{{ currency($order->value, 2) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <h2 class="font-semibold tracking-widest">{{ __('No orders to display') }}</h2>
        </div>
    @endif

    <div class="mt-4">
        {{ $orders->appends($_GET)->links('layout.pagination') }}
    </div>
@endsection
