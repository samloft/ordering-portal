@extends('cms.layout.master')

@section('page.title', 'Site Users')
@section('page.heading', 'Site Users')

@section('content')
    <div class="container-fluid page__container">
        @include('cms.layout.alerts')

        <div class="text-right mb-3">
            <a href="#">
                <button class="btn btn-primary" id="new-user">
                    {{ __('Create new user') }}
                </button>
            </a>
        </div>

        <div class="card card-form">
            <div class="row no-gutters">
                <div class="col-lg-3 card-body">
                    <p><strong class="headings-color">{{ __('Site Users (Customers)') }}</strong></p>

                    <p class="text-muted">
                        {{ __('Site users are users that have access to use online ordering.') }}
                    </p>

                    <p class="text-muted">
                        {{ __('Each site user has a default customer that they can purchase as, they can also have extra customers,
                        this allows site users to switch between customers.') }}
                    </p>
                </div>
                <div class="col-lg-9 card-form__body">
                    <form method="GET" action="{{ route('cms.site-users') }}" class="m-3">
                        <div class="search-form search-form--light">
                            <input type="text" class="form-control" name="search"
                                   placeholder="Search for name, email, username & default customer">
                            <button class="btn" type="button" role="button"><i class="material-icons">search</i>
                            </button>
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
                                <th>{{ __('Extra Customers') }}</th>
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
                                    <td><span class="badge badge-info">{{ $site_user->customers->count() }}</span></td>
                                    <td>
                                        @if ($site_user->admin)
                                            <span class="badge badge-warning">{{ __('ADMIN') }}</span>
                                        @else
                                            <span class="badge badge-success">{{ __('USER') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $site_user->email }}</td>
                                    <td class="text-right">
                                        <button id="edit-user" class="btn btn-sm btn-primary"
                                                value="{{ $site_user->id }}">
                                            {{ __('Edit') }}
                                        </button>
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

@section('scripts')
    <div id="user-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>

                    <div class="pull-right">
                        <button id="extra-customers" class="btn btn-sm btn-warning">{{ __('Extra Customers') }}</button>
                    </div>
                </div>

                <form id="user-details" method="POST" action="{{ route('cms.site-users.store') }}">
                    <div class="modal-body card-form__body">
                        <h5 class="card-header__title text-muted mb-3">{{ __('User Details') }}</h5>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>{{ __('First Name') }}</label>
                                    <input class="form-control form-control-sm" name="first_name">
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Last Name') }}</label>
                                    <input class="form-control form-control-sm" name="last_name">
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Telephone') }}</label>
                                    <input class="form-control form-control-sm" name="telephone">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>{{ __('Evening Telephone') }}</label>
                                    <input class="form-control form-control-sm" name="evening_telephone">
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Mobile') }}</label>
                                    <input class="form-control form-control-sm" name="mobile">
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Fax') }}</label>
                                    <input class="form-control form-control-sm" name="fax">
                                </div>
                            </div>
                        </div>

                        <hr>

                        <h5 class="card-header__title text-muted mb-3">{{ __('Account Details') }}</h5>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>{{ __('Username') }}</label>
                                    <input class="form-control form-control-sm" name="username">
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Password') }}</label>
                                    <input type="password" class="form-control form-control-sm" name="password">
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Email') }}</label>
                                    <input type="email" class="form-control form-control-sm" name="email">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>{{ __('Default Customer') }}</label>
                                    <input class="form-control form-control-sm" name="customer_code">
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Can Order?') }}</label>
                                    <select class="form-control form-control-sm" name="can_order">
                                        <option value="1">{{ __('Yes') }}</option>
                                        <option value="0">{{ __('No') }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Admin Account?') }}</label>
                                    <select class="form-control form-control-sm" name="admin">
                                        <option value="0">{{ __('No') }}</option>
                                        <option value="1">{{ __('Yes') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input name="id" hidden>
                        <button id="user__delete" type="button" class="btn btn-danger">
                            {{ __('Delete') }}
                        </button>

                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">
                            {{ __('Cancel') }}
                        </button>

                        <button id="user__save" type="submit" class="btn btn-primary">
                            {{ __('Save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="extra-customers-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"
         data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Extra Customers') }}</h5>

                    <div class="pull-right">
                        <button id="add-extra-customer" class="btn btn-sm btn-warning">
                            {{ __('Add Customer') }}
                        </button>
                    </div>
                </div>

                <div class="modal-body card-form__body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>{{ __('Customer') }}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <div class="modal-footer">
                    <button id="extra-customers-close" class="btn btn-outline-danger">
                        {{ __('Close') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="add-extra-customers-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"
         data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Add Extra Customer') }}</h5>
                </div>

                <form id="extra-customer-store">
                    <div class="modal-body card-form__body">
                        <div class="form-group">
                            <label>Customer Code</label>
                            <input class="form-control form-control-sm" name="customer_code">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <input name="user_id" hidden>
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

                        <button type="button" id="add-extra-customers-close" class="btn btn-outline-danger">
                            {{ __('Close') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $('button[id="new-user"]').on('click', function () {
            removeInputErrors();
            $('#user-details .invalid-feedback').remove();

            $('#user-modal #extra-customers').hide();
            $('#user-modal .modal-title').text('Create User');
            $('#user-modal #user__delete').hide();

            return $('#user-modal').modal('show');
        });

        $('button[id="edit-user"]').on('click', function () {
            let id = $(this).val();

            $('#user-details').trigger('reset');
            removeInputErrors();
            $('#user-details .invalid-feedback').remove();

            $.get('/site-users/show/' + id).done(function (response) {
                if (response) {
                    if (response.admin) {
                        $('#extra-customers').attr('disabled', true);
                    } else {
                        $('#extra-customers').attr('disabled', false);
                    }

                    $.each(response, function (key, value) {
                        $('#user-details :input[name="' + key + '"]').val(value);
                    });

                    $.each(response.customers, function (key, value) {
                        addExtraCustomerToTable(value.customer_code, value.id);
                        // $('#extra-customers-modal table tbody').append('<tr>' +
                        //     '<td>' + value.customer_code + '</td>' +
                        //     '<td class="text-right">' +
                        //     '<button id="delete-extra-customer" class="btn btn-sm btn-danger" value="' + value.id + '">Remove</button>' +
                        //     '</td></tr>')
                    });

                    $('#user__delete').val(response.id);
                    $('#add-extra-customer').val(response.id);

                    $('#user-modal #extra-customers').show();
                    // .text('Extra Customers (' + response.customers.length + ')');
                    $('#user-modal .modal-title').text('Edit User');
                    $('#user-modal #user__delete').show();

                    return $('#user-modal').modal('show');
                }

                return alertError('No user data was found, please try again');
            }).fail(function () {
                return alertError('Unable to retrieve user data, please try again');
            });
        });

        $('button[id="user__delete"]').on('click', function () {
            let id = $(this).val();

            return alertConfirmDelete('Delete User?', 'Are you sure you want to delete this user, Once deleted this cannot be un-done.', '/site-users/delete/' + id);
        });

        $('#user-details').on('submit', function (event) {
            event.preventDefault();

            removeInputErrors();

            $.ajax({
                url: '/site-users/validate',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function () {
                    return event.currentTarget.submit();
                },
                error: function (response) {
                    addInputErrors('#user-details', response.responseJSON.errors);
                }
            });
        });

        $('#extra-customers').on('click', function () {
            $('#user-modal').modal('hide');

            $('#extra-customer-store input').removeClass('is-invalid');
            $('#extra-customer-store .invalid-feedback').remove();
            $('#extra-customer-store').trigger('reset');
            $('#extra-customers-modal').modal('show');
        });

        $('#extra-customers-close').on('click', function () {
            $('#extra-customers-modal').modal('hide');
            $('#user-modal').modal('show');
        });

        $('#add-extra-customer').on('click', function () {
            $('#extra-customers-modal').modal('hide');

            $('#extra-customer-store').trigger('reset');
            removeInputErrors();
            $('#extra-customer-store input[name="user_id"]').val($(this).val());
            $('#extra-customer-error').remove();
            $('#add-extra-customers-modal').modal('show');
        });

        $('#add-extra-customers-close').on('click', function () {
            $('#add-extra-customers-modal').modal('hide');
            $('#extra-customers-modal').modal('show');
        });

        $(document).on('click', '#delete-extra-customer', function () {
            let row = $(this).closest('tr'),
                id = $(this).val();

            alertConfirmDelete('Delete Extra User?', 'Are you sure you want to delete this extra user? Once delete this cannot be un-done', null, function (confirmed) {
                if (confirmed) {
                    console.log(true);
                    $.post('/site-users/extra-customers/destroy', {
                        id: id
                    }).done(function () {
                        return row.remove();
                    }).fail(function () {
                        return alert('Oh no!');
                    });
                }
            });
        });

        $('#extra-customer-store').on('submit', function (event) {
            event.preventDefault();
            removeInputErrors();
            $('#extra-customer-error').remove();

            $.ajax({
                url: '/site-users/extra-customers/store',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    addExtraCustomerToTable(response.customer_code, response.id);
                    // $('#extra-customers-modal tbody').append('<tr>' +
                    //     '<td>' + response.customer_code + '</td>' +
                    //     '<td class="text-right"><button id="delete-extra-customer" class="btn btn-sm btn-danger" value="' + response.id + '">Remove</button></td>' +
                    //     '</tr>');

                    $('#add-extra-customers-modal').modal('hide');
                    $('#extra-customers-modal').modal('show');
                },
                error: function (response) {
                    if (response.responseJSON.errors) {
                        addInputErrors('#extra-customer-store', response.responseJSON.errors);
                    } else {
                        $('#extra-customer-store').prepend('<div id="extra-customer-error" class="alert alert-danger">' + response.error + '</div>');
                    }
                }
            });
        });
    </script>
@endsection