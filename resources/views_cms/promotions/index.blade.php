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
                <promotions :promotions="{{ json_encode($promotions, true) }}"
                            :buying_groups="{{ json_encode($buying_groups, true) }}"
                            :price_lists="{{ json_encode($price_lists, true) }}"
                            :discount_codes="{{ json_encode($discount_codes, true) }}">

                    {{--                    @if(count($promotions) > 0)--}}
                    {{--                        <div class="flex flex-col">--}}
                    {{--                            <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">--}}
                    {{--                                <div--}}
                    {{--                                    class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">--}}
                    {{--                                    <table class="min-w-full">--}}
                    {{--                                        <thead>--}}
                    {{--                                        <tr>--}}
                    {{--                                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">--}}
                    {{--                                                Product--}}
                    {{--                                            </th>--}}
                    {{--                                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">--}}
                    {{--                                                Promo Product--}}
                    {{--                                            </th>--}}
                    {{--                                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">--}}
                    {{--                                                Restriction--}}
                    {{--                                            </th>--}}
                    {{--                                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">--}}
                    {{--                                                Claimable--}}
                    {{--                                            </th>--}}
                    {{--                                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">--}}
                    {{--                                                Starts--}}
                    {{--                                            </th>--}}
                    {{--                                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">--}}
                    {{--                                                Ends--}}
                    {{--                                            </th>--}}
                    {{--                                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-200"></th>--}}
                    {{--                                        </tr>--}}
                    {{--                                        </thead>--}}
                    {{--                                        <tbody class="bg-white">--}}
                    {{--                                        @foreach($promotions as $promotion)--}}
                    {{--                                            <tr>--}}
                    {{--                                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 font-medium text-gray-900">--}}
                    {{--                                                    <div--}}
                    {{--                                                        class="text-sm leading-5 font-medium text-gray-900">{{ $promotion->product }}</div>--}}
                    {{--                                                    <div class="text-sm leading-5 text-gray-500">--}}
                    {{--                                                        Qty: {{ $promotion->product_qty }}</div>--}}
                    {{--                                                </td>--}}
                    {{--                                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">--}}
                    {{--                                                    <div--}}
                    {{--                                                        class="text-sm leading-5 font-medium text-gray-900">{{ $promotion->promotion_product }}</div>--}}
                    {{--                                                    <div class="text-sm leading-5 text-gray-500">--}}
                    {{--                                                        Qty: {{ $promotion->promotion_qty }}</div>--}}
                    {{--                                                </td>--}}
                    {{--                                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">--}}
                    {{--                                                                        <span class="badge badge-info capitalize">--}}
                    {{--                                                                            {{ $promotion->restrictions ? str_replace('_', ' ', $promotion->restrictions) : 'none' }}--}}
                    {{--                                                                        </span>--}}
                    {{--                                                    @if($promotion->restrictions)--}}
                    {{--                                                        <span class="badge badge-warning capitalize ml-1">--}}
                    {{--                                                                             {{ count($promotion->{$promotion->restrictions .'s'}) }}--}}
                    {{--                                                                        </span>--}}
                    {{--                                                    @endif--}}
                    {{--                                                </td>--}}
                    {{--                                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">--}}
                    {{--                                                    {{ $promotion->max_claims > 0 ? $promotion->max_claims : 'Unlimited' }}--}}
                    {{--                                                </td>--}}
                    {{--                                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">--}}
                    {{--                                                    {{ $promotion->start_date <= \Carbon\Carbon::now()->format('Y-m-d') ? 'Started' : \Carbon\Carbon::parse($promotion->start_date)->diffForHumans() }}--}}
                    {{--                                                </td>--}}
                    {{--                                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">--}}
                    {{--                                                    {{ $promotion->end_date ?? 'Never' }}--}}
                    {{--                                                </td>--}}
                    {{--                                                <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">--}}
                    {{--                                                    <a href="#" @click="openModal()"--}}
                    {{--                                                       class="text-indigo-600 hover:text-indigo-900 focus:outline-none focus:underline">Edit</a>--}}
                    {{--                                                </td>--}}
                    {{--                                            </tr>--}}
                    {{--                                        @endforeach--}}
                    {{--                                        </tbody>--}}
                    {{--                                    </table>--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}

                    {{--                        <div class="mt-4">--}}
                    {{--                            {{ $promotions->appends($_GET)->links('layout.pagination') }}--}}
                    {{--                        </div>--}}
                    {{--                    @else--}}
                    {{--                        <div class="text-center underline text-xl font-medium">--}}
                    {{--                            No promotions have been added yet.--}}
                    {{--                        </div>--}}
                    {{--                    @endif--}}
                </promotions>
            </div>
        </div>
    </div>
@endsection
