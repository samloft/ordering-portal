@extends('layouts.master')

@section('title', 'Site Settings')
@section('sub-title', 'Global site settings')

@section('content')
    <div class="px-6 pt-4 pb-6 xl:px-10 xl:pt-6 xl:pb-8 bg-white rounded-lg shadow">
        <maintenance :enabled="'{{ $data['maintenance'] }}'"></maintenance>

        <hr class="mt-3 mb-5">

        <form method="post" action="{{ route('cms.site-settings.update') }}">
            @method('patch')

            @include('layout.alerts')

            <div class="flex">
                <div class="w-1/4 mr-6">
                    <h5 class="font-medium text-lg mb-2">Global Announcement</h5>
                    <p class="text-gray-600 text-sm">
                        Enter a text only announcement that will be disabled to all customers.
                    </p>
                </div>
                <div class="w-3/4">
                    <label for="announcement" class="text-sm font-medium">Announcement Message</label>
                    <input id="announcement" class="bg-gray-100 mt-1" value="{{ $data['announcement'] }}"
                           name="announcement"
                           placeholder="Enter a message for a global announcement">
                </div>
            </div>

            <hr class="mt-3 mb-3">

            <div class="flex">
                <div class="w-1/4 mr-6">
                    <h5 class="font-medium text-lg mb-2">Checkout Notice</h5>
                    <p class="text-gray-600 text-sm">
                        Enter a notice that will be displayed on the checkout page.
                    </p>
                </div>
                <div class="w-3/4">
                    <label for="checkout_notice" class="text-sm font-medium">Checkout Notice</label>
                    <input id="checkout_notice" class="bg-gray-100 mt-1" value="{{ $data['checkout_notice'] }}"
                           name="checkout_notice"
                           placeholder="Enter a checkout notice">
                </div>
            </div>

            <hr class="mt-3 mb-3">

            <div class="flex">
                <div class="w-1/4 mr-6">
                    <h5 class="font-medium text-lg mb-2">Default Country</h5>
                    <p class="text-gray-600 text-sm">
                        Select the default country that will be auto-selected when users create a new delivery address.
                    </p>
                </div>
                <div class="w-3/4 relative">
                    <label for="default_company" class="text-sm font-medium">Country</label>
                    <select id="default_company" class="rounded border bg-gray-100 text-gray-600 appearance-none mt-1"
                            name="default_country"
                            autocomplete="off">
                        @foreach($data['countries'] as $country)
                            <option
                                value="{{ $country['name'] }}" {{ $country['name'] === $data['default_country'] ? 'selected' : '' }}>{{ $country['name'] }}</option>
                        @endforeach
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
                    <h5 class="font-medium text-lg mb-2">Google Analytics</h5>
                    <p class="text-gray-600 text-sm">
                        Enter the google analytics tracking code from the google console.
                    </p>
                </div>
                <div class="w-3/4">
                    <label for="tracking_code" class="text-sm font-medium">Tracking Code</label>
                    <input id="tracking_code" class="bg-gray-100 mt-1" value="{{ $data['google_analytics'] }}"
                           name="tracking_code"
                           placeholder="Google Analytics tracking code">
                </div>
            </div>

            <hr class="mt-3 mb-3">

            <div class="flex">
                <div class="w-1/4 mr-6">
                    <h5 class="font-medium text-lg mb-2">Google Maps</h5>
                    <p class="text-gray-600 text-sm">
                        Enter the google maps URL for the site location, this will add the maps image to the contact
                        page.
                    </p>
                </div>
                <div class="w-3/4">
                    <label for="google_maps" class="text-sm font-medium">Maps URL</label>
                    <input id="google_maps" class="bg-gray-100 mt-1" value="{{ $data['google_maps'] }}"
                           name="google_maps"
                           placeholder="Google Maps URL">
                </div>
            </div>

            <hr class="mt-3 mb-3">

            <div class="flex">
                <div class="w-1/4 mr-6">
                    <h5 class="font-medium text-lg mb-2">VersionOne</h5>
                    <p class="text-gray-600 text-sm">
                        Set the DOCID for the versionone document that should be looked for (Sales Invoice for the
                        company).
                    </p>
                </div>
                <div class="w-3/4">
                    <label for="v1_docid" class="text-sm font-medium">V1 DocID</label>
                    <input id="v1_docid" class="bg-gray-100 mt-1" value="{{ $data['v1_docid'] }}"
                           name="v1_docid"
                           placeholder="V1 DocID">
                </div>
            </div>

            <hr class="mt-3 mb-3">

            <div class="flex">
                <div class="w-1/4 mr-6">
                    <h5 class="font-medium text-lg mb-2">Last Order Number</h5>
                    <p class="text-gray-600 text-sm">
                        Sets the last used order number, this means the next order placed will be this order incremented
                        by 1.
                    </p>
                </div>
                <div class="w-3/4">
                    <label for="last-order-number" class="text-sm font-medium">Last Order</label>
                    <input id="last-order-number" class="bg-gray-100 mt-1" value="{{ $data['last_order'] }}"
                           name="last_order"
                           placeholder="Last Order Number">
                    <span class="text-xs">* Only accepts 1 letter followed by 6 numbers</span>
                </div>
            </div>

            <hr class="mt-3 mb-3">

            <div class="flex">
                <div class="w-1/4 mr-6">
                    <h5 class="font-medium text-lg mb-2">Terms & Conditions</h5>
                    <p class="text-gray-600 text-sm">
                        Should acceptance of terms & conditions be required for new users logging into the site for the
                        first time?
                    </p>
                </div>
                <div class="w-3/4">
                    <div class="relative mb-2">
                        <label for="terms-enabled" class="text-sm font-medium">Terms Enabled?</label>
                        <select id="terms-enabled"
                                class="rounded border bg-gray-100 text-gray-600 appearance-none mt-1"
                                name="terms_enabled"
                                autocomplete="off">
                            <option value="1" {{ $data['terms-enabled']['enabled'] ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ ! $data['terms-enabled']['enabled'] ? 'selected' : '' }}>No</option>
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

                    <label for="terms-url">Terms URL</label>
                    <input id="terms-url" name="terms_url" class="bg-gray-100 mt-1"
                           placeholder="URL on main website to the terms" value="{{ $data['terms-enabled']['url'] }}">
                </div>
            </div>

            <hr class="mt-3 mb-3">

            <div class="text-right mt-5">
                <button type="submit" class="button bg-gray-800 text-white">Save settings</button>
            </div>
        </form>
    </div>
@endsection
