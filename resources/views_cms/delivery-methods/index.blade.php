@extends('layouts.master')

@section('title', 'Delivery Methods')
@section('sub-title', 'Delivery options available to customers')

@section('content')
    <div class="px-6 pt-4 pb-6 xl:px-10 xl:pt-6 xl:pb-8 bg-white rounded-lg shadow mb-3">
        <div class="flex">
            <div class="w-1/4 mr-6">
                <h5 class="font-medium text-lg mb-2">Delivery Methods</h5>
                <p class="text-gray-600 text-sm">
                    These are the delivery options (with prices) available to customers on checkout to choose the
                    delivery option.
                </p>
            </div>
            <div class="w-3/4">
                <delivery-methods :delivery_methods="{{ json_encode($delivery_methods, true) }}"></delivery-methods>
            </div>
        </div>
    </div>

    <div class="px-6 pt-4 pb-6 xl:px-10 xl:pt-6 xl:pb-8 bg-white rounded-lg shadow">
        <div class="flex">
            <div class="w-1/4 mr-6">
                <h5 class="font-medium text-lg mb-2">Collection Messages</h5>
                <p class="text-gray-600 text-sm">
                    Here you can select the collection message based on time, or an override message (This will ignore
                    any times added).
                    You must also have a delivery method above that contains the word "Collect" or "Collection" for it
                    to work.
                </p>
            </div>
            <div class="w-3/4">
                <collection-messages
                    :collection_messages="{{ json_encode($collection_messages, true) }}"></collection-messages>
            </div>
        </div>
    </div>
@endsection
