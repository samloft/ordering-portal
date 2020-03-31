@extends('layout.master')

@section('page.title', 'Contact Us')

@section('content')
    @if($map)
        <div class="map">
            <iframe width="100%" height="300" id="gmap_canvas"
                    src="{{ $map }}"
                    frameborder="0"
                    class="mb-3">
            </iframe>
        </div>
    @endif

    @include('layout.alerts')

    <div class="flex mt-4">
        <div class="w-1/3 mr-4">
            <div class="bg-white rounded shadow p-5">
                <div class="address">
                    <div class="font-semibold">{{ $company_details['line_1'] }}</div>
                    <div>{{ $company_details['line_2'] }}</div>
                    <div>{{ $company_details['line_3'] }}</div>
                    <div>{{ $company_details['line_4'] }}</div>
                    <div>{{ $company_details['line_5'] }}</div>
                    <div>{{ $company_details['postcode'] }}</div>

                    <br>

                    <div>{{ 'Tel: '.$company_details['telephone'] }}</div>
                </div>
            </div>
        </div>
        <div class="w-2/3">
            <div class="bg-white rounded shadow p-5">
                <form action="{{ route('contact.email') }}" method="post" class="mb-0">
                    <div class="relative mb-2">
                        <label for="to">To:</label>
                        <select id="to" name="to">
                            @foreach($contacts as $contact)
                                <option value="{{ $contact->email }}">{{ $contact->name }}</option>
                            @endforeach
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700 pt-6">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label for="name">Name:</label>
                        <input id="name" name="name"
                               value="{{ auth()->user()->name }}">
                    </div>

                    <div class="mb-2">
                        <label for="email">Email:</label>
                        <input id="email" name="email" value="{{ auth()->user()->email  }}">
                    </div>

                    <div class="mb-2">
                        <label for="message">Message:</label>
                        <textarea id="message" name="message" rows="5"></textarea>
                    </div>

                    <div class="text-right">
                        <button class="button button-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
