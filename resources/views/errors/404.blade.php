@extends('errors.master')

@section('page.title', 'Page not found')

@section('content')
    <div class="flex h-screen w-full">
        <div class="text-center text-gray-800 m-auto w-full">
            <h1 style="font-size: 14rem;" class="font-extrabold">
                <span class="text-gray-800">4</span>
                <span class="text-gray-500">0</span>
                <span class="text-gray-800">4</span>
            </h1>

            <h1 class="text-3xl mb-10">Oops, we can't seem to find the page you're looking for.</h1>

            <div class="bg-gray-800 text-white p-16 mb-10">
                Click on the button below to go back to safety
            </div>

            <a href="/">
                <button class="button bg-gray-800 text-white">Go home</button>
            </a>
        </div>
    </div>
@endsection
