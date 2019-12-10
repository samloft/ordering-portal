<div class="w-1/4 pr-5 sidebar">
    @if (auth()->user()->admin || count(auth()->user()->customers) > 0)
        <h4>{{ __('Change Customer') }}</h4>

        <customer-switch :user="{{ json_encode(auth()->user()->load('customers'), true) }}"></customer-switch>

    @endif

    <h4>{{ __('Search') }}</h4>

    <form class="w-100" action="{{ route('products.search') }}" method="get">
        <div class="relative">
            <input type="text" class="form-control" name="query" autocomplete="off" required>
            <button class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-600">
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
