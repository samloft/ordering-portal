<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }} - Login</title>

    <link href="{{ mix('css/cms.css') }}" rel="stylesheet">
</head>

<body class="bg-gray-300 text-base text-gray-900 font-normal relative">

<div class="flex mx-auto p-8">
    <div class="mx-auto max-w-sm">

        @include('layout.alerts')

        <div class="bg-white rounded shadow-lg">
            <div class="p-3">
                <img class="mx-auto h-16" src="{{ asset('images/logos/logo-' . config('app.name') . '-dark.png') }}"
                     alt="{{ config('app.name') }}">
            </div>

            @yield('content')
        </div>
    </div>
</div>

</body>
</html>
