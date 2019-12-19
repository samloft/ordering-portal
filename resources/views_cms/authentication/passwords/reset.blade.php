@extends('authentication.master')

@section('content')
    <form method="POST" action="{{ route('cms.password.update', ['token' => $token]) }}" class="bg-grey-lightest px-10 py-10">

        <div class="mb-3">
            <label class="block text-gray-700 text-sm font-semibold mb-2" for="email">
                {{ __('Email Address') }}
            </label>
            <input id="email" class="border w-full p-2 rounded-lg" name="email" type="text"
                   placeholder="E-Mail" autocomplete="email" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="mb-3">
            <label class="block text-gray-700 text-sm font-semibold mb-2" for="password">
                {{ __('Password') }}
            </label>
            <input id="password" class="border w-full p-2 rounded-lg" name="password" type="password"
                   placeholder="**********" required>
        </div>

        <div class="mb-3">
            <label class="block text-gray-700 text-sm font-semibold mb-2" for="password-confirm">
                {{ __('Confirm Password') }}
            </label>
            <input id="password-confirm" class="border w-full p-2 rounded-lg" name="password_confirmation" type="password"
                   placeholder="**********" required>
        </div>

        <div class="flex">
            <button
                class="bg-gray-700 hover:bg-gray-700 w-full p-4 text-sm text-white uppercase font-bold tracking-wider rounded-lg">
                {{ __('Reset Password') }}
            </button>
        </div>
    </form>

    <div class="p-3 text-center">
        <a href="{{ route('cms.login') }}" class="text-blue-700 hover:underline no-underline">
            {{ __('Return to login') }}
        </a>
    </div>
@endsection
