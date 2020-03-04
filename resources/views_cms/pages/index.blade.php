@extends('layouts.master')

@section('title', $data['title'])
@section('sub-title', $data['title'])

@section('content')
    <div class="px-6 pt-4 pb-6 xl:px-10 xl:pt-6 xl:pb-8 bg-white rounded-lg shadow">
        <div class="flex">
            <div class="w-1/4 mr-6">
                <h5 class="font-medium text-lg mb-2">{{ $data['title'] }}</h5>
                <p class="text-gray-600 text-sm">
                    {{ $data['description'] }}
                </p>

                <h5 class="font-medium text-lg mb-2 mt-5">Markdown keys</h5>
                <p class="text-gray-600 text-sm">
                    This page uses markdown for it's page formatting. All items that can be used are listed on the <a class="underline" href="https://spec.commonmark.org/0.29/" target="_blank">Common Mark</a> website
                </p>

            </div>
            <div class="w-3/4">
                @include('layout.alerts')

                <form action="{{ route('cms.pages.store') }}" method="post">
                    <input name="key" value="{{ $data['key'] }}" hidden>

                    <textarea id="page" name="description" rows="30"
                              class="form-textarea block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5">{{ $data['data'] }}</textarea>

                    <div class="text-right mt-5">
                        <button class="button bg-gray-800 text-white">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
