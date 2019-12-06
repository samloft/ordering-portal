<div class="w-1/4 pr-5 sidebar">
    @if (auth()->user()->admin || count(auth()->user()->customers) > 0)
        <h4>{{ __('Change Customer') }}</h4>

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

            <button class="button button-primary button-block">{{ __('Change Customer') }}</button>
        </form>
    @endif

    <h4>{{ __('Search') }}</h4>

    <form class="w-100" action="{{ route('products.search') }}" method="get">
        <div class="relative">
            <input type="text" class="form-control" name="query" autocomplete="off" required>
            <button class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>

    <h4>{{ __('Quick Buy') }}</h4>

    <quick-buy class="mb-4"></quick-buy>

    <h4>{{ __('Categories') }}</h4>

    <ul class="categories-nav">
        @foreach($category_list as $key => $category)
            <li class="top-level">
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
                <ul class="sub-categories">
                    @foreach ($category_list[$key]['sub'] as $level_2)
                        <li class="py-1 pl-2">
                            <a href="{{ route('products', [$category_list[$key]['url'], $level_2['url']]) }}"
                               class="{{ $categories['level_2'] === $level_2['name'] ? 'active' : '' }}">
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
                                           class="{{ $categories['level_3'] === $level_3['name'] ? 'active' : '' }}">
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
