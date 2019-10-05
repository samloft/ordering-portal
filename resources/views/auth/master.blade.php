<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ ucfirst(config('app.name', 'Online Ordering')) . ' Online Ordering'}} - @yield('page.title')</title>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>

<body>

<div id="app" class="theme-{{ config('app.name') }}">
    <main class="auth">
{{--        <div class="flex h-full px-4 items-center sm:px-0">--}}
{{--            <div class="flex-col w-full h-full items-center">--}}

                <div class="auth-form">
                    <a href="/" class="logo-heading">
                        <img class="logo" src="{{ asset('images/logos/logo-' . config('app.name') . '-dark.png') }}"
                             alt="{{ config('app.name') }}">

                        <h1>{{ __('Ordering Portal') }}</h1>
                    </a>

                    <h1>
                        @yield('content.heading')
                        <span>@yield('content.sub.heading')</span>
                    </h1>

                    @include('layout.alerts')

                    @yield('content')

                </div>

                <div class="auth-details">
                    <a href="/">
                        <img class="logo" src="{{ asset('images/logos/logo-' . config('app.name') . '.png') }}"
                             alt="{{ config('app.name') }}">
                    </a>

                    <h1>{{ __('Welcome to our ordering portal.') }}</h1>

                    <p>{{ __('The updated site now incorporates a number of improved features that allow users to access new information directly and more easily.') }}</p>
                </div>
{{--            </div>--}}
{{--        </div>--}}
    </main>
</div>

<script src="{{ mix('js/app.js') }}"></script>

</body>
</html>
