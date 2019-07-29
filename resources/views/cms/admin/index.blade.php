@extends('cms.layout.master')

@section('page.title', 'Admin Users')
@section('page.heading', 'Admin Users')

@section('content')
    <div class="container-fluid page__container">
        @include('cms.layout.alerts')

        <div class="text-right mb-3">
            <a href="#">
                <button class="btn btn-primary" id="new-admin">
                    {{ __('Create new admin') }}
                </button>
            </a>
        </div>

        <div class="card card-form">
            <div class="row no-gutters">
                <div class="col-lg-3 card-body">
                    <p><strong class="headings-color">{{ __('Site Users (Customers)') }}</strong></p>

                    <p class="text-muted">
                        {{ __('Admin users are users that have access to use the CMS.') }}
                    </p>
                </div>

                <div class="col-lg-9 card-form__body">
                    <div class="table-responsive border-bottom">
                        <table class="table mb-0 thead-border-top-0">
                            <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Created At') }}</th>
                                <th class="text-right">{{ __('Actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->first_name . ' ' . $user->last_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d-m-Y H:i:s') }}</td>
                                    <td class="text-right">
                                        <button id="edit-admin" class="btn btn-sm btn-primary"
                                                value="{{ $user->id }}">
                                            {{ __('Edit') }}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $users->appends($_GET)->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <div id="admin-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                </div>

                <form id="user-details" method="POST" action="{{ route('cms.site-users.store') }}">
                    <div class="modal-body card-form__body">
                        <h5 class="card-header__title text-muted mb-3">{{ __('Admin Details') }}</h5>

                        <div class="form-group">
                            <label>{{ __('First Name') }}</label>
                            <input class="form-control form-control-sm" name="first_name">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Last Name') }}</label>
                            <input class="form-control form-control-sm" name="last_name">
                        </div>

                        <hr>

                        <h5 class="card-header__title text-muted mb-3">{{ __('Admin Account Details') }}</h5>

                        <div class="form-group">
                            <label>{{ __('Email') }}</label>
                            <input type="email" class="form-control form-control-sm" name="email">
                        </div>

{{--                        <div class="form-group">--}}
{{--                            <label>{{ __('Password') }}</label>--}}
{{--                            <input type="password" class="form-control form-control-sm" name="password">--}}
{{--                        </div>--}}

                        <div class="modal-footer">
                            <input name="id" hidden>
                            <button id="admin__delete" type="button" class="btn btn-danger">
                                {{ __('Delete') }}
                            </button>

                            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">
                                {{ __('Cancel') }}
                            </button>

                            <button id="admin__save" type="submit" class="btn btn-primary">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $('#new-admin').on('click', function () {
            $('.modal-title').text('Create new admin');

            $('#admin__delete').hide();

            $('#admin-modal').modal('show');
        });
    </script>
@endsection
