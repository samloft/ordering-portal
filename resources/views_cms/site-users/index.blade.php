@extends('layouts.master')

@section('title', 'Site Users')
@section('sub-title', 'Users that have access to the ordering portal.')

@section('content')
    <div class="flex justify-end mb-3">
        <site-users>
            <template v-slot:trigger>
                <button class="button bg-gray-700 text-white">
                    {{ __('Create User') }}
                </button>
            </template>
        </site-users>
    </div>

    <div class="px-6 pt-4 pb-6 xl:px-10 xl:pt-6 xl:pb-8 bg-white rounded-lg shadow mb-5">

        <form class="m-0" method="get" action="{{ route('cms.site-users') }}">
            <div class="mb-4">
                <label class="text-sm font-medium">{{ __('Keyword Search') }}</label>
                <input class="bg-gray-100 mt-1"
                       value="{{ old('search') }}"
                       name="search"
                       placeholder="Search for name/email/customer code">
            </div>

            <div class="text-center mt-6">
                <a href="{{ route('cms.site-users') }}">
                    <button type="button" class="button button-danger w-40">{{ __('Reset') }}</button>
                </a>
                <button class="button bg-gray-700 text-white w-40">{{ __('Search') }}</button>
            </div>
        </form>
    </div>

    <table class="w-full text-md bg-white shadow-md rounded mb-4">
        <tbody>
        <tr class="text-left border-b bg-gray-300 uppercase text-sm tracking-widest">
            <th class="font-semibold p-3 px-5">{{ __('Name') }}</th>
            <th class="font-semibold p-3 px-5">{{ __('Email') }}</th>
            <th class="font-semibold p-3 px-5">{{ __('Customer') }}</th>
            <th class="font-semibold p-3 px-5">{{ __('Additional Customers') }}</th>
            <th class="font-semibold p-3 px-5">{{ __('Account') }}</th>
            <th></th>
        </tr>
        @foreach($site_users as $user)
            <tr class="border-b hover:bg-gray-100">
                <td class="p-3 px-5">
                    {{ $user->name }}
                </td>
                <td class="p-3 px-5">
                    {{ $user->email }}
                </td>
                <td class="p-3 px-5">
                    {{ $user->customer_code }}
                </td>
                <td class="p-3 px-5">
                    <span class="badge badge-info">{{ $user->customers->count() }}</span>
                </td>
                <td class="p-3 px-5">
                    @if($user->can_order)
                        <span class="badge badge-success">{{ __('Full') }}</span>
                    @else
                        <span class="badge badge-warning">{{ __('Browse Only') }}</span>
                    @endif

                    @if($user->admin)
                        <span class="badge badge-danger">{{ __('Site Admin') }}</span>
                    @endif
                </td>
                <td class="p-3 px-5 flex justify-end">
                    <site-users :user="{{ json_encode($user, true) }}">
                        <template v-slot:trigger>
                            <button type="button"
                                    class="button bg-gray-700 text-white text-xs w-20">
                                {{ __('Edit') }}
                            </button>
                        </template>
                    </site-users>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $site_users->appends($_GET)->links('layout.pagination') }}
    </div>

@endsection
