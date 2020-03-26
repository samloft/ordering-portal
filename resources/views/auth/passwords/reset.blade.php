@extends('auth.master')

@section('page.title', 'Reset Password')
@section('content.heading', 'Reset your password?')
@section('content.sub.heading', 'Enter the details below to create your new password')

@section('content')
    <form method="POST" action="{{ route('password.update') }}">
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="input-group">
            <label for="email">Email address</label>
            <input type="email" id="email" class="form-input" name="email" value="{{ $email ?? old('email') }}"
                   autocomplete="off" required autofocus>
        </div>

        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" class="form-input" name="password" autocomplete="off" required>
        </div>

        <div class="input-group">
            <label for="confirm_password">Confirm password</label>
            <input type="password" id="confirm_password" class="form-input" name="password_confirmation" autocomplete="off" required>
        </div>

        <button type="submit" class="button button-primary button-block">
            Reset Password
        </button>
    </form>

    <div class="text-center mt-4">
        <a href="/" class="button-link">
            Cancel
        </a>
    </div>
@endsection
