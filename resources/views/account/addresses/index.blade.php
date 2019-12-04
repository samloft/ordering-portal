@extends('layout.master')

@section('page.title', 'Addresses')

@section('content')
    <div class="w-full mb-5 text-center">
        <h2 class="font-semibold tracking-widest">{{ __('Addresses') }}</h2>
        <p class="font-thin">
            {{ __('Update or create delivery addresses') }}
        </p>
    </div>

    @include('layout.alerts')

    @if ($addresses)
        @foreach ($addresses as $address)
            <div class="{{ $address->default ? 'bg-primary text-white' : 'bg-white' }} rounded-lg shadow p-4 mb-3">
                <div class="flex justify-between items-center">
                    <div>
                        <div class="font-medium">{{ $address->company_name }}</div>
                        <div>{{ $address->address_line_2 }}</div>
                        <div>{{ $address->address_line_3 }}</div>
                        <div>{{ $address->address_line_4 }}</div>
                        <div>{{ $address->address_line_5 }}</div>
                        <div>{{ $address->postcode }}</div>
                    </div>
                    <div class="text-right">
                        @if ($checkout)
                            <a href="{{ route('account.address.select', ['id' => $address->id]) }}" class="btn-link">
                                <button class="btn btn-block btn-sm btn-blue mb-1">{{ __('Select Address') }}</button>
                            </a>
                        @else
                            @if ($address->default)
                                <h4 class="text-white text-center text-1xl">{{ __('Default Address') }}</h4>
                            @else
                                <form method="post" action="{{ route('account.address.default') }}" class="mb-1">
                                    <button class="button button-inverse button-block" name="id" value="{{ $address->id }}">
                                        {{ __('Set As Default') }}
                                    </button>
                                </form>
                            @endif

                            <a href="{{ route('account.address.edit', [$address->id]) }}">
                                <button class="button button-primary button-block mb-1">{{ __('Edit Address') }}</button>
                            </a>

                            <button id="delete-address" class="button button-danger button-block"
                                    value="{{ $address->id }}">{{ __('Remove Address') }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        <div class="mb-5 mt-5">
            {{ $addresses->appends(request()->input())->links('layout.pagination') }}
        </div>
    @else
        <div class="text-center mt-5 mb-5">
            <h2>{{ __('You currently have no delivery addresses, click below to add one.') }}</h2>
        </div>
    @endif

    <div class="flex justify-between">
        <a href="{{ route('account') }}">
            <button class="button button-inverse">{{ __('Cancel') }}</button>
        </a>
        <a href="@if($checkout) {{ route('account.address.create', ['checkout' => $checkout]) }} @else {{ route('account.address.create') }} @endif">
            <button class="button button-primary">{{ __('Add New Address') }}</button>
        </a>
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
