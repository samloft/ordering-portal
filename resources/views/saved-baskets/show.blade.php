@extends('layout.master')

@section('page.title', 'Saved Baskets')

@section('content')
    <div class="w-full mb-5 text-center">
        <h2 class="font-semibold tracking-widest">Saved Basket Details</h2>
        <p class="font-thin">
            A list of all products in your saved basket.
        </p>
    </div>

    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex">
            <div class="w-1/2">
                <h4 class="font-semibold">Template Reference <span
                        class="badge badge-info">{{ $saved_basket->first()->reference }}</span></h4>

                <h4 class="font-semibold">Date Saved <span
                        class="font-normal">{{ \Carbon\Carbon::parse($saved_basket->first()->created_at)->format('d/m/Y') }}</span>
                </h4>
            </div>

            <div class="w-1/2 text-right">
                <button class="button button-inverse" onclick="window.history.back();">
                    Back
                </button>

                <a href="{{ route('saved-baskets.destroy', ['id' => $saved_basket->first()->id]) }}">
                    <button class="button button-danger">Delete Template</button>
                </a>
            </div>
        </div>
    </div>

    <h2 class="font-semibold tracking-widest mt-3 mb-3">Products</h2>

    <div class="table-container">
        <table class="table">
            <thead>
            <tr>
                <th>Product Code</th>
                <th>Name</th>
                <th class="text-right">Quantity</th>
            </tr>
            </thead>
            <tbody>
            @foreach($saved_basket as $item)
                <tr class="{{ !$item->price ? 'bg-red-200' : '' }}">
                    <td>{{ $item->product }}</td>
                    <td>{{ $item->name ?: 'Not Available' }}</td>
                    <td class="text-right">{{ $item->quantity }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="text-right">
        <div class="text-red-600 mb-3">
            <small>* Items marked in red are no longer available for purchase and will not be added.</small>
        </div>

        <a href="{{ route('saved-baskets.copy', ['id' => $saved_basket->first()->id]) }}">
            <submit-button before-text="Add to basket" after-text="Adding to basket"></submit-button>
        </a>
    </div>
@endsection
