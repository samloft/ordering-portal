@extends('layouts.master')

@section('title', 'Contacts')
@section('sub-title', 'Emails users can contact via the contact page.')

@section('content')
    <div class="px-6 pt-4 pb-6 xl:px-10 xl:pt-6 xl:pb-8 bg-white rounded-lg shadow">
        <div class="flex">
            <div class="w-1/4 mr-6">
                <h5 class="font-medium text-lg mb-2">Contacts</h5>
                <p class="text-gray-600 text-sm">
                    These are list of names and email addresses that customers will be able to contact on the "Contact Us" page.
                </p>
            </div>
            <div class="w-3/4">
                <contacts :contacts="{{ $contacts }}"></contacts>
            </div>
        </div>
    </div>
@endsection
