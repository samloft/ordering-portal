@extends('layouts.master')

@section('title', 'Site Discounts')
@section('sub-title', 'Discounts deducted from products')

@section('content')
    <div class="px-6 pt-4 pb-6 xl:px-10 xl:pt-6 xl:pb-8 bg-white rounded-lg shadow">
        <div class="flex">
            <div class="w-1/4 mr-6">
                <h5 class="font-medium text-lg mb-2">Global default discount</h5>
                <p class="text-gray-600 text-sm">
                    This is the global site discount percentage, any customers that do not have an override below will have this discount applied them.
                </p>
            </div>
            <div class="w-3/4">
                @include('layout.alerts')

                <form method="post" action="{{ route('cms.discounts.global-store') }}">
                    <div class="mb-4">
                        <label class="text-sm font-medium">Global Discount Percent</label>
                        <input class="bg-gray-100 mt-1" value="{{ $global_discount }}"
                               name="global_discount"
                               placeholder="Discount Percentage e.g 2">
                    </div>

                    <div class="text-right mt-5">
                        <button class="button bg-gray-800 text-white">Update global discount</button>
                    </div>
                </form>
            </div>
        </div>

        <hr class="border border-gray-300 my-5">

        <div class="flex">
            <div class="w-1/4 mr-6">
                <h5 class="font-medium text-lg mb-2">Discount overrides</h5>
                <p class="text-gray-600 text-sm">
                    Any customers that should not use the global discount need to be added here with their own customer discount percentage.
                </p>
            </div>
            <div class="w-3/4">
                <customer-discounts :discounts="{{ json_encode($customer_discounts, true) }}"></customer-discounts>
            </div>
        </div>
    </div>
@endsection
