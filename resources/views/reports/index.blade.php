@extends('layout.master')

@section('page.title', 'Reports')

@section('content')
    <div class="w-full mb-5 text-center">
        <h2 class="font-semibold tracking-widest">Reports</h2>
        <p class="font-thin">
            Select a report and output type you would like to download.
        </p>
    </div>

    <div class="bg-white rounded-lg shadow p-4 text-center">
        @include('layout.alerts')

        <reports></reports>
    </div>
@endsection
