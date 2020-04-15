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

    <p><b>Outstanding Items</b></p>

    <div class="small-print">
        The table below lists all items you have ordered that are on back order, please note there is a delay of up to 24 hours in the accuracy of our data.
    </div>

    <table>
        <thead>
        <tr>
            <th>Order No.</th>
            <th>Product Code</th>
            <th>Description</th>
            <th>Ordered</th>
            <th>Outstanding</th>
            <th>Next Expecting</th>
        </tr>
        </thead>
        <tbody>
        @foreach($back_orders as $back_order)
            <tr>
                <td>{{ $back_order->order_number }}</td>
                <td>{{ $back_order->product }}</td>
                <td>{{ $back_order->description }}</td>
                <td>{{ \Carbon\Carbon::parse($back_order->date_received)->format('d-m-Y') }}</td>
                <td class="text-right">{{ $back_order->quantity }}</td>
                <td>{{ $back_order->due_date ? \Carbon\Carbon::parse($back_order->due_date)->format('d-m-Y') : 'Unknown' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
