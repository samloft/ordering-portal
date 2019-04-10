<html lang="en">
<head>
    <title>{{ __('Back Orders') }}</title>

    @include('reports.style')
</head>
<body>

<div class="header row">
    <div class="col">
        <img class="logo" src="{{ asset('images/logo.png') }}" alt="Image not found">
    </div>
    <div class="col text-right address">
        <span>{{ env('ADDRESS_LINE_1') }}</span>
        <span>{{ env('ADDRESS_LINE_2') }}</span>
        <span>{{ env('ADDRESS_LINE_3') }}</span>
        <span>{{ env('ADDRESS_LINE_4') }}</span>
        <span>{{ env('ADDRESS_LINE_5') }}</span>
        <span>{{ env('ADDRESS_POSTCODE') }}</span>

        <div class="contact-numbers">
            <span>{{ env('ADDRESS_TELEPHONE') ? 'Tel: ' .  env('ADDRESS_TELEPHONE') : '' }}</span>
            <span>{{ env('ADDRESS_FAX') ? 'Fax: ' .  env('ADDRESS_FAX') : '' }}</span>
        </div>
    </div>
</div>

<h3 class="title">{{ __('Back Order Items') }}</h3>

<div class="details">
    <p>
        <span class="heading">{{ __('Account Code: ') }}</span>{{ Auth::user()->customer_code }}
    </p>
    <p>
        <span class="heading">{{ __('Customer: ') }}</span>{{ Auth::user()->customer->customer_name }}
    </p>
</div>

<p class="table-heading text-center">{{ __('Outstanding Items') }}</p>

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
</body>
</html>
