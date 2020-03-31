<nav class="menu-wrapper bg-header-secondary md:block">
    <div class="menu container md:flex">

        <div class="menu-item">
            <a href="{{ route('home') }}" class="{{ activeMenu('home') }}">Home</a>
        </div>

        <div class="menu-item">
            <a href="{{ route('products') }}" class="{{ activeMenu('products') }}">Products</a>
        </div>

        <div class="menu-item">
            <a href="{{ route('order-tracking') }}" class="{{ activeMenu('order-tracking') }}">Orders</a>
        </div>

        <div class="menu-item">
            <a href="{{ route('upload') }}" class="{{ activeMenu('upload') }}">Order Upload</a>
        </div>

        <div class="menu-item">
            <a href="{{ route('saved-baskets') }}" class="{{ activeMenu('saved-baskets') }}">Saved Baskets</a>
        </div>

        <div class="menu-item">
            <a href="{{ route('reports') }}" class="{{ activeMenu('reports') }}">Reports</a>
        </div>

        @if ($product_data['data'] || $product_data['prices'])
            <div class="menu-item">
                <a href="{{ route('product-data') }}" class="{{ activeMenu('product-data') }}">Product Data</a>
            </div>
        @endif

    </div>
</nav>
