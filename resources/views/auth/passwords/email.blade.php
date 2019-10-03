@extends('auth.master')

@section('page.title', 'Forgot Password')
@section('content.heading', 'Forgot your password?')
@section('content.sub.heading', 'Enter your email address below and we will send you a link to reset your password')

@section('content')
    <form method="POST" action="{{ route('password.email') }}">
        <div class="input-group">
            <label for="email">{{ __('Email address') }}</label>
            <input type="email" id="email" class="form-input" name="email" autocomplete="off" value="{{ old('email') }}" required>
        </div>

        <button type="submit" class="button button-primary button-block">
            {{ __('Send Password Reset Link') }}
        </button>
    </form>

    <div class="text-center mt-4">
        <a href="{{ route('login') }}" class="button-link">
            {{ __('Return To Login') }}
        </a>
    </div>
@endsection
