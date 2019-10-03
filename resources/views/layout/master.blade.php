<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ ucfirst(config('app.name', 'Online Ordering')) . ' Online Ordering'}} - @yield('page.title')</title>

    <link rel="dns-prefetch" href="https://fonts.gstatic.com">

    <script type="text/javascript" src="https://use.typekit.net/gka2jxa.js"></script>
    <script>try{Typekit.load({ async: true });}catch(e){}</script>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
{{--    <link href="{{ mix('css/theme.css') }}" rel="stylesheet">--}}
{{--    <link href="{{ asset('css/style.css') }}" rel="stylesheet">--}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
          integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

    @yield ('styles')
</head>
<body class="d-flex flex-column">

@include('cookieConsent::index')

@include('layout.header')

@include('layout.navigation')
<div class="container content">
    @if (Auth::user() && session('temp_customer'))
        <div class="alert alert-info">
            <strong>{{ __('Notice!') }}</strong>
            {!! __('You are currently assuming the customer code: <span class="font-weight-bold">' . session('temp_customer') . '</span>.
            Your actual Customer Code is <span class="font-weight-bold">' . Auth::user()->customer_code . '</span>. Please <a href="' . route('customer.change.revert') . '">click here</a> to revert back to your default Customer Code.') !!}
        </div>
    @endif

    @yield('content')
</div>

@include('layout.footer')

<div id="img-modal" class="img-modal">
    <span class="close">&times;</span>
    <img class="img-modal-content" id="product-image" alt="Image Coming Soon">
    <div id="caption"></div>
</div>

<div class="modal fade" id="loader" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="loader"></div>
                <div class="loader-txt">
                    <p></p>
                </div>
            </div>
        </div>
    </div>
</div>

{{--<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>--}}
{{--<script type="text/javascript" src="{{ mix('js/main.js') }}"></script>--}}
{{--<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>--}}
{{--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>--}}
@yield('scripts')

</body>
</html>
