@extends('errors.master')

@section('page.title', 'Page not found')

@section('content')
    <div class="flex h-screen w-full">
        <div class="text-center text-gray-800 m-auto w-full">
            <h1 style="font-size: 14rem;" class="font-extrabold leading-tight">
                <span class="text-gray-800">ERROR</span>
            </h1>

            <h1 style="font-size: 4rem;" class="text-gray-400 font-semibold leading-tight mb-10">500 | Server Error</h1>

            <div class="bg-gray-800 text-white p-16 mb-10">
                <p>It's not you, it's us. This is a server error.</p>
                <p>Our development team have been notified of this error and will have it fixed shortly.</p>
            </div>

            <a href="/">
                <button class="button bg-gray-800 text-white">Go home</button>
            </a>
        </div>
    </div>
@endsection
