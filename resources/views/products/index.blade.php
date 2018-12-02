@extends('layout.master')

@section('page.title', 'Products')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @if (Auth::user()->admin)
                <div class="row">
                    <div class="col">
                        <form class="w-100" action="">
                            <div class="form-group">
                                <label>Change Customer</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Enter Customer Code"
                                           aria-label="Customer Code" aria-describedby="basic-addon">
                                    <div class="input-group-append">
                                        <button class="input-group-text" id="basic-addon"><i class="fas fa-user"></i>
                                        </button>
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
                            <label>Search</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Enter Product Code"
                                       aria-label="Product Code" aria-describedby="basic-addon">
                                <div class="input-group-append">
                                    <button class="input-group-text" id="basic-addon"><i class="fas fa-search"></i>
                                    </button>
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
                            <label>Quick Buy</label>
                            <input class="form-control" placeholder="Enter Product Code">
                        </div>

                        <div class="input-group">
                            <input class="form-control mr-2" value="1">
                            <span class="input-group-btn">
                            <button class="btn btn-primary" type="button">Add To Basket</button>
                        </span>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label>Categories</label>

                    <ul class="list-group w-100">
                        <li class="list-group-item">Cat 1</li>
                        <li class="list-group-item">Cat 2</li>
                        <li class="list-group-item">Cat 3</li>
                        <li class="list-group-item">Cat 4</li>
                        <li class="list-group-item">Cat 5</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            {!! \App\Models\Pages::show('products')->contents !!}
        </div>
    </div>
@endsection
