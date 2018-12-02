@extends('layout.master')

@section('page.title', 'Home')

@section('content')
    <div class="row">
        <div class="col-md-3 home-sidebar">
            {!! \App\Models\Pages::show('sidebar')->contents !!}
        </div>
        <div class="col-md-8">
            {!! \App\Models\Pages::show('products')->contents !!}
        </div>
    </div>
@endsection
