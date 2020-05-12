@extends('layout.master')

@section('page.title', 'Order Upload')

@section('content')
    <div class="w-full mb-5 text-center">
        <h2 class="font-semibold tracking-widest">Order Upload</h2>
        <p class="font-thin">
            Upload your order for a faster ordering process
        </p>
    </div>

    <div class="bg-white rounded shadow-md p-6">
        @include('layout.alerts')

        <div class="flex-none md:flex">
            <div class="sm:w-full md:w-1/3 md:pr-10 mb-3 md:mb-0">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Order Upload
                </h3>

                <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
                    Upload your order with a simple CSV file, entering product code in column A and quantity in column B
                </p>

                @if($config['prices'])
                    <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500 mt-3">
                        <span class="font-semibold">Optional:</span> Add your price in column C and we will validate
                        your prices for you, you can also add price
                        tolerance above the order upload to configure it to be less strict.
                    </p>
                @endif

                @if($config['packs'])
                    <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500 mt-3">
                        <span class="font-semibold">Optional:</span> Select the packs checkbox if you prefer to buy in
                        pack quantities.
                    </p>
                @endif
            </div>

            <div class="sm:w-full md:w-2/3">
                <form method="post" action="{{ route('upload-validate') }}" enctype="multipart/form-data" class="mb-0">
                    @if($config['prices'])
                        <div class="w-full">
                            <div class="mb-3 flex items-center justify-end">
                                <div class="ld:w-1/4 md:w-2/2">
                                    <label for="price-tolerance">Price Tolerance <span
                                            class="text-xs">(optional)</span></label>
                                    <input id="price-tolerance" name="tolerance" placeholder="E.G 0.0020">
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($config['packs'])
                        <div class="w-full">
                            <div class="mb-3 flex items-center justify-end">
                                <label class="checkbox flex items-center">
                                    <span class="mr-2">Order in pack QTYs?</span>
                                    <input type="checkbox" class="form-checkbox"
                                           name="packs" {{ old('packs') ? 'checked' : '' }}>
                                </label>
                            </div>
                        </div>
                    @endif

                    <order-upload></order-upload>
                </form>
            </div>
        </div>
    </div>
@endsection
