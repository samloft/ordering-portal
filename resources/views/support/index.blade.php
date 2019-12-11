@extends('layout.master')

@section('page.title', $title)

@section('content')
    <div class="content container">
        <h1 class="page-title">{{ $title }}</h1>

        <div class="card card-body">
            {!! $content !!}
        </div>
    </div>
@endsection
