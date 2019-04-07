@extends('layout.master')

@section('page.title', 'Reports')

@section('content')
    <h1 class="page-title">{{ __('Reports') }}</h1>

    <div class="card card-body">
        @include('layout.alerts')

        <div class="text-center">
            <form action="{{ route('reports.show') }}" method="post">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="report" value="account_summary">
                    <label class="form-check-label">
                        {{ __('Account Summary') }}
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="report" value="back_orders">
                    <label class="form-check-label">
                        {{ __('Back Order History') }}
                    </label>
                </div>

                <button type="submit" class="btn btn-primary mt-4">{{ __('Run Report') }}</button>
            </form>
        </div>
    </div>
@endsection