@extends('layout.master')

@section('page.title', 'Reports')

@section('content')
    <h1 class="page-title">{{ __('Reports') }}</h1>

    <div class="card card-body">
        <div class="text-center">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="exampleRadios" value="option1">
                <label class="form-check-label">
                    {{ __('Account Summary') }}
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="exampleRadios" value="option1">
                <label class="form-check-label">
                    {{ __('Back Order History') }}
                </label>
            </div>

            <button class="btn btn-primary mt-4">{{ __('Run Report') }}</button>
        </div>
    </div>
@endsection