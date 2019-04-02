@extends('cms.layout.master')

@section('page.title', 'Home Links')

@section('content')
    <div class="container-fluid page__container">
        @include('cms.layout.alerts')

        <div class="text-right mb-3">
            <button id="home-link__create" class="btn btn-primary">{{ __('New home link') }}</button>
        </div>

        <div class="card card-form">
            <div class="row no-gutters">
                <div class="col-lg-4 card-body">
                    <p><strong class="headings-color">{{ __('Adverts') }}</strong></p>

                    <p class="text-muted">
                        {{ __('Create/Delete advert images/links and adjust the position that the adverts will display on the home page.') }}
                    </p>

                    <div class="text-center">
                        <img src="{{ asset('images/advert-wireframe.png') }}" alt="advert-wireframe">
                    </div>
                </div>
                <div class="col-lg-8 card-form__body">
                    <div class="sortable-list__container">
                        <small>{{ __('* Drag items to change the position they are displayed.') }}</small>

                        @if(count($adverts) > 0)
                            <ul id="adverts">
                                @foreach($adverts as $advert)
                                    <li id="{{ $advert->id }}">
                                        {{ explode('-', $advert->name)[1] }}
                                        <button value="{{ $advert->id }}"
                                                id="home-link__edit"
                                                class="float-right btn btn-outline-info">{{ __('Edit') }}</button>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <h5 class="text-center mt-5 mb-5">{{ __('No advert links have been added yet.') }}</h5>
                        @endif
                    </div>

                    <div class="sortable-list__footer">
                        <button id="save-adverts" class="btn btn-secondary">{{ __('Save Changes') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-form">
            <div class="row no-gutters">
                <div class="col-lg-4 card-body">
                    <p><strong class="headings-color">{{ __('Categories') }}</strong></p>

                    <p class="text-muted">
                        {{ __('Create/Delete category images/links and adjust the position that the categories will display on the home & product page.') }}
                    </p>

                    <div class="text-center">
                        <img src="{{ asset('images/category-wireframe.png') }}" alt="category-wireframe">
                    </div>
                </div>
                <div class="col-lg-8 card-form__body">
                    <div class="sortable-list__container">
                        <small>{{ __('* Drag items to change the position they are displayed.') }}</small>

                        @if($categories->contains('type', 'category'))
                            <ul id="categories">
                                @foreach($categories as $category)
                                    @if($category->type === 'category')
                                        <li id="{{ $category->id }}">
                                            {{ explode('-', $category->name)[1] }}
                                            <button value="{{ $category->id }}"
                                                    id="home-link__edit"
                                                    class="float-right btn btn-outline-info">{{ __('Edit') }}</button>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        @else
                            <h5 class="text-center mt-5 mb-5">{{ __('No category links have been added yet.') }}</h5>
                        @endif
                    </div>

                    <div class="sortable-list__footer">
                        <button id="save-categories" class="btn btn-secondary">{{ __('Save Changes') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <div id="page-links-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="page-links-modal__title"></h5>
                </div>
                <form id="home-link__form" method="post" action="{{ route('cms.home-links.store') }}"
                      enctype="multipart/form-data">
                    <div class="modal-body">
                        <div id="home-link__type" class="form-group">
                            <label>{{ __('Link Type') }}</label>
                            <select class="form-control" name="type">
                                <option value="advert">{{ __('Advert') }}</option>
                                <option value="category">{{ __('Category') }}</option>
                            </select>
                        </div>

                        <div id="home-link__name" class="form-group">
                            <label>{{ __('Name') }}</label>
                            <input class="form-control" name="name">
                        </div>

                        <div class="form-group">
                            <label>{{ __('Image') }}</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="image">
                                <label id="home-link__image-label" class="custom-file-label" for="customFile"></label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Link') }} <small class="text-danger">{{ __('For advert links, please include http://') }}</small></label>
                            <input class="form-control" name="link">
                        </div>

                        <input id="home-link__id" name="id" hidden>
                    </div>
                    <div class="modal-footer">
                        <button id="home-link__delete" type="button" class="btn btn-danger">
                            {{ __('Delete') }}
                        </button>

                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">
                            {{ __('Cancel') }}
                        </button>

                        <button type="submit" class="btn btn-primary">
                            {{ __('Save Changes') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $('button[id="home-link__create"]').on('click', function () {
            $('#home-link__type').show();
            $('#home-link__name').show();
            $('#page-links-modal__title').text('Create Home Page Link');
            $('#home-link__form').trigger('reset');
            $('#home-link__image-label').text('Select image');
            $('#home-link__delete').val('').hide();

            $('#page-links-modal').modal('show');
        });

        $(document).on('click', 'button[id="home-link__edit"]', function () {
            var linkId = $(this).val(),
                linkForm = '#home-link__form';

            $('#page-links-modal__title').text('Edit Home Page Link');
            $('#home-link__image-label').text('Change image');
            $('#home-link__type').hide();
            $('#home-link__name').hide();
            $('#home-link__delete').val(linkId).show();
            $('#home-link__id').val(linkId);

            $.post('{{ route('cms.home-links.show') }}', {
                id: linkId
            }).done(function (response) {
                if (response) {
                    // $(linkForm + ' select[name="type"]').val(response.type);
                    // $(linkForm + ' input[name="name"]').val(response.name);
                    $(linkForm + ' input[name="link"]').val(response.link);

                    $('#page-links-modal').modal('show');
                } else {
                    return alert('Link data not found');
                }
            }).fail(function (response) {
                return alert('Unable to get link data');
            });
        });

        $(document).on('click', 'button[id="home-link__delete"]', function () {
            var linkId = $(this).val();

            $.confirm({
                title: 'Delete Record?',
                content: 'Are you sure you want to delete this record? Once delete this cannot be un-done.',
                buttons: {
                    confirm: {
                        text: 'Confirm Delete',
                        btnClass: 'btn-danger',
                        action: function () {
                            $('#page-links-modal').modal('hide');
                            window.location.replace('/home-links/delete/' + linkId);
                        }
                    },
                    cancel: {
                        text: 'Cancel',
                        btnClass: 'btn-blue',
                    }
                }
            });
        });

        $('.custom-file-input').on('change', function () {
            var fileName = $(this).val().split('\\').slice(-1)[0];

            $('#home-link__image-label').text(fileName);
        });

        $('#adverts').sortable({
            stop: function (event, ui) {
                var itemOrder = $('#adverts').sortable("toArray");

                for (var i = 0; i < itemOrder.length; i++) {
                    console.log("Position: " + (i + 1) + " ID: " + itemOrder[i]);
                }
            }
        }).disableSelection();

        $('#categories').sortable({
            stop: function (event, ui) {
                var itemOrder = $('#categories').sortable("toArray");

                for (var i = 0; i < itemOrder.length; i++) {
                    console.log("Position: " + (i + 1) + " ID: " + itemOrder[i]);
                }
            }
        }).disableSelection();

        $('button[id="save-adverts"]').on('click', function () {
            updateLinkOrders('#adverts');
        });

        $('button[id="save-categories"]').on('click', function () {
            updateLinkOrders('#categories');
        });

        function updateLinkOrders(div) {
            var itemOrder = $(div).sortable('toArray'),
                itemList = [];

            for (var i = 0; i < itemOrder.length; i++) {
                var item = {
                    'id': itemOrder[i],
                    'position': (i + 1)
                };

                itemList.push(JSON.stringify(item));
            }

            $.post('{{ route('cms.home-links.update') }}', {
                items: itemList
            }).done(function (response) {
                if (response) {
                    return topAlert('success', 'Home link positions have been updated.', 3, true);
                }

                return topAlert('error', 'Unable to change home link positions, please try again.', 3, true);
            }).fail(function (response) {
                return topAlert('error', 'Unable to change home link positions, please try again.', 3, true);
            })
        }

        function topAlert(type, message, duration, overlay) {
            return $("body").overhang({
                type: type,
                message: message,
                duration: duration,
                overlay: overlay
            });
        }
    </script>
@endsection