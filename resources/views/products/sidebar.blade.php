<div class="w-1/4 pr-5 sidebar">
    @if (auth()->user()->admin || count(auth()->user()->customers) > 0)
        <h4>Change Customer</h4>

        <customer-switch :user="{{ json_encode(auth()->user()->load('customers'), true) }}"></customer-switch>

    @endif

    <h4 class="mt-4">Search</h4>

    <form class="w-100" action="{{ route('products.search') }}" method="get" class="m-0">
        <div class="relative">
            <input type="text" class="form-control" name="query" autocomplete="off" required>
            <button class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-600 hover:opacity-50">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 icon opacity-75">
                    <circle cx="10" cy="10" r="7" class="primary"></circle>
                    <path class="secondary"
                          d="M16.32 14.9l1.1 1.1c.4-.02.83.13 1.14.44l3 3a1.5 1.5 0 0 1-2.12 2.12l-3-3a1.5 1.5 0 0 1-.44-1.14l-1.1-1.1a8 8 0 1 1 1.41-1.41zM10 16a6 6 0 1 0 0-12 6 6 0 0 0 0 12z"></path>
                </svg>
            </button>
        </div>
    </form>

    <h4 class="mt-4">Quick Buy</h4>

    <quick-buy></quick-buy>

    <h4 class="mt-4">Categories</h4>

    <ul class="categories-nav">
        @foreach($category_list as $key => $category)
            <li class="top-level {{ str_slug(strtolower($category_list[$key]['name'])) }}">
                <a href="{{ route('products', $category_list[$key]['url']) }}">
                    {{ $category_list[$key]['name'] }}
                    @if (count($category_list[$key]['sub']) > 0)
                        <span class="float-right pt-1">
                            @if($categories['level_1'] === $category_list[$key]['name'])
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                      d="M5.29289 7.29289C5.68342 6.90237 6.31658 6.90237 6.70711 7.29289L10 10.5858L13.2929 7.29289C13.6834 6.90237 14.3166 6.90237 14.7071 7.29289C15.0976 7.68342 15.0976 8.31658 14.7071 8.70711L10.7071 12.7071C10.3166 13.0976 9.68342 13.0976 9.29289 12.7071L5.29289 8.70711C4.90237 8.31658 4.90237 7.68342 5.29289 7.29289Z"
                                                      fill="#4A5568"/>
                                            </svg>
                            @else
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                      d="M7.29289 14.7071C6.90237 14.3166 6.90237 13.6834 7.29289 13.2929L10.5858 10L7.29289 6.70711C6.90237 6.31658 6.90237 5.68342 7.29289 5.29289C7.68342 4.90237 8.31658 4.90237 8.70711 5.29289L12.7071 9.29289C13.0976 9.68342 13.0976 10.3166 12.7071 10.7071L8.70711 14.7071C8.31658 15.0976 7.68342 15.0976 7.29289 14.7071Z"
                                                      fill="#4A5568"/>
                                            </svg>
                            @endif
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
                                    <span class="float-right pt-1">
                                        @if($categories['level_2'] === $level_2['name'])
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                      d="M5.29289 7.29289C5.68342 6.90237 6.31658 6.90237 6.70711 7.29289L10 10.5858L13.2929 7.29289C13.6834 6.90237 14.3166 6.90237 14.7071 7.29289C15.0976 7.68342 15.0976 8.31658 14.7071 8.70711L10.7071 12.7071C10.3166 13.0976 9.68342 13.0976 9.29289 12.7071L5.29289 8.70711C4.90237 8.31658 4.90237 7.68342 5.29289 7.29289Z"
                                                      fill="#4A5568"/>
                                            </svg>
                                        @else
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                      d="M7.29289 14.7071C6.90237 14.3166 6.90237 13.6834 7.29289 13.2929L10.5858 10L7.29289 6.70711C6.90237 6.31658 6.90237 5.68342 7.29289 5.29289C7.68342 4.90237 8.31658 4.90237 8.70711 5.29289L12.7071 9.29289C13.0976 9.68342 13.0976 10.3166 12.7071 10.7071L8.70711 14.7071C8.31658 15.0976 7.68342 15.0976 7.29289 14.7071Z"
                                                      fill="#4A5568"/>
                                            </svg>
                                        @endif
                                    </span>
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
