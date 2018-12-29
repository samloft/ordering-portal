@extends('layout.master')

@section('page.title', 'Order Tracking')

@section('content')
    <h1 class="page-title">{{ __('Order Tracking') }}</h1>

    <div class="row">
        <div class="col-lg-4 d-flex align-items-stretch">
            <div class="card card-body">
                <h2 class="section-title">{{ __('Search Orders') }}</h2>

                <div class="form-group">
                    <label>{{ __('Order Number') }}</label>
                    <input class="form-control">
                </div>

                <div class="form-group">
                    <label>{{ __('Order Reference') }}</label>
                    <input class="form-control">
                </div>

                <div class="form-group">
                    <label>{{ __('Order Status') }}</label>
                    <select class="form-control">
                        <option value=""></option>
                    </select>
                </div>

                <label>{{ __('Date Range') }}</label>

                <button class="btn btn-blue btn-block">{{ __('Search Orders') }}</button>
            </div>
        </div>
        <div class="col-lg-8 d-flex align-items-stretch">
            <div class="card card-body">
                <h2 class="section-title">{{ __('Search Results') }}</h2>

                <table class="table table-striped table-hover table-support">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Order Number</th>
                        <th scope="col">Order Reference</th>
                        <th scope="col">Order Status</th>
                        <th scope="col">Order Date</th>
                        <th scope="col" class="text-right">Order Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>B091679</td>
                        <td>TEST DO NOT PROCESS</td>
                        <td>Cancelled</td>
                        <td>20/12/2018</td>
                        <td class="text-right">£0.00</td>
                    </tr>
                    <tr>
                        <td>B091679</td>
                        <td>TEST DO NOT PROCESS</td>
                        <td>Cancelled</td>
                        <td>20/12/2018</td>
                        <td class="text-right">£0.00</td>
                    </tr>
                    <tr>
                        <td>B091679</td>
                        <td>TEST DO NOT PROCESS</td>
                        <td>Cancelled</td>
                        <td>20/12/2018</td>
                        <td class="text-right">£0.00</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection