@extends('layouts.master')

@section('title', 'Site Settings')
@section('sub-title', 'Global site settings')

@section('content')
    <div class="px-6 pt-4 pb-6 xl:px-10 xl:pt-6 xl:pb-8 bg-white rounded-lg shadow">
        <maintenance :enabled="'{{ $data['maintenance'] }}'"></maintenance>

        <hr class="mt-3 mb-3">

        <div class="flex">
            <div class="w-1/4 mr-6">
                <h5 class="font-medium text-lg mb-2">Stuff</h5>
                <p class="text-gray-600 text-sm">
                    Things.
                </p>
            </div>
            <div class="w-3/4">
                Form
            </div>
        </div>
    </div>
@endsection
