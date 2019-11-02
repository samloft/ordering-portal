<div class="w-1/4 pr-5">
    @if (auth()->user()->admin || count(auth()->user()->customers) > 0)
        <h4 class="uppercase mb-3 font-medium tracking-wider">{{ __('Change Customer') }}</h4>

        <form method="POST" action="{{ route('customer.change') }}">
            @if (auth()->user()->admin)

            @else
                <div class="relative mb-2">
                    <select name="customer" class="w-full p-2 rounded border text-gray-600 appearance-none"
                            autocomplete="off">
                        <option
                            value="{{ auth()->user()->customer_code }}" {{ auth()->user()->customer_code === auth()->user()->customer->code ? 'selected' : '' }}>
                            {{ auth()->user()->customer_code }}
                        </option>

                        @foreach(auth()->user()->customers as $customer)
                            <option
                                value="{{ $customer->customer_code }}" {{ auth()->user()->customer->code === $customer->customer_code ? 'selected' : '' }}>
                                {{ $customer->customer_code }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                        </svg>
                    </div>
                </div>
            @endif

            <button class="button button-primary button-block">{{ __('Change customer') }}</button>
        </form>
    @endif

    <div class="row">
        <div class="col">

            <h4 class="uppercase mb-3 font-medium tracking-wider">{{ __('Search') }}</h4>

            <form class="w-100" action="{{ route('products.search') }}" method="get">
                <div class="form-group">
                    <div class="input-group">
                        <div class="relative">
                            <input type="text" class="form-control" name="query" autocomplete="off">
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                                <button class="input-group-text"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <h4 class="uppercase mb-3 font-medium tracking-wider">{{ __('Quick Buy') }}</h4>

    <form method="post" id="product-add-basket-quickbuy">
        <input id="quick-buy" class="mb-2" name="product"
               placeholder="{{ __('Enter Product Code') }}" autocomplete="off">

        <div class="flex">
            <div class="align-items-center">
                <span class="mr-2 text-gray-600">{{ __('Qty:') }}</span>
                <input class="w-24 mr-2" name="quantity" value="1" autocomplete="off">
            </div>
            <button class="button button-primary flex-grow" name="quick_buy_submit"
                    type="submit">{{ __('Add to basket') }}</button>
        </div>
    </form>

    <div class="row mb-2">
        <div class="col">
            <h4 class="uppercase mb-3 font-medium tracking-wider">{{ __('Categories') }}</h4>

            <ul class="">
                @foreach($category_list as $key => $category)
                    <li class="py-2">
                        <a href="{{ route('products', $category_list[$key]['url']) }}">
                            {{ $category_list[$key]['name'] }}
                            @if (count($category_list[$key]['sub']) > 0)
                                <span class="float-right pt-1">
                                <i class="fas {{ $categories['level_1'] === $category_list[$key]['name'] ? 'fa-chevron-down' : 'fa-chevron-right' }}"></i>
                            </span>
                            @endif
                        </a>
                    </li>
                    @if ($categories['level_1'] === $category_list[$key]['name'] && count($category_list[$key]['sub']) > 0)
                        <ul class="">
                            @foreach ($category_list[$key]['sub'] as $level_2)
                                <li class="py-1 pl-2">
                                    <a href="{{ route('products', [$category_list[$key]['url'], $level_2['url']]) }}"
                                       class="{{ $categories['level_2'] === $level_2['name'] ? 'font-weight-bold' : '' }}">
                                        {{ $level_2['name'] }}
                                        @if (count($level_2['sub']) > 0)
                                            <span class="float-right pt-1"><i
                                                    class="fas {{ $categories['level_2'] === $level_2['name'] ? 'fa-chevron-down' : 'fa-chevron-right' }}"></i></span>
                                        @endif
                                    </a>
                                </li>
                                @if ($categories['level_2'] === $level_2['name'] && count($level_2['sub']) > 0)
                                    <ul class="pl-4">
                                        @foreach ($level_2['sub'] as $level_3)
                                            <li class="py-1">
                                                <a href="{{ route('products', [$category_list[$key]['url'], $level_2['url'], $level_3['url']]) }}"
                                                   class="{{ $categories['level_3'] === $level_3['name'] ? 'font-weight-bold' : '' }}">
                                                    {{ $level_3['name'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>
