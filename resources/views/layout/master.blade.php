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
    <link href="{{ mix('css/theme.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
          integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

    @yield ('styles')
</head>
<body class="d-flex flex-column">

@include('cookieConsent::index')

@include('layout.header')

@include('layout.navigation')

<div class="container content">
    @yield('content')
</div>

@include('layout.footer')

<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
<script type="text/javascript" src="{{ mix('js/main.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
@yield('scripts')

</body>
</html>