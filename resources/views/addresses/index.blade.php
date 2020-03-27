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
