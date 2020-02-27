@extends('layout.master-pdf')

@section('report.title', 'Back Order Items')

@section('content')
    <div>
        <div>
            <b>Account Code:</b> {{ Auth::user()->customer->code }}
        </div>
        <div>
            <b>Customer:</b> {{ Auth::user()->customer->name }}
        </div>
    </div>

    <p class="table-heading">{{ __('Outstanding Items') }}</p>

    <div class="small-print">
        {{ __('The table below lists all items you have ordered that are on back order, please note there is a delay of up to 24 hours in the accuracy of our data.') }}
    </div>

    <table>
        <thead>
        <tr>
            <th>{{ __('Order No.') }}</th>
            <th>{{ __('Product Code') }}</th>
            <th class="description">{{ __('Description') }}</th>
            <th>{{ __('Ordered') }}</th>
            <th class="outstanding">{{ __('Outstanding') }}</th>
            <th>{{ __('Next Expecting') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($back_orders as $back_order)
            <tr>
                <td>{{ $back_order->order_no }}</td>
                <td>{{ $back_order->product }}</td>
                <td>{{ $back_order->long_description }}</td>
                <td>{{ \Carbon\Carbon::parse($back_order->date_received)->format('d-m-Y') }}</td>
                <td class="text-right">{{ $back_order->line_qty }}</td>
                <td>{{ $back_order->due_date ? \Carbon\Carbon::parse($back_order->due_date)->format('d-m-Y') : 'Unknown' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
