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

        .text-left {
            text-align: left !important;
        }
    </style>
</head>

<body>

<div class="row">
    <div class="col text-left">
        <img src="{{ asset('images/logos/logo-'.config('app.name').'-dark.png') }}" alt="Image not found" class="logo">
    </div>
    <div class="col text-right">
        <div>{{ str_replace(',', '', $company_details['line_1']) }}</div>
        <div>{{ str_replace(',', '', $company_details['line_2']) }}</div>
        <div>{{ str_replace(',', '', $company_details['line_3']) }}</div>
        <div>{{ str_replace(',', '', $company_details['line_4']) }}</div>
        <div>{{ str_replace(',', '', $company_details['line_5']) }}</div>
        <div>{{ str_replace(',', '', $company_details['postcode']) }}</div>

        <div class="mt-10">
            <div>{{ $company_details['telephone'] ? 'Tel: ' .  $company_details['telephone'] : '' }}</div>
            <div>{{ $company_details['email'] ? 'Email: ' .  $company_details['email'] : '' }}</div>
        </div>
    </div>
</div>

<h3 class="report-heading">@yield('report.title')</h3>

<div>
    <div>
        <b>Account Code:</b>{{ Auth::user()->customer_code }}
    </div>
    <div>
        <b>Customer:</b>{{ Auth::user()->customer->name }}
    </div>
</div>

@yield('content')

</body>
</html>
