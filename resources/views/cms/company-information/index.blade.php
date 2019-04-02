@extends('cms.layout.master')

@section('page.title', 'Company Information')

@section('content')
    <div class="container-fluid page__heading-container">
        <div class="page__heading d-flex align-items-center">
            <div class="flex">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Company Information</li>
                    </ol>
                </nav>
                <h1 class="m-0">Company Information</h1>
            </div>
        </div>
    </div>


    <div class="container-fluid page__container">
        @include('cms.layout.alerts')
    </div>
@endsection