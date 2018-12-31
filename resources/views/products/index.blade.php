@extends('layout.master')

@section('page.title', 'Products')

@section('content')
    <div class="row">
        @include('products.sidebar')

        <div class="col">
            {{--            {!! \App\Models\Pages::show('products')->contents !!}--}}
            <div class="d-flex flex-wrap">
                <div class="w-20">
                    <img class="img-fluid" src="https://scolmoreonline.com/assets/images/deco-plus.jpg">
                </div>
                <div class="w-20">
                    <img class="img-fluid" src="https://scolmoreonline.com/assets/images/deco-plus.jpg">
                </div>
                <div class="w-20">
                    <img class="img-fluid" src="https://scolmoreonline.com/assets/images/deco-plus.jpg">
                </div>
                <div class="w-20">
                    <img class="img-fluid" src="https://scolmoreonline.com/assets/images/deco-plus.jpg">
                </div>
                <div class="w-20">
                    <img class="img-fluid" src="https://scolmoreonline.com/assets/images/deco-plus.jpg">
                </div>
                <div class="w-20">
                    <img class="img-fluid" src="https://scolmoreonline.com/assets/images/deco-plus.jpg">
                </div>
                <div class="w-20">
                    <img class="img-fluid" src="https://scolmoreonline.com/assets/images/deco-plus.jpg">
                </div>
            </div>
        </div>
    </div>
@endsection
