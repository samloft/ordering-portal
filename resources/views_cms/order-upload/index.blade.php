@extends('layouts.master')

@section('title', 'Order Upload')
@section('sub-title', 'Set order upload settings')

@section('content')
    <div class="px-6 pt-4 pb-6 xl:px-10 xl:pt-6 xl:pb-8 bg-white rounded-lg shadow">
        <div class="flex">
            <div class="w-1/4 mr-6">
                <h5 class="font-medium text-lg mb-2">Order Upload</h5>
                <p class="text-gray-600 text-sm">
                    Update options that are available for customers as part of an order upload.
                </p>
            </div>
            <div class="w-3/4">
                @include('layout.alerts')

                <form method="post" action="{{ route('cms.order-upload.store') }}">
                        <div class="relative mb-3">
                            <label for="prices" class="text-sm font-medium">Enable price check?</label>

                            <select class="mt-1 p-2 rounded border bg-gray-100 text-gray-600 appearance-none"
                                    id="prices"
                                    name="prices"
                                    autocomplete="off">
                                <option value="1" {{ $settings['prices'] ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ $settings['prices'] ? '' : 'selected' }}>No</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 pt-6 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path
                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                </svg>
                            </div>
                        </div>

                        <div class="relative">
                            <label for="packs" class="text-sm font-medium">Enable pack quantity option?</label>

                            <select class="mt-1 p-2 rounded border bg-gray-100 text-gray-600 appearance-none"
                                    id="packs"
                                    name="packs"
                                    autocomplete="off">
                                <option value="1" {{ $settings['packs'] ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ $settings['packs'] ? '' : 'selected' }}>No</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 pt-6 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path
                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                </svg>
                            </div>
                        </div>

                    <div class="text-right mt-5">
                        <button type="submit" class="button bg-gray-800 text-white">Update upload settings</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
