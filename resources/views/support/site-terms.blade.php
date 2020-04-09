@extends('errors.master')

@section('page.title', 'Accept terms')

@section('content')
    <div class="flex h-screen w-full">
        <div class="text-center text-gray-800 m-auto w-full">
            <img class="mx-auto h-40" src="{{ asset('images/logos/logo-'.config('app.name').'-dark.png') }}"
                 alt="{{ config('app.name') }}"/>

            <h1 class="text-5xl mt-10 mb-10">Terms & Conditions</h1>

            <div class="bg-gray-800 text-white p-16 mb-10">
                <p class="mb-3">
                    As you are a new user to our online ordering portal, we require you to accept our terms &
                    conditions, you will only be required to do this once.
                </p>

                <p class="mb-3">
                    To read over our terms and conditions, you can find them on our website by clicking <a href="{{ \App\Models\GlobalSettings::termsEnabled()['url'] }}"
                                                                                                           target="_blank"
                                                                                                           class="underline font-medium hover:opacity-75">here</a>
                </p>

                <p class="mb-10">
                    Click the button below to agree to the terms & conditions supplied in the link above.
                </p>

                <form method="post" action="{{ route('site-terms.accept') }}">
                    <button type="submit" class="button button-primary">Accept Terms & Conditions</button>
                </form>
            </div>
        </div>
    </div>
@endsection
