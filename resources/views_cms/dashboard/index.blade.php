@extends('layouts.master')

@section('title', 'Dashboard')
@section('sub-title', 'Statistics overview')

@section('content')
    <div class="flex bg-blue-800 rounded-lg text-white shadow opacity-75">
        <div class="w-1/3 border-r border-gray-100 p-5">
            <h3 class="uppercase font-medium text-blue-300 text-sm">{{ __('Registered Users') }}</h3>
            <span class="text-3xl text-gray-100">{{ $stats['users'] }}</span>
        </div>
        <div class="w-1/3 border-r border-gray-100 p-5">
            <h3 class="uppercase font-medium text-blue-300 text-sm">{{ __('Orders today') }}</h3>
            <span class="text-3xl text-gray-100">{{ $stats['orders-today'] }}</span>
        </div>
        <div class="w-1/3 border-r border-gray-100 p-5">
            <h3 class="uppercase font-medium text-blue-300 text-sm">{{ __('Registered Users') }}</h3>
            <span class="text-3xl text-gray-100">{{ $stats['users'] }}</span>
        </div>
    </div>
@endsection
