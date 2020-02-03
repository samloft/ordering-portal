@extends('layouts.master')

@section('title', 'Site Discounts')
@section('sub-title', 'Discounts deducted from products')

@section('content')
    <div class="px-6 pt-4 pb-6 xl:px-10 xl:pt-6 xl:pb-8 bg-white rounded-lg shadow">
        <div class="flex">
            <div class="w-1/4 mr-6">
                <h5 class="font-medium text-lg mb-2">{{ __('Global default discount') }}</h5>
                <p class="text-gray-600 text-sm">
                    {{ __('This is the global site discount percentage, any customers that do not have an override below will have this discount applied them.') }}
                </p>
            </div>
            <div class="w-3/4">
                <div class="mb-4">
                    <label class="text-sm font-medium">{{ __('Global Discount Percent') }}</label>
                    <input class="bg-gray-100 mt-1" value=""
                           name="discount"
                           placeholder="Discount Percentage e.g 2">
                </div>

                <div class="text-right mt-5">
                    <button class="button bg-gray-800 text-white">{{ __('Update global discount') }}</button>
                </div>
            </div>
        </div>

        <hr class="border border-gray-300 my-5">

        <div class="flex">
            <div class="w-1/4 mr-6">
                <h5 class="font-medium text-lg mb-2">{{ __('Discount overrides') }}</h5>
                <p class="text-gray-600 text-sm">
                    {{ __('Any customers that should not use the global discount need to be added here with their own customer discount percentage.') }}
                </p>
            </div>
            <div class="w-3/4">
                <table class="w-full text-md bg-white shadow-md rounded mb-4">
                    <tbody>
                    <tr class="text-left border-b bg-gray-300 uppercase text-sm tracking-widest">
                        <th class="font-semibold p-2 px-5">{{ __('Customer Code') }}</th>
                        <th class="font-semibold p-2 px-5">{{ __('Customer Name') }}</th>
                        <th class="font-semibold p-2 px-5">{{ __('Discount Percent') }}</th>
                        <th></th>
                    </tr>
                        <tr class="border-b hover:bg-gray-100">
                            <td class="p-1 px-5">SCO100</td>
                            <td class="p-1 px-5">SCOLMORE SAMPLE ACCOUNT</td>
                            <td class="p-1 px-5">
                                <span class="badge badge-info">1.2%</span>
                            </td>
                            <td class="p-1 px-5 flex justify-end">
                                <button type="button"
                                        class="button bg-gray-700 text-white text-xs w-20">
                                    {{ __('Edit') }}
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
