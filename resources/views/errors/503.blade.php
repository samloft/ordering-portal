@extends('errors.master')

@section('title', 'Down for maintenance')

@section('content')
    <div class="flex h-screen w-full">
        <div class="text-center text-gray-800 m-auto w-full">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                 class="w-64 mx-auto">
                <path class="text-gray-500 fill-current"
                      d="M5.04 14.3l-.1-.3H4a2 2 0 0 1-2-2v-2c0-1.1.9-2 2-2h1a1 1 0 0 1 1-1h6.34a3 3 0 0 0 2.12-.88l1.66-1.66A5 5 0 0 1 19.66 3H21a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1h-1.34a5 5 0 0 1-3.54-1.46l-1.66-1.66a3 3 0 0 0-2.12-.88H11v5a1 1 0 0 1-1 1H8a1 1 0 0 1-.95-.68l-2-5.98a1 1 0 0 1 0-.05z"></path>
                <rect width="8" height="10" x="4" y="6" class="secondary" rx="1"></rect>
            </svg>

            <h1 class="text-5xl mb-10">Sorry, we're down for maintenance</h1>

            @if(json_decode(file_get_contents(storage_path('framework/down')), true)['message'])
                <div class="bg-gray-800 text-white p-16 mb-10">
                    {{ json_decode(file_get_contents(storage_path('framework/down')), true)['message'] }}
                </div>
            @endif

            <h2 class="text-2xl tracking-widest">We'll be back shortly</h2>
        </div>
    </div>
@endsection
