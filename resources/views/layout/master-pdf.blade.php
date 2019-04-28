<html lang="en">
<head>
    <title>@yield('reports.title')</title>

    <style>
        body {
            font-family: Arial, serif;
            font-size: 12px;
        }

        .row {
            width: 100%;
        }

        .col {
            text-align: right;
            display: inline-block;
            width: 50%;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .logo {
            background-color: #b9c5d3;
            padding: 20px;
            max-height: 55px;
        }

        table {
            width: 100%;
            border: 1px solid #000000;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000000;
            padding-left: 5px;
            padding-right: 5px;
        }

        h3.report-heading {
            font-weight: 900;
            font-size: 18px;
            text-align: center;
        }

        .table-heading {
            text-align: center;
            font-weight: 900;
        }

        .small-print {
            font-size: 12px;
            margin-bottom: 5px;
        }

        .text-right {
            text-align: right !important;
        }
    </style>
</head>

<body>

<div class="row">
    <div class="col">
        <img src="{{ asset('images/logo.png') }}" alt="Image not found" class="logo">
    </div>
    <div class="col text-right">
        <div>{{ env('ADDRESS_LINE_1') }}</div>
        <div>{{ env('ADDRESS_LINE_2') }}</div>
        <div>{{ env('ADDRESS_LINE_3') }}</div>
        <div>{{ env('ADDRESS_LINE_4') }}</div>
        <div>{{ env('ADDRESS_LINE_5') }}</div>
        <div>{{ env('ADDRESS_POSTCODE') }}</div>

        <div class="mt-10">
            <div>{{ env('ADDRESS_TELEPHONE') ? 'Tel: ' .  env('ADDRESS_TELEPHONE') : '' }}</div>
            <div>{{ env('ADDRESS_FAX') ? 'Fax: ' .  env('ADDRESS_FAX') : '' }}</div>
        </div>
    </div>
</div>

<h3 class="report-heading">@yield('report.title')</h3>

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
