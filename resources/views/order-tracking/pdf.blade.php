@extends('layout.master-pdf')

@section('report.title', 'Order Details')

@section('content')
    <p class="table-heading">Order {{ $order->order_no }}</p>

{{--    <div class="small-print">--}}
{{--        {{ __('The table below lists all items you have ordered that are on back order, please note there is a delay of up to 24 hours in the accuracy of our data.') }}--}}
{{--    </div>--}}

    <table>
        <thead>
        <tr>
            <th>{{ __('Product Code') }}</th>
            <th class="description">{{ __('Description') }}</th>
{{--            <th>{{ __('Ordered') }}</th>--}}
{{--            <th class="outstanding">{{ __('Outstanding') }}</th>--}}
{{--            <th>{{ __('Next Expecting') }}</th>--}}
        </tr>
        </thead>
        <tbody>
        @foreach($order->lines as $line)
            <tr>
                <td>{{ $line->product }}</td>
                <td>{{ $line->long_description }}</td>
{{--                <td>{{ \Carbon\Carbon::parse($back_order->date_received)->format('d-m-Y') }}</td>--}}
{{--                <td class="text-right">{{ $back_order->line_qty }}</td>--}}
{{--                <td>{{ $back_order->due_date ? \Carbon\Carbon::parse($back_order->due_date)->format('d-m-Y') : 'Unknown' }}</td>--}}
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
