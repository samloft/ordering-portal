@extends('layout.master')

@section('page.title', 'Saved Baskets')

@section('content')
    <div class="w-full mb-5 text-center">
        <h2 class="font-semibold tracking-widest">{{ __('Saved Baskets') }}</h2>
        <p class="font-thin">
            {{ __('View your saved baskets or create new ones for easy repeat orders') }}
        </p>
    </div>

    <div class="bg-white rounded-lg shadow p-4">
        @include('layout.alerts')

        <form method="get" action="{{ route('saved-baskets') }}">
            <label for="reference">Template Reference</label>
            <input id="reference" class="bg-gray-100" name="reference" placeholder="Template Reference"
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

            <div class="text-center mt-6">
                <a href="{{ route('saved-baskets') }}">
                    <button type="button" class="button button-danger w-40">{{ __('Reset') }}</button>
                </a>
                <button class="button button-primary w-40">{{ __('Search') }}</button>
            </div>
        </form>
    </div>

    <h2 class="font-semibold tracking-widest mt-3 mb-3">{{ __('Search Results') }}</h2>

    <table>
        <thead>
        <tr>
            <th>Template Reference</th>
            <th>Saved Date</th>
            <th class="text-right">Delete Template</th>
        </tr>
        </thead>
        <tbody>
        @foreach($saved_baskets as $basket)
            <tr class="cursor-pointer hover:bg-gray-200"
                onclick="window.location = '{{ route('saved-baskets.show', ['id' => $basket->id]) }}';">
                <td class="align-middle">{{ $basket->reference }}</td>
                <td class="align-middle">{{ date('d/m/Y', strtotime($basket->created_at)) }}</td>
                <td class="text-right">
                    <a href="{{ route('saved-baskets.destroy', ['id' => $basket->id]) }}">
                        <button id="saved_basket__delete" class="button button-sm button-danger">
                            {{ __('Delete Template') }}
                        </button>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $saved_baskets->appends($_GET)->links('layout.pagination') }}
@endsection
