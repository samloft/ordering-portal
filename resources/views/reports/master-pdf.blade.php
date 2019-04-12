<html lang="en">
<head>
    <title>@yield('reports.title')</title>

    <style>
        body {
            font-family: Arial, serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            padding-top: 10px;
            padding-bottom: 10px;
        }

        table td {
            padding-top: 5px;
            padding-bottom: 5px;
        }

        table, th, td {
            border: 0.5px solid rgb(0, 0, 0);
        }

        th, td {
            padding-left: 5px;
            padding-right: 5px;
        }

        table th.description {
            width: 270px;
        }

        table th.outstanding {
            width: 50px;
        }

        .table-heading {
            text-align: center;
            font-weight: 900;
        }

        .small-print {
            font-size: 10px;
            margin-bottom: 5px;
        }

        .text-right {
            text-align: right !important;
        }

        .row {
            width: 100%;
        }

        .col {
            display: inline-block;
            width: 50%;
        }

        .contact-numbers {
            margin-top: 10px;
        }

        /*.address span {*/
        /*    display: block;*/
        /*}*/

        h3.title {
            font-weight: 900;
            font-size: 18px;
            text-align: center;
        }

        /*.details span.heading {*/
        /*    float: left;*/
        /*    font-weight: 900;*/
        /*    width: 100px !important;*/
        /*}*/

        img.logo {
            background-color: #b9c5d3;
            padding: 20px;
            max-height: 55px;
        }
    </style>
</head>
<body>

<div class="header row">
    <div class="col">
{{--        <img class="logo" src="{{ asset('images/logo.png') }}" alt="Image not found">--}}
        <img class="logo" src="https://scolmoreonline.com/assets/images/scolmore_small.png" alt="Image not found">
    </div>
    <div class="col text-right address">
        <div>{{ env('ADDRESS_LINE_1') }}</div>
        <div>{{ env('ADDRESS_LINE_2') }}</div>
        <div>{{ env('ADDRESS_LINE_3') }}</div>
        <div>{{ env('ADDRESS_LINE_4') }}</div>
        <div>{{ env('ADDRESS_LINE_5') }}</div>
        <div>{{ env('ADDRESS_POSTCODE') }}</div>

        <div class="contact-numbers">
            <div>{{ env('ADDRESS_TELEPHONE') ? 'Tel: ' .  env('ADDRESS_TELEPHONE') : '' }}</div>
            <div>{{ env('ADDRESS_FAX') ? 'Fax: ' .  env('ADDRESS_FAX') : '' }}</div>
        </div>
    </div>
</div>

<h3 class="title">@yield('report.title')</h3>

<div class="details">
    <p>
        <strong>{{ __('Account Code: ') }}</strong>{{ Auth::user()->customer_code }}
    </p>
    <p>
        <strong>{{ __('Customer: ') }}</strong>{{ Auth::user()->customer->customer_name }}
    </p>
</div>

@yield('content')

</body>
</html>
