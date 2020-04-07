<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ ucfirst(config('app.name')) }} - @yield('title')</title>

    <link href="{{ mix('css/cms.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontawesome.css') }}" rel="stylesheet">
</head>

<body class="antialiased bg-gray-200">
<div>
    <div id="app" class="h-screen flex flex-col">
        @include('layouts.header')

        <div class="flex-1 flex overflow-hidden">
            @include('layouts.navigation')

            <main class="flex-1 flex bg-gray-200 overflow-auto">
                <div class="flex-1 flex flex-col w-0">
                    <div class="shadow-md">
                        <div class="px-10 py-4 bg-gray-100 border-b">
                            <h2 class="uppercase leading-tight font-semibold text-lg">@yield('title')</h2>
                            <p class="font-thin text-xs uppercase">@yield('sub-title')</p>
                        </div>
                    </div>

                    <div class="px-10 py-4 flex-1">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>

<script src="{{ mix('js/cms.js') }}"></script>

</body>
</html>
