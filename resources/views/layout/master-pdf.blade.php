<html lang="en">
<head>
    <title>@yield('reports.title')</title>

    <style>
        body {
            font-family: serif, Arial;
            font-size: 12px;
        }

        .row {
            display: block;
            width: 100%;
            position: relative;
        }

        .row::after {
            content: "";
            clear: both;
            display: table;
        }

        .col-33 {
            margin-right: 10px;
            width: 33.33%;
            display: inline-block;
            float: left;
        }

        .col-66 {
            margin-right: 10px;
            width: 66.66%;
            display: inline-block;
            float: left;
        }

        .col {
            text-align: left;
            display: inline-block;
            width: 50%;
            float: left;
            position: relative;
        }

        col::after {
            content: "";
            clear: both;
            display: table;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .mb-10 {
            margin-top: 10px;
        }

        .mb-20 {
            margin-bottom: 20px;
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

        td {
            font-size: 10px;
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

        .clear-fix::after {
            content: "";
            clear: both;
            display: table;
        }

        ul > div {
            display: inline-block;
        }

        li {
            list-style-type: none;
        }
    </style>
</head>

<body>

<div class="row">
    <div class="col text-left">
        <img src="{{ asset('images/logos/logo-'.config('app.name').'-dark.png') }}" alt="Image not found" class="logo">
    </div>
    <div class="col text-right">
        {{ str_replace(',', '', $company_details['line_1']) }}<br>
        {{ str_replace(',', '', $company_details['line_2']) }}<br>
        {{ str_replace(',', '', $company_details['line_3']) }}<br>
        {{ str_replace(',', '', $company_details['line_4']) }}<br>
        {{ str_replace(',', '', $company_details['line_5']) }}<br>
        {{ str_replace(',', '', $company_details['postcode']) }}<br>

        <div class="mt-10">
            {{ $company_details['telephone'] ? 'Tel: ' .  $company_details['telephone'] : '' }}<br>
            {{ $company_details['email'] ? 'Email: ' .  $company_details['email'] : '' }}
        </div>
    </div>
</div>

<h3 class="report-heading">@yield('report.title')</h3>

@yield('content')

</body>
</html>
