@extends('auth.master')

@section('page.title', 'Login')
@section('content.heading', 'Login to your account')
@section('content.sub.heading', 'Enter your email address and password below to gain access')

@section('content')
    <form method="POST" action="{{ route('login') }}">
        <div class="input-group">
            <label for="email">Email address</label>
            <input type="email" id="email" class="form-input" name="email" autocomplete="off" required>
        </div>

        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" class="form-input" name="password" autocomplete="off" required>
        </div>

        <div class="flex mb-6">
            <label class="checkbox flex items-center">
                <input type="checkbox" class="form-checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <span class="ml-2">Remember me</span>
            </label>
        </div>

        <button type="submit" class="button button-primary button-block">
            Login
        </button>
    </form>

    <div class="text-center mt-4">
        <a href="{{ route('password.request') }}" class="button-link">
            Forgot Password?
        </a>
    </div>
@endsection
