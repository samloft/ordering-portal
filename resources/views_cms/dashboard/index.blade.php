@extends('layouts.master')

@section('title', 'Dashboard')
@section('sub-title', 'Statistics overview')

@section('content')
    <div class="flex bg-indigo-600 rounded-lg text-white shadow opacity-75 mb-10">
        <div class="w-1/3 border-r border-gray-100 p-5">
            <h3 class="uppercase font-medium text-indigo-300 text-sm">{{ __('Registered Users') }}</h3>
            <span class="text-3xl text-gray-100">{{ $stats['users'] }}</span>
        </div>
        <div class="w-1/3 border-r border-gray-100 p-5">
            <h3 class="uppercase font-medium text-indigo-300 text-sm">{{ __('Orders today') }}</h3>
            <span class="text-3xl text-gray-100">{{ $stats['orders-today'] }}</span>
        </div>
        <div class="w-1/3 border-r border-gray-100 p-5">
            <h3 class="uppercase font-medium text-indigo-300 text-sm">{{ __('Pending Orders') }}</h3>
            <span class="text-3xl text-gray-100">{{ count($stats['pending-orders']) }}</span>
        </div>
    </div>

    <div class="mb-3">
        <h5 class="text-lg leading-6 font-medium text-gray-900">Pending Orders</h5>
        <p class="mt-2 text-base leading-6 text-gray-500">
            All orders that have been placed, but have not yet been imported to the companies ERP system.
        </p>
    </div>

    @if(count($stats['pending-orders']) > 0)
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul>
                @foreach($stats['pending-orders'] as $pending_order)
                    <li class="border-b border-gray-200">
                        <a href="#"
                           class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="leading-5 font-medium text-indigo-600 truncate">
                                        {{ $pending_order->order_number }}
                                    </div>
                                    <div class="ml-2 flex-shrink-0 flex">
                                  <span
                                      class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $pending_order->delivery_method }}
                                  </span>
                                    </div>
                                </div>
                                <div class="mt-2 sm:flex sm:justify-between">
                                    <div class="sm:flex">
                                        <div class="mr-6 flex items-center text-sm leading-5 text-gray-500">
                                            <svg class="flex-shrink-0 mr-1.5 h-6 w-6 text-gray-400" fill="currentColor">
                                                <path
                                                    d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                            </svg>
                                            {{ $pending_order->customer_code }}
                                        </div>
                                        <div class="mt-2 flex items-center text-sm leading-5 text-gray-500 sm:mt-0">
                                            <svg class="flex-shrink-0 mr-1.5 h-6 w-6 text-gray-400" fill="currentColor">
                                                <path
                                                    d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm1-11v2h1a3 3 0 0 1 0 6h-1v1a1 1 0 0 1-2 0v-1H8a1 1 0 0 1 0-2h3v-2h-1a3 3 0 0 1 0-6h1V6a1 1 0 0 1 2 0v1h3a1 1 0 0 1 0 2h-3zm-2 0h-1a1 1 0 1 0 0 2h1V9zm2 6h1a1 1 0 0 0 0-2h-1v2z"></path>
                                            </svg>
                                            {{ currency($pending_order->value, 2) }}
                                        </div>
                                    </div>
                                    <div class="mt-2 flex items-center text-sm leading-5 text-gray-500 sm:mt-0">
                                        <svg class="flex-shrink-0 mr-1.5 h-6 w-6 text-gray-400" fill="currentColor"
                                             viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                  d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                        <span>
                                        Received
                                            <time datetime="{{ $pending_order->created_at }}">{{ \Carbon\Carbon::parse($pending_order->created_at)->diffForHumans() }}</time>
                                      </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        <div class="bg-white shadow overflow-hidden sm:rounded-md text-center p-6">
            <h5 class="text-lg leading-6 font-medium text-gray-900">No Orders Pending 👍</h5>
        </div>
    @endif
@endsection
