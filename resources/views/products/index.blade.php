@extends('layout.master')

@section('page.title', 'Products')

@section('content')
    <div class="row product-sidebar">
        <div class="col-lg-3">
            @if (Auth::user()->admin)
                <div class="row">
                    <div class="col">
                        <form class="w-100" action="">
                            <div class="form-group">
                                <label>{{ __('Change Customer') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control">
                                    <div class="input-group-append">
                                        <button class="input-group-text"><i class="fas fa-user"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col">
                    <form class="w-100" action="">
                        <div class="form-group">
                            <label>{{ __('Search') }}</label>
                            <div class="input-group">
                                <input type="text" class="form-control">
                                <div class="input-group-append">
                                    <button class="input-group-text"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <form action="">
                        <div class="form-group mb-1">
                            <label>{{ __('Quick Buy') }}</label>
                            <input class="form-control" placeholder="{{ __('Enter Product Code') }}">
                        </div>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{ __('Qty:') }}</span>
                            </div>
                            <input class="form-control mr-2" value="{{ __('1') }}">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button">{{ __('Add To Basket') }}</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label>{{ __('Categories') }}</label>

                    <ul class="list-group w-100">
                        <li class="list-group-item" style="background-color: rgba(254, 245, 108, 1.0)">Electrical
                            Accessories
                        </li>
                        <li class="list-group-item" style="background-color: rgba(229, 235, 139, 1.0)">Ovia Lighting
                        </li>
                        <li class="list-group-item" style="background-color: rgba(198, 224, 159, 1.0)">Inceptor</li>
                        <li class="list-group-item" style="background-color: rgba(167, 216, 184, 1.0)">FlameGuard</li>
                        <li class="list-group-item" style="background-color: rgba(130, 206, 202, 1.0)">Click Smart</li>
                    </ul>
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
