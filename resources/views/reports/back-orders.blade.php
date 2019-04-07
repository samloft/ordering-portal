<html lang="en">
<head>
    <title>{{ __('Back Orders') }}</title>

    @include('reports.style')
</head>
<body>
Hi

<table>
    <thead>
    <tr>
        <th>{{ __('Order No.') }}</th>
        <th>{{ __('Product Code') }}</th>
        <th>{{ __('Description') }}</th>
        <th>{{ __('Ordered') }}</th>
        <th>{{ __('Outstanding') }}</th>
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
</body>
</html>
