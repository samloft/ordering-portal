@extends('layout.master')

@section('page.title', 'Reports')

@section('content')
    <div class="w-full mb-5 text-center">
        <h2 class="font-semibold tracking-widest">{{ __('Reports') }}</h2>
        <p class="font-thin">
            {{ __('Select a report and output type you would like to download.') }}
        </p>
    </div>

    <div class="bg-white rounded-lg shadow p-4 text-center">
        @include('layout.alerts')

        <form id="run-report" action="{{ route('reports.show') }}" method="post" class="m-0 ">
            <label class="checkbox flex items-center justify-center mb-1">
                <input type="checkbox" class="form-checkbox" name="report" value="account_summary">
                <span class="ml-2">{{ __('Account Summary') }}</span>
            </label>

            <label class="checkbox flex items-center justify-center">
                <input type="checkbox" class="form-checkbox" name="report" value="back_orders">
                <span class="ml-2">{{ __('Back Order History') }}</span>
            </label>

            <div class="relative mt-3 w-40 mx-auto">
                <label for="output">{{ __('Output As') }} </label>
                <select class="w-full p-2 rounded border text-gray-600 appearance-none" name="output">
                    <option value="pdf">{{ __('PDF') }}</option>
                    <option value="csv">{{ __('CSV') }}</option>
                </select>

                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 pt-6 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                    </svg>
                </div>
            </div>

            <button class="button button-primary mt-5">{{ __('Run Report') }}</button>
        </form>
    </div>
@endsection
