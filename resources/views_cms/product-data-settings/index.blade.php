@extends('layouts.master')

@section('title', 'Product Data')
@section('sub-title', 'Choose to display product data')

@section('content')
    <div class="px-6 pt-4 pb-6 xl:px-10 xl:pt-6 xl:pb-8 bg-white rounded-lg shadow">
        <form method="POST" action="{{ route('cms.product-data.update') }}">
            @method('PATCH')

            @include('layout.alerts')

            <div class="flex">
                <div class="w-1/4 mr-6">
                    <h5 class="font-medium text-lg mb-2">Product Data</h5>
                    <p class="text-gray-600 text-sm">
                        Choose if the product data download should be enabled.
                    </p>
                </div>
                <div class="w-3/4 relative mr-1">
                    <label for="product-data" class="text-sm font-medium">Product Data Enabled</label>
                    <select id="product-data" class="rounded border bg-gray-100 text-gray-600 appearance-none mt-1"
                            name="product_data"
                            autocomplete="off">
                        <option value="1" {{ $settings['data'] ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ ! $settings['data'] ? 'selected' : '' }}>No</option>
                    </select>
                    <div
                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 pt-4 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 20 20">
                            <path
                                d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <hr class="mt-3 mb-3">

            <div class="flex">
                <div class="w-1/4 mr-6">
                    <h5 class="font-medium text-lg mb-2">Net Prices</h5>
                    <p class="text-gray-600 text-sm">
                        Choose if the net price download should be enabled.
                    </p>
                </div>
                <div class="w-3/4 relative mr-1">
                    <label for="product-prices" class="text-sm font-medium">Net Prices Enabled</label>
                    <select id="product-prices" class="rounded border bg-gray-100 text-gray-600 appearance-none mt-1"
                            name="product_prices"
                            autocomplete="off">
                        <option value="1" {{ $settings['prices'] ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ ! $settings['prices'] ? 'selected' : '' }}>No</option>
                    </select>
                    <div
                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 pt-4 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 20 20">
                            <path
                                d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <hr class="mt-3 mb-3">

            <div class="text-right mt-5">
                <button type="submit" class="button bg-gray-800 text-white">Save</button>
            </div>

        </form>
    </div>
@endsection
