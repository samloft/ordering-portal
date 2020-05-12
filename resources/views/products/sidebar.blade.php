<mobile-menu>
    <template slot="trigger">
        <div
             class="xl:hidden fixed left-0 bg-background_primary-color text-background_primary-text pt-3 pb-3 pr-3 pl-2 rounded-tr-full rounded-br-full hover:cursor-pointer hover:opacity-75 shadow z-30">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M12 6V4M12 6C10.8954 6 10 6.89543 10 8C10 9.10457 10.8954 10 12 10M12 6C13.1046 6 14 6.89543 14 8C14 9.10457 13.1046 10 12 10M6 18C7.10457 18 8 17.1046 8 16C8 14.8954 7.10457 14 6 14M6 18C4.89543 18 4 17.1046 4 16C4 14.8954 4.89543 14 6 14M6 18V20M6 14V4M12 10V20M18 18C19.1046 18 20 17.1046 20 16C20 14.8954 19.1046 14 18 14M18 18C16.8954 18 16 17.1046 16 16C16 14.8954 16.8954 14 18 14M18 18V20M18 14V4"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
    </template>

    <template slot="content" slot-scope="props">
        <div :class="props.isOpen ? 'block' : 'hidden'" class="xl:block xl:pr-5 sidebar mb-3 xl:mb-0">
            @if (auth()->user()->admin || count(auth()->user()->customers) > 0)
                <h4>Change Customer</h4>

                <customer-switch
                    :user="{{ json_encode(auth()->user()->load('customers'), true) }}"></customer-switch>

            @endif

            <h4 class="mt-4">Search</h4>

            <form class="w-100" action="{{ route('products.search') }}" method="get" class="m-0">
                <div class="relative">
                    <input type="text" class="form-control" name="query" autocomplete="off" required>
                    <button
                        class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-600 hover:opacity-50">
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
                    <li class="top-level category-{{ str_slug(strtolower($key)) }}">
                        <a href="{{ route('products', encodeUrl($key)) }}">
                            {{ $key }}
                            @if (count(array_filter($category_list[$key])) > 0)
                                <span class="float-right pt-1">
                            @if($categories['level_1'] === $category_list[$key])
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
                    @if ($categories['level_1'] === $key && count($category_list[$key]) > 0)
                        <ul class="sub-categories">
                            @foreach ($category_list[$key] as $level_2_key => $level_2)
                                @if($level_2_key !== '')
                                    <li class="py-1 pl-2">
                                        <a href="{{ route('products', [encodeUrl($key), encodeUrl($level_2_key)]) }}"
                                           class="{{ $categories['level_2'] === $level_2_key ? 'active' : '' }}">
                                            {{ $level_2_key }}
                                            @if (count(array_filter(array_keys($category_list[$key][$level_2_key]))) > 0)
                                                <span class="float-right pt-1">
                                            @if($categories['level_2'] === $level_2_key)
                                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                                                    <path fill-rule="evenodd"
                                                                                          clip-rule="evenodd"
                                                                                          d="M5.29289 7.29289C5.68342 6.90237 6.31658 6.90237 6.70711 7.29289L10 10.5858L13.2929 7.29289C13.6834 6.90237 14.3166 6.90237 14.7071 7.29289C15.0976 7.68342 15.0976 8.31658 14.7071 8.70711L10.7071 12.7071C10.3166 13.0976 9.68342 13.0976 9.29289 12.7071L5.29289 8.70711C4.90237 8.31658 4.90237 7.68342 5.29289 7.29289Z"
                                                                                          fill="#4A5568"/>
                                                                                </svg>
                                                    @else
                                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                                                    <path fill-rule="evenodd"
                                                                                          clip-rule="evenodd"
                                                                                          d="M7.29289 14.7071C6.90237 14.3166 6.90237 13.6834 7.29289 13.2929L10.5858 10L7.29289 6.70711C6.90237 6.31658 6.90237 5.68342 7.29289 5.29289C7.68342 4.90237 8.31658 4.90237 8.70711 5.29289L12.7071 9.29289C13.0976 9.68342 13.0976 10.3166 12.7071 10.7071L8.70711 14.7071C8.31658 15.0976 7.68342 15.0976 7.29289 14.7071Z"
                                                                                          fill="#4A5568"/>
                                                                                </svg>
                                                    @endif
                                        </span>
                                            @endif
                                        </a>
                                    </li>
                                @endif
                                @if ($categories['level_2'] === $level_2_key && count($category_list[$key][$level_2_key]) > 0)
                                    <ul class="pl-4">
                                        @foreach ($category_list[$key][$level_2_key] as $level_3_key => $level_3_value)
                                            @if($level_3_key !== '')
                                                <li class="py-1">
                                                    <a href="{{ route('products', [$key, $level_2_key, $level_3_key]) }}"
                                                       class="{{ $categories['level_3'] === $level_3_key ? 'active' : '' }}">
                                                        {{ $level_3_key }}
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                @endforeach
            </ul>
        </div>
    </template>
</mobile-menu>
