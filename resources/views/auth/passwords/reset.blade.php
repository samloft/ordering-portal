@extends('auth.master')

@section('page.title', 'Reset Password')
@section('content.heading', 'Reset your password?')
@section('content.sub.heading', 'Enter the details below to create your new password')

@section('content')
    <form method="POST" action="{{ route('password.update') }}">
        <div class="input-group">
            <label for="email">{{ __('Email address') }}</label>
            <input type="email" id="email" class="form-input" name="email" value="{{ $email ?? old('email') }}"
                   autocomplete="off" required autofocus>
        </div>

        <div class="input-group">
            <label for="password">{{ __('Password') }}</label>
            <input type="password" id="password" class="form-input" name="password" autocomplete="off" required>
        </div>

        <div class="input-group">
            <label for="email">{{ __('Confirm password') }}</label>
            <input type="email" id="email" class="form-input" name="password_confirmation" autocomplete="off" required>
        </div>

        <button type="submit" class="button button-primary button-block">
            {{ __('Reset Password') }}
        </button>
    </form>

    <div class="text-center mt-4">
        <a href="/" class="button-link">
            {{ __('Cancel') }}
        </a>
    </div>
@endsection
