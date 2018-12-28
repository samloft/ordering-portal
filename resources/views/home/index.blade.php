@extends('layout.master')

@section('page.title', 'Home')

@section('content')
    <div class="row">
        <div class="col-sm-3 home-sidebar">
{{--            {!! \App\Models\Pages::show('sidebar')->contents !!}--}}
            <div class="row">
                <div class="col">
                    <img class="img-fluid" src="https://scolmoreonline.com/assets/images/gridpro_button2.png">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <img class="img-fluid" src="https://scolmoreonline.com/assets/images/gridpro_button2.png">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <img class="img-fluid" src="https://scolmoreonline.com/assets/images/gridpro_button2.png">
                </div>
            </div>
        </div>
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
