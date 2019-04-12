@extends('layout.master')

@section('page.title', 'Reports')

@section('content')
    <h1 class="page-title">{{ __('Reports') }}</h1>

    <div class="card card-body">
        @include('layout.alerts')

        <div class="text-center">
            <form action="{{ route('reports.show') }}" method="post">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="report" value="account_summary" autocomplete="off">
                    <label class="form-check-label">
                        {{ __('Account Summary') }}
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="report" value="back_orders" autocomplete="off">
                    <label class="form-check-label">
                        {{ __('Back Order History') }}
                    </label>
                </div>

                <div class="form-group form-inline justify-content-center mt-3">
                    <label class="mr-1">{{ __('Output As: ') }}</label>
                    <select class="form-control form-control-sm" name="output" autocomplete="off">
                        <option value="pdf">{{ __('PDF') }}</option>
                        <option value="csv">{{ __('CSV') }}</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mt-4">{{ __('Run Report') }}</button>
            </form>
        </div>
    </div>
@endsection