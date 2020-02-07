@extends('layouts.master')

@section('title', 'Small Order Charge')
@section('sub-title', 'Charges for orders under a threshold')

@section('content')
    <div class="px-6 pt-4 pb-6 xl:px-10 xl:pt-6 xl:pb-8 bg-white rounded-lg shadow">
        <div class="flex">
            <div class="w-1/4 mr-6">
                <h5 class="font-medium text-lg mb-2">Small Order Charge</h5>
                <p class="text-gray-600 text-sm">
                    The small order charge is when an order is placed below an order threshold value of your choosing.
                </p>

                <p class="text-gray-600 text-sm mt-3">
                    <span class="block font-semibold">Order Threshold</span> The value the small order charge will kick
                    it if
                    it's below that value.
                </p>

                <p class="text-gray-600 text-sm mt-3">
                    <span class="block font-semibold">Charge</span> The amount charged when the order is below the
                    threshold.
                </p>

                <p class="text-gray-600 text-sm mt-3">
                    <span class="block font-semibold">Exclude Charged Delivery</span> If a delivery charge that costs
                    money is
                    chosen, and if yes is selected, the charge will be waved.
                </p>

                <p class="text-gray-600 text-sm mt-3">
                    <span class="block font-semibold">Exclude With Collection</span> If the delivery method is
                    collection, and
                    if yes is selected, the charge will be waved.
                </p>
            </div>
            <div class="w-3/4">
                @include('layout.alerts')

                <form method="post" action="{{ route('cms.small-order.update') }}">
                    <div class="flex mb-4">
                        <div class="w-1/2 mr-3">
                            <label class="text-sm font-medium">Order Threshold</label>

                            <input class="bg-gray-100 mt-1" value="{{ old('threshold') ?: $small_order_rules['threshold'] }}"
                                   name="threshold"
                                   placeholder="Order Threshold, E.G 200">
                        </div>

                        <div class="w-1/2 mr-3">
                            <label class="text-sm font-medium">Charge</label>

                            <input class="bg-gray-100 mt-1" value="{{ old('charge') ?: $small_order_rules['charge'] }}"
                                   name="charge"
                                   placeholder="Amount the charge should be">
                        </div>
                    </div>

                    <div class="flex mb-4">
                        <div class="w-1/2 mr-3 relative">
                            <label class="text-sm font-medium">Excluded With Delivery Charge</label>

                            <select class="mt-1 p-2 rounded border bg-gray-100 text-gray-600 appearance-none"
                                    name="exclude_delivery_charges"
                                    autocomplete="off">
                                <option
                                    value="1" {{ $small_order_rules['exclude_on_charge_delivery'] ? '' : 'selected' }}>
                                    Yes
                                </option>
                                <option
                                    value="0" {{ $small_order_rules['exclude_on_charge_delivery'] ? 'selected' : '' }}>
                                    No
                                </option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 pt-8 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path
                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                </svg>
                            </div>
                        </div>

                        <div class="w-1/2 mr-3 relative">
                            <label class="text-sm font-medium">Excluded With Collection</label>

                            <select class="mt-1 p-2 rounded border bg-gray-100 text-gray-600 appearance-none"
                                    name="exclude_collection"
                                    autocomplete="off">
                                <option value="1" {{ $small_order_rules['exclude_on_collection'] ? '' : 'selected' }}>
                                    Yes
                                </option>
                                <option value="0" {{ $small_order_rules['exclude_on_collection'] ? 'selected' : '' }}>
                                    No
                                </option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 pt-8 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path
                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="text-right mt-5">
                        <button class="button bg-gray-800 text-white">Update small order charge</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
