@extends('layout.master')

@section('page.title', 'Change Password')

@section('content')
    <h1 class="page-title">{{ __('Change Account Password') }}</h1>

    <div class="card card-body">
        <div class="form-row justify-content-center">
            <div class="col-5">
                @include('layout.alerts')

                <form action="{{ route('account.password.store') }}" method="post">
                    @method('PATCH')

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">{{ __('Current Password') }}</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="current_password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">{{ __('New Password') }}</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="new_password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">{{ __('Confirm Password') }}</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="new_password_confirmation">
                        </div>
                    </div>

                    <div class="text-right">
                        <a href="{{ route('account') }}" class="btn-link">
                            <button type="button" class="btn btn-blue">{{ __('Cancel') }}</button>
                        </a>
                        <button type="submit" class="btn btn-primary">{{ __('Update Password') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
