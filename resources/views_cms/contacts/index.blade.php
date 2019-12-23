@extends('layouts.master')

@section('title', 'Contacts')
@section('sub-title', 'Emails users can contact via the contact page.')

@section('content')
    <div class="flex justify-end mb-3">
        <button class="button bg-gray-700 text-white">
            {{ __('Create Contact') }}
        </button>
    </div>

    <table class="w-full text-md bg-white shadow-md rounded mb-4">
        <tbody>
        <tr class="text-left border-b bg-gray-300 uppercase text-sm tracking-widest">
            <th class="font-semibold p-3 px-5">{{ __('Display Name') }}</th>
            <th class="font-semibold p-3 px-5">{{ __('Email Address') }}</th>
            <th></th>
        </tr>
        @foreach($contacts as $contact)
            <tr class="border-b hover:bg-gray-100">
                <td class="p-3 px-5">
                    {{ $contact['name'] }}
                </td>
                <td class="p-3 px-5">
                    <span class="badge badge-info">{{ $contact['email'] }}</span>
                </td>
                <td class="p-3 px-5 flex justify-end">
                    <button type="button"
                            class="button bg-gray-700 text-white text-xs w-20">
                        {{ __('Edit') }}
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
