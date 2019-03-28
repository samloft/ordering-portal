@extends('layout.master')

@section('content')
    <div class="container content">
        <h1 class="page-title">Forgot Password</h1>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-body">
                        <p>
                            {{ __('Please enter your username and click "Send Password Reset Link" and we will send password reset
                            instructions to your email address.') }}
                        </p>

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">

                            <div class="form-group row">
                                <label for="username" class="col-md-4 col-form-label">{{ __('Username') }}</label>

                                <div class="col">
                                    <input id="username"
                                           class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}"
                                           name="username" value="{{ old('username') }}" required>

                                    @if ($errors->has('username'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group mb-0 text-right">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                                <a href="/">
                                    <button class="btn">
                                        {{ __('Cancel') }}
                                    </button>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
