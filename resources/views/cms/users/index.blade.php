@extends('cms.layout.master')

@section('page.title', 'Site Users')
@section('page.heading', 'Site Users')

@section('content')
    <div class="container-fluid page__container">
        @include('cms.layout.alerts')

        <div class="text-right mb-3">
            <a href="#">
                <button class="btn btn-primary">
                    {{ __('Create new user') }}
                </button>
            </a>
        </div>

        <div class="card card-form">
            <div class="row no-gutters">
                <div class="col-lg-3 card-body">
                    <p><strong class="headings-color">{{ __('Site Users (Customers)') }}</strong></p>

                    <p class="text-muted">
                        {{ __('Stuff & Things') }}
                    </p>
                </div>
                <div class="col-lg-9 card-form__body">
                    <form method="GET" action="{{ route('cms.site-users') }}" class="m-3">
                        <div class="search-form search-form--light">
                            <input type="text" class="form-control" name="search" placeholder="Search for name, email, username & default customer">
                            <button class="btn" type="button" role="button"><i class="material-icons">search</i></button>
                        </div>
                    </form>

                    <div class="table-responsive border-bottom">
                        <table class="table mb-0 thead-border-top-0">
                            <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Username') }}</th>
                                <th>{{ __('Can Order') }}</th>
                                <th>{{ __('Default Customer') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th class="text-right">{{ __('Actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($site_users as $site_user)
                                <tr>
                                    <td>{{ $site_user->first_name . ' ' . $site_user->last_name }}</td>
                                    <td>{{ $site_user->username }}</td>
                                    <td>
                                        @if ($site_user->can_order)
                                            <span class="badge badge-primary">{{ __('YES') }}</span>
                                        @else
                                            <span class="badge badge-danger">{{ __('NO') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $site_user->customer_code }}</td>
                                    <td>
                                        @if ($site_user->admin)
                                            <span class="badge badge-warning">{{ __('ADMIN') }}</span>
                                        @else
                                            <span class="badge badge-success">{{ __('USER') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $site_user->email }}</td>
                                    <td class="text-right">
                                        <a href="{{ $site_user->id }}">
                                            <button class="btn btn-sm btn-primary">{{ __('Edit') }}</button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $site_users->appends($_GET)->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection