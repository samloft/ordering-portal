@extends('layout.master')

@section('page.title', 'Addresses')

@section('content')
    <h1 class="page-title">{{ __('Delivery Addresses') }}</h1>

    @include('layout.alerts')

    @if (count($addresses) > 0)
        @foreach ($addresses as $address)
            <div class="card card-body mb-2">
                <div class="row">
                    <div class="col-lg-9">
                        <ul class="list-unstyled mb-0">
                            <li><strong>{{ $address->company_name }}</strong></li>
                            <li>{{ $address->address_line_2 }}</li>
                            <li>{{ $address->address_line_3 }}</li>
                            <li>{{ $address->address_line_4 }}</li>
                            <li>{{ $address->address_line_5 }}</li>
                            <li>{{ $address->post_code }}</li>
                        </ul>
                    </div>
                    <div class="col-lg-3 text-right">
                        @if ($address->default)
                            <h3 class="text-center">{{ __('Default Address') }}</h3>
                        @else
                            @if ($checkout)
                                <a href="{{ route('account.address.select', ['id' => $address->id]) }}" class="btn-link">
                                    <button class="btn btn-block btn-sm btn-blue mb-1">{{ __('Select Address') }}</button>
                                </a>
                            @endif
                            <form method="post" action="{{ route('account.address.default') }}" class="mb-1">
                                <button class="btn btn-block btn-sm btn-blue" name="id" value="{{ $address->id }}">
                                    {{ __('Set As Default') }}
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('account.address.edit', [$address->id]) }}" class="btn-link">
                            <button class="btn btn-block btn-sm btn-blue">{{ __('Edit Address') }}</button>
                        </a>

                        <button id="delete-address" class="btn btn-block btn-sm btn-blue mt-1"
                                value="{{ $address->id }}">{{ __('Remove Address') }}
                        </button>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="mb-2">
            {{ $addresses->links('layout.pagination') }}
        </div>
    @else
        <div class="text-center mt-5 mb-5">
            <h2>{{ __('You currently have no delivery addresses, click below to add one.') }}</h2>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-6">
            <a href="{{ route('account') }}" class="btn-link">
                <button class="btn btn-blue">{{ __('Cancel') }}</button>
            </a>
        </div>
        <div class="col-lg-6 text-right">
            <a href="{{ route('account.address.create') }}" class="btn-link">
                <button class="btn btn-primary">{{ __('Add New Address') }}</button>
            </a>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('button[id="delete-address"]').on('click', function () {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this address.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        location.href = '/account/addresses/' + $(this).val() + '/delete';
                    }
                });
        });
    </script>
@endsection