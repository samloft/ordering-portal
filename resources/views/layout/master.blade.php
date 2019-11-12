<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ ucfirst(config('app.name')) . ' Online Portal'}} - @yield('page.title')</title>

    <link href="{{ mix('css/app-'.config('app.name').'.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
          integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

    @yield ('styles')
</head>

<body>

<div id="app" class="flex flex-col min-h-screen w-full">

    @include('cookieConsent::index')

    @include('layout.header')

    @include('layout.navigation')

    <div class="flex-grow container mx-auto sm:px-4 pt-6 pb-8">
        @if (session('temp_customer'))
            <div class="alert alert-info" role="alert">
                <div class="alert-body">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="alert-icon">
                        <path class="primary" d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20z"></path>
                        <path class="secondary" d="M11 12a1 1 0 0 1 0-2h2a1 1 0 0 1 .96 1.27L12.33 17H13a1 1 0 0 1 0 2h-2a1 1 0 0 1-.96-1.27L11.67 12H11zm2-4a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"></path>
                    </svg>
{{--                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="alert-icon">--}}
{{--                        <circle cx="12" cy="12" r="10" class="primary"></circle>--}}
{{--                        <path class="secondary"--}}
{{--                              d="M10 14.59l6.3-6.3a1 1 0 0 1 1.4 1.42l-7 7a1 1 0 0 1-1.4 0l-3-3a1 1 0 0 1 1.4-1.42l2.3 2.3z"></path>--}}
{{--                    </svg>--}}
                    <div>
                        <p class="alert-title">{{ __('Notice!') }}</p>
                        <p class="alert-text">
                            {!! __('You are currently assuming the customer code: <span class="font-semibold">' . session('temp_customer') . '</span>.
               Your actual Customer Code is <span class="font-semibold">' . Auth::user()->customer_code . '</span>. Please <a href="' . route('customer.change.revert') . '" class="underline">click here</a> to revert back to your default Customer Code.') !!}
                        </p>
                    </div>
                </div>
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
