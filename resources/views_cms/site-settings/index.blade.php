@extends('layouts.master')

@section('title', 'Site Settings')
@section('sub-title', 'Global site settings')

@section('content')
    <div class="px-6 pt-4 pb-6 xl:px-10 xl:pt-6 xl:pb-8 bg-white rounded-lg shadow">
        <maintenance :enabled="'{{ $data['maintenance'] }}'"></maintenance>

        <hr class="mt-3 mb-5">

        <div class="flex">
            <div class="w-1/4 mr-6">
                <h5 class="font-medium text-lg mb-2">Global Announcement</h5>
                <p class="text-gray-600 text-sm">
                    Enter a text only announcement that will be disabled to all customers.
                </p>
            </div>
            <div class="w-3/4">
                <label class="text-sm font-medium">Announcement Message</label>
                <input class="bg-gray-100 mt-1" value=""
                       name="announcement"
                       placeholder="Enter a message for a global announcement">
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
            <div class="w-3/4 relative mr-1">
                <label class="text-sm font-medium">Country</label>
                <select class="rounded border bg-gray-100 text-gray-600 appearance-none mt-1"
                        name="default_country"
                        autocomplete="off">
                    @foreach($data['countries'] as $country)
                        <option value="{{ $country['name'] }}" {{ $country['name'] === $data['default_country'] ? 'selected' : '' }}>{{ $country['name'] }}</option>
                    @endforeach
                </select>
                <div
                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 pb-1 text-gray-700">
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
                <label class="text-sm font-medium">Tracking Code</label>
                <input class="bg-gray-100 mt-1" value=""
                       name="tracking_code"
                       placeholder="Google Analytics tracking code">
            </div>
        </div>

        <hr class="mt-3 mb-3">

        <div class="flex">
            <div class="w-1/4 mr-6">
                <h5 class="font-medium text-lg mb-2">Google Maps</h5>
                <p class="text-gray-600 text-sm">
                    Enter the google maps URL for the site location, this will add the maps image to the contact page.
                </p>
            </div>
            <div class="w-3/4">
                <label class="text-sm font-medium">Maps URL</label>
                <input class="bg-gray-100 mt-1" value=""
                       name="google_maps"
                       placeholder="Google Maps URL">
            </div>
        </div>

        <hr class="mt-3 mb-3">

        <div class="text-right mt-5">
            <button class="button bg-gray-800 text-white">Save settings</button>
        </div>
    </div>
@endsection
