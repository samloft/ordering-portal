@extends('layouts.master')

@section('title', 'Delivery Methods')
@section('sub-title', 'Delivery options available to customers')

@section('content')
    <div class="px-6 pt-4 pb-6 xl:px-10 xl:pt-6 xl:pb-8 bg-white rounded-lg shadow">
        <div class="flex">
            <div class="w-1/4 mr-6">
                <h5 class="font-medium text-lg mb-2">Delivery Methods</h5>
                <p class="text-gray-600 text-sm">
                    These are the delivery options (with prices) available to customers on checkout to choose the delivery option.
                </p>
            </div>
            <div class="w-3/4">
                <delivery-methods :delivery_methods="{{ json_encode($delivery_methods, true) }}"></delivery-methods>
{{--                <div class="text-right mb-5">--}}
{{--                    <button class="button bg-gray-800 text-white">New delivery method</button>--}}
{{--                </div>--}}

{{--                <table class="w-full text-md bg-white shadow-md rounded mb-4">--}}
{{--                    <tbody>--}}
{{--                    <tr class="text-left border-b bg-gray-300 uppercase text-sm tracking-widest">--}}
{{--                        <th class="font-semibold p-2 px-5">Code</th>--}}
{{--                        <th class="font-semibold p-2 px-5">Title</th>--}}
{{--                        <th class="font-semibold p-2 px-5">Price under small order</th>--}}
{{--                        <th class="font-semibold p-2 px-5">Price over small order</th>--}}
{{--                        <th></th>--}}
{{--                    </tr>--}}
{{--                    @foreach($delivery_methods as $delivery_method)--}}
{{--                        <tr class="border-b">--}}
{{--                            <td class="p-1 px-5">{{ $delivery_method->code }}</td>--}}
{{--                            <td class="p-1 px-5">{{ $delivery_method->title }}</td>--}}
{{--                            <td class="p-1 px-5 text-right"><span class="badge badge-info">{{ $delivery_method->price_low }}</span></td>--}}
{{--                            <td class="p-1 px-5 text-right"><span class="badge badge-info">{{ $delivery_method->price }}</span></td>--}}
{{--                            <td class="p-1 px-5 flex justify-end">--}}
{{--                                <button type="button" class="button bg-gray-700 text-white text-xs w-20">--}}
{{--                                    Edit--}}
{{--                                </button>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @endforeach--}}
{{--                    </tbody>--}}
{{--                </table>--}}
            </div>
        </div>
    </div>
@endsection
