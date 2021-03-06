@extends('layout.master')

@section('page.title', 'Account')

@section('content')
    <div class="w-full mb-5 text-center">
        <h2 class="font-semibold tracking-widest">Your Account</h2>
        <p class="font-thin">
            Update information regarding your online account
        </p>
    </div>

    <div class="bg-white rounded shadow-md p-3 mb-5 mr-2">
        @include('layout.alerts')

        <div class="md:flex">
            <div class="md:w-1/3 md:mr-5">
                <h4 class="text-primary">Your Details</h4>
                <p class="text-gray-500 font-thin">
                    Update your account details for your online ordering account
                </p>

                <div role="alert" class="alert alert-info mt-5">
                    <div class="alert-body text-sm items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="alert-icon">
                            <path d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20z" class="primary"></path>
                            <path
                                d="M11 12a1 1 0 0 1 0-2h2a1 1 0 0 1 .96 1.27L12.33 17H13a1 1 0 0 1 0 2h-2a1 1 0 0 1-.96-1.27L11.67 12H11zm2-4a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"
                                class="secondary"></path>
                        </svg>
                        <div>
                            <p class="alert-text">Should you require to change your email address, you will need to
                                contact customer services</p>
                        </div>
                    </div>
                </div>

                <div class="flex align-items mb-3 md:mb-0">
                    <span class="mr-3 text-gray-500 font-thin">Current Email</span>
                    <span class="badge badge-success">{{ auth()->user()->email }}</span>
                </div>
            </div>
            <div class="md:w-2/3">
                <form method="post" action="{{ route('account.store') }}" class="m-0">
                    <div class="border border-gray-300 rounded p-3 text-center leading-tight mb-5">
                        <span class="font-medium block">{{ auth()->user()->customer->code }}</span>
                        <span class="lock text-gray-600 font-thin">{{ auth()->user()->customer->name }}</span>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="text-sm">Name</label>
                        <input id="name" name="name"
                               value="{{ old('name') ?: auth()->user()->name }}">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="text-sm">Password</label>
                        <input id="password" name="password"
                               placeholder="************"
                               value="{{ old('password') }}">
                    </div>

                    <div class="mb-3">
                        <label for="password-confirm" class="text-sm">Password Confirmation</label>
                        <input id="password-confirm" name="password_confirmation"
                               placeholder="************"
                               value="{{ old('password') }}">
                    </div>

                    <div class="mb-3 flex">
                        <div class="mr-2 w-full">
                            <label for="telephone" class="text-sm">Telephone</label>
                            <input id="telephone" name="telephone"
                                   value="{{ old('telephone') ?: auth()->user()->telephone }}">
                        </div>
                        <div class="ml-2 w-full">
                            <label for="mobile" class="text-sm">mobile</label>
                            <input id="mobile" name="mobile"
                                   value="{{ old('mobile') ?: auth()->user()->mobile }}">
                        </div>
                    </div>

                    <div class="text-right">
                        <button class="button button-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="bg-white rounded shadow-md p-3 mb-5 mr-2">
        <div class="md:flex">
            <div class="md:w-1/2 mb-3 md:mb-0">
                <h4 class="text-primary">Invoice Address</h4>

                <div>{{ auth()->user()->customer->invoice_name }}</div>
                <div>{{ auth()->user()->customer->invoice_address_line_1 }}</div>
                <div>{{ auth()->user()->customer->invoice_address_line_2 }}</div>
                <div>{{ auth()->user()->customer->invoice_address_line_3 }}</div>
                <div>{{ auth()->user()->customer->invoice_address_line_4 }}</div>
                <div>{{ auth()->user()->customer->invoice_address_line_5 }}</div>
            </div>
            <div class="md:w-1/2 mb-3 md:mb-0">
                <h4 class="text-primary">Default Delivery Address</h4>

                <div>{{ auth()->user()->customer->name }}</div>
                <div>{{ auth()->user()->customer->address_line_1 }}</div>
                <div>{{ auth()->user()->customer->address_line_2 }}</div>
                <div>{{ auth()->user()->customer->city }}</div>
                <div>{{ auth()->user()->customer->country }}</div>
                <div>{{ auth()->user()->customer->post_code }}</div>

                <div class="text-right mt-2">
                    <a href="{{ route('account.addresses') }}">
                        <button class="button button-inverse">View Addresses</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
