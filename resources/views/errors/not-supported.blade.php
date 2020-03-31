@extends('errors.master')

@section('page.title', 'Browser not supported')

@section('content')
    <div class="flex h-screen w-full">
        <div class="text-center text-gray-800 m-auto w-full">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                 y="0px" viewBox="0 0 1000 1000"
                 class="w-64 h-64 mx-auto">
                <g>
                    <path
                        d="M939.4,906.7H60.6c-31.7,0-50.6-25.9-50.6-50.9V144.2c0-31.9,25.8-50.9,50.6-50.9h878.7c31.7,0,50.6,25.9,50.6,50.9v711.7C990,887.7,964.3,906.7,939.4,906.7z M84.3,832h831.4V168H84.3V832z"/>
                    <path
                        d="M327.8,405.9c-7.9,0-15.8-3-21.9-9.1l-80.5-81c-12.1-12.2-12.1-31.9,0-44c12.1-12.2,31.7-12.2,43.8,0l80.5,81c12.1,12.2,12.1,31.9,0,44C343.6,402.9,335.7,405.9,327.8,405.9z"/>
                    <path
                        d="M247.3,405.9c-7.9,0-15.8-3-21.9-9.1c-12.1-12.2-12.1-31.9,0-44l80.5-81c12.1-12.2,31.7-12.2,43.8,0c12.1,12.2,12.1,31.9,0,44l-80.5,81C263.1,402.9,255.2,405.9,247.3,405.9z"/>
                    <path
                        d="M752.7,406c-7.9,0-15.8-3-21.9-9.1l-80.5-81c-12.1-12.2-12.1-31.9,0-44c12.1-12.2,31.7-12.2,43.8,0l80.5,81c12.1,12.2,12.1,31.9,0,44C768.6,402.9,760.6,406,752.7,406z"/>
                    <path
                        d="M672.2,405.9c-7.9,0-15.8-3-21.9-9.1c-12.1-12.2-12.1-31.9,0-44l80.5-81c12.1-12.2,31.7-12.2,43.8,0c12.1,12.2,12.1,31.9,0,44l-80.5,81C688.1,402.9,680.1,405.9,672.2,405.9z"/>
                    <path
                        d="M772.4,711.1H227.6c-17.1,0-31-13.9-31-31.1c0-17.2,13.9-31.1,31-31.1h544.8c17.1,0,31,13.9,31,31.1C803.3,697.2,789.5,711.1,772.4,711.1z"/>
                    <path d="M542.1,711.1v58.7c0,0,0,42.2,61.9,42.2h66.6c0,0,61.9,0,61.9-42.2v-58.7H542.1z"/>
                </g>
            </svg>

            <h1 class="text-5xl mb-10">Sorry, your browser is not supported</h1>

            <div class="bg-gray-800 text-white p-16 mb-10">
                <p class="mb-5">The browser you are currently using is outdated, please update it or use a supported
                    browser.</p>

                <p class="underline mb-3">Supported browsers are:</p>

                <ul>
                    <li>Internet Explorer 11+</li>
                    <li>Firefox</li>
                    <li>Google Chrome</li>
                    <li>Safari</li>
                    <li>Microsoft Edge</li>
                </ul>
            </div>

            <h2 class="text-2xl tracking-widest">Please return when you are using a supported browser</h2>
        </div>
    </div>
@endsection
