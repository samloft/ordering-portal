<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ ucfirst(config('app.name')) . ' Online Portal'}} - @yield('page.title')</title>

    <link href="{{ mix('css/app-'.config('app.name').'.css') }}" rel="stylesheet">

    @yield ('styles')

    <script src="{{ asset('js/turbo-links.js') }}"></script>
</head>

<body>

<div id="app" class="flex flex-col min-h-screen w-full">

    @include('layout.header')

    @include('layout.navigation')

    <div class="flex-grow container mx-auto sm:px-4 pt-6 pb-8">
        @if($announcement)
            <div class="alert alert-info" role="alert">
                <div class="alert-body">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="alert-icon">
                        <path d="M16 8.38l4.55-2.27A1 1 0 0 1 22 7v10a1 1 0 0 1-1.45.9L16 15.61V17a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V7c0-1.1.9-2 2-2h10a2 2 0 0 1 2 2v1.38zm0 2.24v2.76l4 2V8.62l-4 2zM14 17V7H4v10h10z"/>
                    </svg>
                    <div>
                        <p class="alert-title">Site Announcement</p>
                        <p class="alert-text">{{ $announcement }}</p>
                    </div>
                </div>
            </div>
        @endif


        @if (session('temp_customer'))
            <div class="alert alert-warning" role="alert">
                <div class="alert-body">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="alert-icon">
                        <path class="primary" d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20z"></path>
                        <path class="secondary"
                              d="M11 12a1 1 0 0 1 0-2h2a1 1 0 0 1 .96 1.27L12.33 17H13a1 1 0 0 1 0 2h-2a1 1 0 0 1-.96-1.27L11.67 12H11zm2-4a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"></path>
                    </svg>
                    <div>
                        <p class="alert-title">Notice!</p>
                        <p class="alert-text">
                            You are currently assuming the customer code: <span class="font-semibold"> {{ session('temp_customer') }}</span>.
               Your actual Customer Code is <span class="font-semibold">{{ auth()->user()->customer_code }}</span>. Please <a href="{{ route('customer.change.revert') }}" class="underline">click here</a> to revert back to your default Customer Code.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')
    </div>

    @include('layout.footer')
</div>

<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>

@yield('scripts')

</body>
</html>
