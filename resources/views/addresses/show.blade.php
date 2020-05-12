@extends('layout.master')

@section('page.title', 'Address')

@section('content')
    <div class="w-full mb-5 text-center">
        <h2 class="font-semibold tracking-widest">{{ isset($address) ? 'Update Address' : 'Create Address' }}</h2>
        <p class="font-thin">
            {{ isset($address) ? 'Update your delivery address' : 'Create a new delivery address' }}
        </p>
    </div>

    <form method="post"
          action="{{ isset($address) ? route('account.address.edit', [$address->id]) : route('account.address.store') }}">

        @if(isset($address))
            @method('patch')
        @endif

        <div class="bg-white rounded-lg shadow p-3 md:p-10 mb-5">
            @include('layout.alerts')

            <div class="md:flex items-center mb-3">
                <label for="company_name" class="md:w-2/6">Company Name <span
                        class="text-red-600">*</span></label>
                <input id="company_name" class="bg-gray-100" placeholder="Company Name"
                       value="{{ $address->company_name ?? old('company_name') ?: auth()->user()->customer->customer_name }}"
                       name="company_name">
            </div>

            <div class="md:flex items-center mb-3">
                <label for="address_line_2" class="md:w-2/6">Address Line 2 <span class="text-red-600">*</span></label>
                <input id="address_line_2" class="bg-gray-100" placeholder="Address Line 2"
                       name="address_line_2"
                       value="{{ old('address_line_2') ?: $address->address_line_2 ?? null }}">
            </div>

            <div class="md:flex items-center mb-3">
                <label for="address_line_3" class="md:w-2/6">Address Line 3 <span class="text-red-600">*</span></label>
                <input id="address_line_3" class="bg-gray-100" placeholder="Address Line 3"
                       name="address_line_3"
                       value="{{ old('address_line_3') ?: $address->address_line_3 ?? null }}">
            </div>

            <div class="md:flex items-center mb-3">
                <label for="address_line_4" class="md:w-2/6">Address Line 4</label>
                <input id="address_line_4" class="bg-gray-100" placeholder="Address Line 4"
                       name="address_line_4"
                       value="{{ old('address_line_4') ?: $address->address_line_4 ?? null }}">
            </div>

            <div class="md:flex items-center mb-3">
                <label for="address_line_5" class="md:w-2/6">Address Line 5</label>
                <input id="address_line_5" class="bg-gray-100" placeholder="Address Line 5"
                       name="address_line_5"
                       value="{{ old('address_line_5') ?: $address->address_line_5 ?? null }}">
            </div>

            <div class="md:flex items-center mb-3 relative">
                <label for="country_id" class="md:w-2/6">Country <span class="text-red-600">*</span></label>
                <select id="country_id" class="bg-gray-100" name="country" autocomplete="off">
                    @foreach ($countries as $country)
                        <option
                            value="{{ $country['name'] }}"
                            @if(old('country') && $country['name'] === old('country'))
                            selected
                            @elseif(isset($address) && $country['name'] === $address['country'])
                            selected
                            @elseif($country['default'])
                            selected
                            @endif>
                            {{ $country['name'] }}
                        </option>
                    @endforeach
                </select>

                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                    </svg>
                </div>
            </div>

            <div class="md:flex items-center mb-3">
                <label for="post_code" class="md:w-2/6">Postcode <span class="text-red-600">*</span></label>
                <input id="post_code" class="bg-gray-100" placeholder="Postcode" name="post_code"
                       value="{{ old('post_code') ?: $address->post_code ?? null }}">
            </div>

            <div class="flex justify-end">
                <label class="checkbox flex items-center">
                    <span class="mr-2">Default Address?</span>
                    <input type="checkbox" class="form-checkbox"
                           name="default"
                           {{ old('postcode') ? 'checked' : (isset($address) ? ($address->default === 1 ? 'checked' : '') : '') }} autocomplete="off">
                </label>
            </div>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('account.addresses') }}">
                <button type="button" class="button button-danger">Cancel</button>
            </a>

            <div>
                <input name="checkout" value="{{ $checkout }}" hidden>
                <button class="button button-primary">{{ isset($address) ? 'Update' : 'Create' }}</button>
            </div>
        </div>

    </form>
@endsection
