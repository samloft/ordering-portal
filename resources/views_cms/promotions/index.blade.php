@extends('layouts.master')

@section('title', 'Promotions')
@section('sub-title', 'Product promotions')

@section('content')
    <div class="px-6 pt-4 pb-6 xl:px-10 xl:pt-6 xl:pb-8 bg-white rounded-lg shadow">
        <div class="flex">
            <div class="w-1/4 mr-6">
                <h5 class="font-medium text-lg mb-2">Site Promotions</h5>
                <p class="text-gray-600 text-sm">
                    Promotions can be added so if a customer buys X of a product they will get Y of a product for free,
                    this can be limited to a claim amount.
                </p>
            </div>
            <div class="w-3/4">
                <promotions :promotions="[]"
                            :buying_groups="{{ json_encode($buying_groups, true) }}"
                            :price_lists="{{ json_encode($price_lists, true) }}"
                            :discount_codes="{{ json_encode($discount_codes, true) }}">
                </promotions>
            </div>
        </div>
    </div>
@endsection
