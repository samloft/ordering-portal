@extends('layout.master')

@section('page.title', 'Saved Baskets')

@section('content')
    <div class="w-full mb-5 text-center">
        <h2 class="font-semibold tracking-widest">Saved Baskets</h2>
        <p class="font-thin">
            View your saved baskets or create new ones for easy repeat orders
        </p>
    </div>

    <div class="bg-white rounded-lg shadow p-4">
        @include('layout.alerts')

        <form method="get" action="{{ route('saved-baskets') }}">
            <label for="reference">Template Reference</label>
            <input id="reference" name="reference" placeholder="Template Reference"
                   value="{{ request('reference') }}">

            <div class="flex mt-3 mb-3">
                <div class="w-1/2 mr-2">
                    <label for="start-date">From Date</label>
                    <date-picker input_name="date_from" old_value="{{ request('date_from') }}"></date-picker>
                </div>

                <div class="w-1/2">
                    <label for="end-date">To Date</label>
                    <date-picker input_name="date_to" old_value="{{ request('date_to') }}"></date-picker>
                </div>
            </div>

            <div class="justify-end sm:justify-center mt-6 flex w-full">
                <a href="{{ route('saved-baskets') }}">
                    <button type="button" class="button button-danger w-auto sm:w-40 mr-1">Reset</button>
                </a>
                <button class="button button-primary w-auto sm:w-40 ml-1">Search</button>
            </div>
        </form>
    </div>

    <h2 class="font-semibold tracking-widest mt-3 mb-3">Search Results</h2>

    @if(count($saved_baskets) > 0)
        <div class="table-container">
            <table class="table">
                <thead>
                <tr>
                    <th>
                        <span class="hidden md:block">Template Reference</span>
                        <span class="md:hidden">Reference</span>
                    </th>
                    <th>
                        <span class="hidden md:block">Saved Date</span>
                        <span class="md:hidden">Saved</span>
                    </th>
                    <th class="text-right">
                        <span class="hidden md:block">Delete Template</span>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($saved_baskets as $basket)
                    <tr class="cursor-pointer hover:bg-gray-50"
                        onclick="window.location = '{{ route('saved-baskets.show', ['reference' => $basket->reference]) }}';">
                        <td class="align-middle">{{ $basket->reference }}</td>
                        <td class="align-middle">{{ date('d/m/Y', strtotime($basket->created_at)) }}</td>
                        <td class="text-right">
                            <a class="hidden md:block"
                               href="{{ route('saved-baskets.destroy', ['reference' => $basket->reference]) }}">
                                <button id="saved_basket__delete" class="button button-sm button-danger">
                                    Delete Template
                                </button>
                            </a>
                            <a class="md:hidden text-red-600"
                               href="{{ route('saved-baskets.destroy', ['reference' => $basket->reference]) }}">
                                Delete
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{ $saved_baskets->appends($_GET)->links('layout.pagination') }}

    @elseif(!$search)
        <div class="bg-white rounded-lg shadow p-4">
            <h3 class="text-center text-lg font-semibold">You currently have now saved baskets, add items to your basket
                and click "Save Basket" on the basket page to create one.</h3>
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-4">
            <h3 class="text-center text-lg font-semibold">No saved baskets found for that search</h3>
        </div>
    @endif
@endsection
