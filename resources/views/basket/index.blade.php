@extends('layout.master')

@section('page.title', 'Basket')

@section('content')
    <div class="row">
        <div class="col">
            <h1 class="page-title">{{ __('Basket') }}</h1>
        </div>
        <div class="col text-right">
            Tracking Stuffs
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7"></div>
        <div class="col-lg-5 justify-content-end">
            <div class="card card-body quick-buy-basket">
                <div class="form-group">
                    <label><strong>{{ __('Quick Buy') }}</strong></label>
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Enter Product Code">
                        </div>
                        <div class="col-2">
                            <input type="text" class="form-control text-center" value="1">
                        </div>
                        <div class="col-4">
                            <button class="btn btn-block btn-primary">Add To Basket</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-basket">
        <thead>
        <tr>
            <th>Product</th>
            <th>Code</th>
            <th>Unit</th>
            <th>Stock (†)</th>
            <th>Net Price</th>
            <th>Total Price</th>
        </tr>
        </thead>
    </table>

    <div class="text-center"><h2>No items are in your basket</h2></div>

    <div class="row mt-5">
        <div class="col-lg-7"></div>
        <div class="col-lg-5 justify-content-end">
            <div class="card card-body basket-summary">
                <div class="row">
                    <div class="col">Goods Total</div>
                    <div class="col text-right">£0.00</div>
                </div>
                <div class="row">
                    <div class="col">Shipping</div>
                    <div class="col text-right">£0.00</div>
                </div>
                <div class="row">
                    <div class="col">Sub Total</div>
                    <div class="col text-right">£0.00</div>
                </div>
                <div class="row">
                    <div class="col">Small Order Charge*</div>
                    <div class="col text-right">£0.00</div>
                </div>
                <div class="row">
                    <div class="col">VAT</div>
                    <div class="col text-right">£0.00</div>
                </div>
                <hr>
                <div class="row basket-total">
                    <div class="col">Order Total</div>
                    <div class="col text-right">£0.00</div>
                </div>
                <hr>
                <div class="small-print">
                    <div class="row">
                        <div class="col">*orders below £200 attract a £10 small order charge, unless you are collecting
                            your order.
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">† Stock levels are only accurate at the time the product is first added to the
                            basket.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection