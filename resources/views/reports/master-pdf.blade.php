<html lang="en">
<head>
    <title>@yield('reports.title')</title>

{{--    <style>--}}
{{--        body {--}}
{{--            font-family: Arial, serif;--}}
{{--            font-size: 12px;--}}
{{--        }--}}

{{--        table {--}}
{{--            width: 100%;--}}
{{--            border-collapse: collapse;--}}
{{--        }--}}

{{--        table th {--}}
{{--            padding-top: 10px;--}}
{{--            padding-bottom: 10px;--}}
{{--        }--}}

{{--        table td {--}}
{{--            padding-top: 5px;--}}
{{--            padding-bottom: 5px;--}}
{{--        }--}}

{{--        table, th, td {--}}
{{--            border: 0.5px solid rgb(0, 0, 0);--}}
{{--        }--}}
<style>
        th, td {
            padding-left: 5px;
            padding-right: 5px;
        }
        </style>

{{--        table th.description {--}}
{{--            width: 270px;--}}
{{--        }--}}

{{--        table th.outstanding {--}}
{{--            width: 50px;--}}
{{--        }--}}

{{--        .table-heading {--}}
{{--            text-align: center;--}}
{{--            font-weight: 900;--}}
{{--        }--}}

{{--        .small-print {--}}
{{--            font-size: 10px;--}}
{{--            margin-bottom: 5px;--}}
{{--        }--}}

{{--        .text-right {--}}
{{--            text-align: right !important;--}}
{{--        }--}}

{{--        .row {--}}
{{--            width: 100%;--}}
{{--        }--}}

{{--        .col {--}}
{{--            display: inline-block;--}}
{{--            width: 50%;--}}
{{--        }--}}

{{--        .contact-numbers {--}}
{{--            margin-top: 10px;--}}
{{--        }--}}

{{--        /*.address span {*/--}}
{{--        /*    display: block;*/--}}
{{--        /*}*/--}}

{{--        h3.title {--}}
{{--            font-weight: 900;--}}
{{--            font-size: 18px;--}}
{{--            text-align: center;--}}
{{--        }--}}

{{--        /*.details span.heading {*/--}}
{{--        /*    float: left;*/--}}
{{--        /*    font-weight: 900;*/--}}
{{--        /*    width: 100px !important;*/--}}
{{--        /*}*/--}}

{{--        img.logo {--}}
{{--            background-color: #b9c5d3;--}}
{{--            padding: 20px;--}}
{{--            max-height: 55px;--}}
{{--        }--}}
{{--    </style>--}}
</head>
<body style="font-family: Arial, serif; font-size: 12px;">

<div style="width: 100%;">
    <div style="display: inline-block; width: 50%;">
        <img src="https://scolmoreonline.com/assets/images/scolmore_small.png" alt="Image not found" style="background-color: #b9c5d3; padding: 20px; max-height: 55px;">
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
