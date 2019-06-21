@extends('cms.layout.master')

@section('page.title', 'Dashboard')

@section('content')
    <div class="container-fluid page__container">

        <div class="row card-group-row">
            <div class="col-lg-4 col-md-6 card-group-row__col">
                <div class="card card-group-row__card card-body card-body-x-lg flex-row align-items-center">
                    <div class="flex">
                        <div class="card-header__title text-muted mb-2">Current Target</div>
                        <div class="text-amount">£12,920</div>
                        <div class="text-stats text-success">31.5% <i
                                    class="material-icons">arrow_upward</i></div>
                    </div>
                    <div><i class="material-icons icon-muted icon-40pt ml-3">gps_fixed</i></div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 card-group-row__col">
                <div class="card card-group-row__card card-body card-body-x-lg flex-row align-items-center">
                    <div class="flex">
                        <div class="card-header__title text-muted mb-2">Earnings</div>
                        <div class="text-amount">£3,642</div>
                        <div class="text-stats text-success">51.5% <i
                                    class="material-icons">arrow_upward</i></div>
                    </div>
                    <div><i class="material-icons icon-muted icon-40pt ml-3">monetization_on</i></div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 card-group-row__col">
                <div class="card card-group-row__card card-body card-body-x-lg flex-row align-items-center">
                    <div class="flex">
                        <div class="card-header__title text-muted mb-2">{{ __('Site Users') }}</div>
                        <div class="text-amount">{{ $users }}</div>
{{--                        <div class="text-stats text-danger">3.5% <i--}}
{{--                                    class="material-icons">arrow_downward</i></div>--}}
                    </div>
                    <div><i class="material-icons icon-muted icon-40pt ml-3">perm_identity</i></div>
                </div>
            </div>
        </div>
    </div>
@endsection