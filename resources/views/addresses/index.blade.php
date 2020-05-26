@extends('layout.master')

@section('page.title', 'Addresses')

@section('content')
    <div class="w-full mb-5 text-center">
        <h2 class="font-semibold tracking-widest">Addresses</h2>
        <p class="font-thin">
            Update or create delivery addresses
        </p>
    </div>

    @include('layout.alerts')

    <div class="rounded-lg shadow p-4 mb-3 bg-primary text-white">
        <div class="md:flex justify-between items-center">
            <div class="mb-2 md:mb-0">
                <h4 class="md:hidden mb-2 text-white text-center text-1xl">Default Address</h4>

                <div class="font-medium">{{ auth()->user()->customer->name }}</div>
                <div>{{ auth()->user()->customer->address_line_1 }}</div>
                <div>{{ auth()->user()->customer->address_line_2 }}</div>
                <div>{{ auth()->user()->customer->city }}</div>
                <div>{{ auth()->user()->customer->country }}</div>
                <div>{{ auth()->user()->customer->post_code }}</div>
            </div>
            <div class="text-right md:w-1/4">
                @if($checkout)
                    <a href="{{ route('account.address.select') }}"
                       class="btn-link">
                        <button class="button button-primary button-block mb-1">Select Address</button>
                    </a>
                @endif
            </div>
        </div>
    </div>

    @if (count($addresses) > 0)
        <account-address :addresses="{{ json_encode($addresses, true) }}" checkout="{{ $checkout }}"></account-address>

        <div class="mb-5 mt-5">
            {{ $addresses->appends(request()->input())->links('layout.pagination') }}
        </div>
    @else
        <div class="text-center font-medium mt-5 mb-5 bg-white rounded-lg shadow p-10">
            <h2>You currently have no delivery addresses, click below to add one</h2>
        </div>
    @endif

    <div class="flex justify-between">
        <a href="{{ $checkout ? route('checkout', ['account' => true]) : route('account') }}">
            <button class="button button-inverse">Cancel</button>
        </a>
        <a href="@if($checkout) {{ route('account.address.create', ['checkout' => $checkout]) }} @else {{ route('account.address.create') }} @endif">
            <button class="button button-primary">Add New Address</button>
        </a>
    </div>
@endsection
