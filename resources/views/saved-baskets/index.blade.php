@extends('layout.master')

@section('page.title', 'Saved Baskets')

@section('content')
    <h1 class="page-title">{{ __('Saved Basket Templates') }}</h1>

    @include('layout.alerts')

    <div class="row">
        <div class="col-lg-4 d-flex align-items-stretch">
            <div class="card card-body">
                <h2 class="section-title">{{ __('Search Templates') }}</h2>

                <div class="form-group">
                    <label>Template Reference</label>
                    <input class="form-control">
                </div>

                <label>Date Range</label>

                <button class="btn btn-blue btn-block">{{ __('Search Saved Baskets') }}</button>
            </div>
        </div>
        <div class="col-lg-8 d-flex align-items-stretch">
            <div class="card card-body">
                <h2 class="section-title">{{ __('Search Results') }}</h2>

                <table class="table table-striped table-hover table-support">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Template Reference</th>
                        <th scope="col">Saved Date</th>
                        <th scope="col" class="text-right">Delete Template</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($saved_baskets as $basket)
                        <tr class="clickable"
                            onclick="window.location = '{{ route('saved-baskets.show', ['id' => $basket->id]) }}';">
                            <td class="align-middle">{{ $basket->reference }}</td>
                            <td class="align-middle">{{ date('d/m/Y', strtotime($basket->created_at)) }}</td>
                            <td class="text-right">
                                <a href="{{ route('saved-baskets.destroy', ['id' => $basket->id]) }}">
                                    <button id="saved_basket__delete" class="btn btn-outline-danger btn-sm">
                                        {{ __('Delete Template') }}
                                    </button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection