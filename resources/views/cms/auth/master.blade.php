<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ ucfirst(config('app.name', 'Online Ordering')) . ' CMS'}} - @yield('page.title')</title>

    <link href="{{ asset('css/cms/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontawesome.css') }}" rel="stylesheet">

    @yield ('styles')
</head>
<body class="layout-login">

<div class="layout-login__overlay"></div>

<div class="layout-login__form bg-white">
    <div class="d-flex justify-content-center mt-2 mb-5 navbar-light">
        <a href="/" class="navbar-brand">
            <span>Scolmore Online</span>
        </a>
    </div>

    <h4 class="m-0">Welcome back!</h4>

    @yield('content')
</div>

</body>
</html>