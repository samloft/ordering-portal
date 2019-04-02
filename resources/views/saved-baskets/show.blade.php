@extends('layout.master')

@section('page.title', 'Saved Baskets')

@section('content')
    <h1 class="page-title">{{ __('Saved Basket Details') }}</h1>

    <div class="row">
        <div class="col-lg-4">
            <div class="card card-body">

                <div class="row mb-2">
                    <div class="col">{{ ('Template Reference:') }}</div>
                    <div class="col">{{ $saved_basket->first()->reference }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col">{{ ('Date Saved:') }}</div>
                    <div class="col">{{ date('d/m/Y', strtotime($saved_basket->first()->created_at)) }}</div>
                </div>

                <div class="mt-3 row">
                    <div class="col">
                        <button class="btn btn-blue btn-block">{{ __('Back') }}</button>
                    </div>
                    <div class="col">
                        <a class="btn-link"
                           href="{{ route('saved-baskets.destroy', ['id' => $saved_basket->first()->id]) }}">
                            <button class="btn btn-outline-danger btn-block">{{ __('Delete Template') }}</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card card-body">
                <table class="table table-striped table-hover table-support">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">{{ __('Product Code') }}</th>
                        <th scope="col">{{ __('Name') }}</th>
                        <th scope="col" class="text-right">{{ __('Quantity') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($saved_basket as $item)
                        <tr {{ !$item->price ? 'class=text-danger' : '' }}>
                            <td>{{ $item->product }}</td>
                            <td>{{ $item->name }}</td>
                            <td class="text-right">{{ $item->quantity }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <span class="text-danger mb-3">
                    {{ __('* Items marked in red are no longer available for purchase and will not be added.') }}
                </span>

                <div class="text-right">
                    <a href="{{ route('saved-baskets.copy', ['id' => $saved_basket->first()->id]) }}">
                        <button class="btn btn-primary">{{ __('Add to basket') }}</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection