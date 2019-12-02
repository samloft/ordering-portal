<nav class="menu-wrapper bg-header-secondary md:block">
    <div class="menu container md:flex">

        <div class="menu-item">
            <a href="{{ route('home') }}" class="{{ setActive('home') }}">{{ __('Home') }}</a>
        </div>

        <div class="menu-item">
            <a href="{{ route('products') }}" class="{{ setActive('products') }}">{{ __('Product') }}</a>
        </div>

        <div class="menu-item">
            <a href="{{ route('order-tracking') }}" class="{{ setActive('order-tracking') }}">{{ __('Orders') }}</a>
        </div>

        <div class="menu-item">
            <a href="{{ route('upload') }}" class="{{ setActive('upload') }}">{{ __('Order Upload') }}</a>
        </div>

        <div class="menu-item">
            <a href="{{ route('saved-baskets') }}" class="{{ setActive('saved-baskets') }}">{{ __('Saved Baskets') }}</a>
        </div>

        <div class="menu-item">
            <a href="{{ route('reports') }}" class="{{ setActive('reports') }}">{{ __('Reports') }}</a>
        </div>

        <div class="menu-item">
            <a href="#">{{ __('Product Data') }}</a>
        </div>

    </div>
</nav>
