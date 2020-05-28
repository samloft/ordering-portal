<html lang="en">
<head>
    <title>@yield('reports.title')</title>

    <style>
        @import url('https://rsms.me/inter/inter.css');

        html {
            font-family: 'Inter', sans-serif;
        }

        @supports (font-variation-settings: normal) {
            html {
                font-family: 'Inter var', sans-serif;
            }
        }

        body {
            font-size: 10px;
            color: #4a4a4d;
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

        b {
            color: rgb(37, 47, 63);
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

        h3.report-heading {
            font-weight: 900;
            font-size: 14px;
            text-align: center;
            color: rgb(37, 47, 63);
            text-decoration: underline;
            text-transform: uppercase;
            letter-spacing: .3em;
        }

        .small-print {
            font-size: 9px;
            margin-bottom: 5px;
        }

        .text-right {
            text-align: right !important;
        }

        .text-left {
            text-align: left !important;
        }

        table {
            border-collapse: separate;
            border-spacing: 0;
            color: #4a4a4d;
            width: 100%;
        }

        th, td {
            padding: 5px;
            vertical-align: middle;
        }

        thead {
            background: rgb(37, 47, 63);
            color: #fff;
            font-size: 8px;
            text-transform: uppercase;
            text-align: left !important;
        }

        th:first-child {
            border-top-left-radius: 5px;
        }

        th:last-child {
            border-top-right-radius: 5px;
        }

        tbody {
            font-size: 8px;
        }

        tbody tr:nth-child(even) {
            background: #f0f0f2;
        }

        td {
            border-bottom: 1px solid #cecfd5;
            border-right: 1px solid #cecfd5;
        }

        td:first-child {
            border-left: 1px solid #cecfd5;
        }

        tfoot {
            text-align: right;
            font-size: 8px;
        }

        tfoot th {
            border-right: 1px solid #cecfd5;
        }

        tfoot td {
            border-left: none !important;
        }

        tfoot tr:last-child td:last-child {
            background: #f0f0f2;
            color: rgb(37, 47, 63);
            font-weight: bold;
        }

        .border-0 {
            border: none !important;
        }

        .font-thin {
            font-weight: 200 !important;
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
