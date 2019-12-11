@extends('layout.master')

@section('page.title', ucwords(str_replace('-', ' ', $support->name)))

@section('content')
    <div class="w-full mb-5 text-center">
        <h2 class="font-semibold tracking-widest">{{ ucwords(str_replace('-', ' ', $support->name)) }}</h2>
    </div>

    {!! $support->description !!}
@endsection
