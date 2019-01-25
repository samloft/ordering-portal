@extends('cms.auth.master')

@section('page.title', 'Login')

@section('content')

    <p class="mb-5">Login to access your CMS</p>

    <form method="post" action="{{ route('cms.login.submit') }}">
        @include('cms.layout.alerts')

        <div class="form-group">
            <label class="text-label" for="email_2">Email Address:</label>
            <div class="input-group input-group-merge">
                <input type="email" name="email" required class="form-control form-control-prepended"
                       placeholder="john@doe.com">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <span class="far fa-envelope"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="text-label" for="password_2">Password:</label>
            <div class="input-group input-group-merge">
                <input type="password" name="password" required class="form-control form-control-prepended"
                       placeholder="Enter your password">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <span class="fa fa-key"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group mb-5">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="remember" checked>
                <label class="custom-control-label" for="remember">Remember me</label>
            </div>
        </div>
        <div class="form-group text-center">
            <button class="btn btn-primary mb-5" type="submit">Login</button>
            <br>
            <a href="">Forgot password?</a>
        </div>
    </form>

@endsection
