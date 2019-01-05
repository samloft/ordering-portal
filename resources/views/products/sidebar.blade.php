<div class="col-lg-3 product-sidebar">
    @if (Auth::user()->admin)
        <div class="row">
            <div class="col">
                <form class="w-100" action="">
                    <div class="form-group">
                        <label>{{ __('Change Customer') }}</label>
                        <div class="input-group">
                            <input type="text" class="form-control">
                            <div class="input-group-append">
                                <button class="input-group-text"><i class="fas fa-user"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col">
            <form class="w-100" action="{{ route('products.search') }}" method="get">
                <div class="form-group">
                    <label>{{ __('Search') }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="query">
                        <div class="input-group-append">
                            <button class="input-group-text"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <form action="">
                <div class="form-group mb-1">
                    <label>{{ __('Quick Buy') }}</label>
                    <input class="form-control" placeholder="{{ __('Enter Product Code') }}">
                </div>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{ __('Qty:') }}</span>
                    </div>
                    <input class="form-control mr-2" value="{{ __('1') }}">
                    <span class="input-group-btn">
                                <button class="btn btn-primary" type="button">{{ __('Add To Basket') }}</button>
                            </span>
                </div>
            </form>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col">
            <label>{{ __('Categories') }}</label>

            <ul class="categories list-group w-100">
                @foreach(\App\Models\Categories::list() as $key => $category)
                    <li class="list-group-item cat-{{ $key }}">
                        <a href="{{ route('products', $category['url']) }}">
                            {{ $category['name'] }}
                            @if (count($category['sub']) > 0)
                                <span class="float-right pt-1">
                                <i class="fas {{ $categories['level_1'] == $category['name'] ? 'fa-chevron-down' : 'fa-chevron-right' }}"></i>
                            </span>
                            @endif
                        </a>
                    </li>
                    @if ($categories['level_1'] == $category['name'] && count($category['sub']) > 0)
                        <ul class="list-group sub-category">
                            @foreach ($category['sub'] as $level_2)
                                <li class="list-group-item">
                                    <a href="{{ route('products', [$category['url'], $level_2['url']]) }}"
                                       class="{{ $categories['level_2'] == $level_2['name'] ? 'font-weight-bold' : '' }}">
                                        {{ $level_2['name'] }}
                                        @if (count($level_2['sub']) > 0)
                                            <span class="float-right pt-1"><i
                                                        class="fas {{ $categories['level_2'] == $level_2['name'] ? 'fa-chevron-down' : 'fa-chevron-right' }}"></i></span>
                                        @endif
                                    </a>
                                </li>
                                @if ($categories['level_2'] == $level_2['name'] && count($level_2['sub']) > 0)
                                    <ul class="list-group sub-category">
                                        @foreach ($level_2['sub'] as $level_3)
                                            <li class="list-group-item">
                                                <a href="{{ route('products', [$category['url'], $level_2['url'], $level_3['url']]) }}"
                                                   class="{{ $categories['level_3'] == $level_3['name'] ? 'font-weight-bold' : '' }}">
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