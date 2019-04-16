<html lang="en">
<head>
    <title>@yield('reports.title')</title>

    <style>
        th, td {
            padding-left: 5px;
            padding-right: 5px;
        }
    </style>
</head>

<body style="font-family: Arial, serif; font-size: 12px;">

<div style="width: 100%;">
    <div style="display: inline-block; width: 50%;">
        <img src="{{ asset('images/logo.png') }}" alt="Image not found"
             style="background-color: #b9c5d3; padding: 20px; max-height: 55px;">
    </div>
    <div style="text-align: right; display: inline-block; width: 50%;">
        <div>{{ env('ADDRESS_LINE_1') }}</div>
        <div>{{ env('ADDRESS_LINE_2') }}</div>
        <div>{{ env('ADDRESS_LINE_3') }}</div>
        <div>{{ env('ADDRESS_LINE_4') }}</div>
        <div>{{ env('ADDRESS_LINE_5') }}</div>
        <div>{{ env('ADDRESS_POSTCODE') }}</div>

        <div style="margin-top: 10px;">
            <div>{{ env('ADDRESS_TELEPHONE') ? 'Tel: ' .  env('ADDRESS_TELEPHONE') : '' }}</div>
            <div>{{ env('ADDRESS_FAX') ? 'Fax: ' .  env('ADDRESS_FAX') : '' }}</div>
        </div>
    </div>
</div>

<h3 style="font-weight: 900; font-size: 18px; text-align: center;">@yield('report.title')</h3>

<div>
    <p>
        <b>{{ __('Account Code: ') }}</b>{{ Auth::user()->customer_code }}
    </p>
    <p>
        <b>{{ __('Customer: ') }}</b>{{ Auth::user()->customer->customer_name }}
    </p>
</div>

@yield('content')

</body>
</html>
