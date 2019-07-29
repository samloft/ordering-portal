@extends('cms.layout.master')

@section('page.title', 'Site contacts')
@section('page.heading', 'Site contacts')

@section('content')
    <div class="container-fluid page__container">
        @include('cms.layout.alerts')

        <div class="text-right mb-3">
            <a href="#">
                <button class="btn btn-primary" id="new-contact">
                    {{ __('Create new contact') }}
                </button>
            </a>
        </div>

        <div class="card card-form">
            <div class="row no-gutters">
                <div class="col-lg-3 card-body">
                    <p><strong class="headings-color">{{ __('Site Contacts') }}</strong></p>

                    <p class="text-muted">
                        {{ __('Site contacts are a list of email address that will show up on the "Contact Us" form.') }}
                    </p>
                </div>

                <div class="col-lg-9 card-form__body">
                    <div class="table-responsive border-bottom">
                        <table class="table mb-0 thead-border-top-0">
                            <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th class="text-right">{{ __('Actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($contacts as $contact)
                                <tr>
                                    <td>{{ $contact->name }}</td>
                                    <td>{{ $contact->email }}</td>
                                    <td class="text-right">
                                        <button id="edit-contact" class="btn btn-sm btn-primary"
                                                value="{{ $contact->id }}">
                                            {{ __('Edit') }}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <div id="contacts-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                </div>

                <form id="user-details" method="POST" action="{{ route('cms.contacts.store') }}">
                    <div class="modal-body card-form__body">
                        <h5 class="card-header__title text-muted mb-3">{{ __('Contact Details') }}</h5>

                        <div class="form-group">
                            <label>{{ __('Name') }}</label>
                            <input class="form-control form-control-sm" name="name">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Email') }}</label>
                            <input type="email" class="form-control form-control-sm" name="email">
                        </div>

                        <div class="modal-footer">
                            <input name="id" hidden>
                            <button id="contact__delete" type="button" class="btn btn-danger">
                                {{ __('Delete') }}
                            </button>

                            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">
                                {{ __('Cancel') }}
                            </button>

                            <button id="contact__save" type="submit" class="btn btn-primary">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $('#new-contact').on('click', function () {
            $('.modal-title').text('Create new contact');
            $('#contact__delete').hide();

            $('#contacts-modal').modal('show');
        });

        $('button[id="edit-contact"]').on('click', function() {
            var id = $(this).val();

            $('.modal-title').text('Edit Contact');
            $('#contact__delete').show();

            $.get('/contacts/view/' + id).done(function (response) {
                $.each(response, function(key, value) {
                    $('input[name="' + key + '"]').val(value);
                });
            });

            $('#contacts-modal').modal('show');
        });

        $('button[id="contact__delete"]').on('click', function () {
            let id = $('input[name="id"]').val();

            return alertConfirmDelete('Delete User?', 'Are you sure you want to delete this user, Once deleted this cannot be un-done.', '/contacts/delete/' + id);
        });
    </script>
@endsection
