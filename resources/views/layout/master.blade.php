<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ ucfirst(config('app.name')) . ' Online Portal'}} - @yield('page.title')</title>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
          integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

    @yield ('styles')
</head>

<body class="theme-{{ config('app.name') }}">

<div id="app" class="flex flex-col min-h-screen w-full">

    @include('cookieConsent::index')

    @include('layout.header')

    @include('layout.navigation')

    <div class="flex-grow container mx-auto sm:px-4 pt-6 pb-8">
        @if (session('temp_customer'))
            <div class="alert alert-info">
                <strong>{{ __('Notice!') }}</strong>
                {!! __('You are currently assuming the customer code: <span class="font-weight-bold">' . session('temp_customer') . '</span>.
                Your actual Customer Code is <span class="font-weight-bold">' . Auth::user()->customer_code . '</span>. Please <a href="' . route('customer.change.revert') . '">click here</a> to revert back to your default Customer Code.') !!}
            </div>
        @endif

        @yield('content')
    </div>

    @include('layout.footer')

</div>

{{--<div id="img-modal" class="img-modal">--}}
{{--    <span class="close">&times;</span>--}}
{{--    <img class="img-modal-content" id="product-image" alt="Image Coming Soon">--}}
{{--    <div id="caption"></div>--}}
{{--</div>--}}

{{--<div class="modal fade" id="loader" tabindex="-1" role="dialog" data-backdrop="static">--}}
{{--    <div class="modal-dialog modal-sm" role="document">--}}
{{--        <div class="modal-content">--}}
{{--            <div class="modal-body text-center">--}}
{{--                <div class="loader"></div>--}}
{{--                <div class="loader-txt">--}}
{{--                    <p></p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>

@yield('scripts')

</body>
</html>
