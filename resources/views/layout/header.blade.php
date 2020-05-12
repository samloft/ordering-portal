<header>
    <div class="container mx-auto px-4">
        <div class="flex items-center md:justify-between py-2">
            <div class="flex justify-between items-center w-full md:w-auto">
                <div>
                    <a href="/">
                        <img class="logo" src="{{ asset('images/logos/logo-' . config('app.name') .'.png') }}"
                             alt="{{ config('app.name') }}">
                    </a>
                </div>

                <mobile-menu>
                    <template slot="trigger"></template>

                    <template slot="content" slot-scope="props">
                        <div v-if="props.isOpen"
                             class="md:hidden absolute w-full h-full left-0 top-0 bg-background_invert-color text-background_invert-text z-40 p-8 pt-20">

                            <div class="mb-3 flex justify-center">
                                <a href="{{ route('basket') }}">
                                    <button class="button button-secondary">Basket</button>
                                </a>
                            </div>

                            <div class="text-center text-2xl">
                                <div class="mb-6">
                                    <a href="{{ route('home') }}" class="{{ activeMenu('home', 'underline') }}">Home</a>
                                </div>

                                <div class="mb-6">
                                    <a href="{{ route('products') }}" class="{{ activeMenu('products', 'underline') }}">Products</a>
                                </div>

                                <div class="mb-6">
                                    <a href="{{ route('order-tracking') }}"
                                       class="{{ activeMenu('order-tracking', 'underline') }}">Orders</a>
                                </div>

                                <div class="mb-6">
                                    <a href="{{ route('upload') }}" class="{{ activeMenu('upload', 'underline') }}">Order
                                        Upload</a>
                                </div>

                                <div class="mb-6">
                                    <a href="{{ route('saved-baskets') }}"
                                       class="{{ activeMenu('saved-baskets', 'underline') }}">Saved Baskets</a>
                                </div>

                                <div class="mb-6">
                                    <a href="{{ route('reports') }}" class="{{ activeMenu('reports', 'underline') }}">Reports</a>
                                </div>

                                @if ($product_data['data'] || $product_data['prices'])
                                    <div class="mb-6">
                                        <a href="{{ route('product-data') }}"
                                           class="{{ activeMenu('product-data', 'underline') }}">Product Data</a>
                                    </div>
                                @endif
                            </div>

                            <hr>

                            <div class="text-center text-lg mt-3">
                                <div class="text-gray-300 text-base font-thin">{{ auth()->user()->name }}</div>
                                <div class="mb-2 text-gray-300 text-base font-thin">{{ auth()->user()->customer->code }}</div>

                                <a href="{{ route('account') }}" class="block">My account</a>
                                <a href="#" class="block"
                                   onclick="document.querySelector('#logout').submit()">Logout</a>
                            </div>
                        </div>
                    </template>
                </mobile-menu>
            </div>

            <div
                class="hidden md:block header-summary md:w-auto md:flex text-right p-3 bg-background_invert-color rounded">
                <div class="sm:hidden flex md:flex md:items-center mr-2">

                    <basket-dropdown>
                        <template v-slot:basket-button>
                            <a href="{{ route('basket') }}">
                                <button class="button button-secondary mr-2">Basket</button>
                            </a>
                        </template>

                        <template v-slot:checkout-button>
                            <a href="{{ route('checkout') }}">
                                <button class="button button-primary">Checkout</button>
                            </a>
                        </template>
                    </basket-dropdown>
                </div>

                <dropdown align="right">
                    <template v-slot:trigger>
                        <div class="dropdown md:block md:flex md:items-center rounded cursor-pointer">
                            <div class="mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                     class="w-10 h-10 icon icon-user">
                                    <path class="primary" d="M12 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10z"></path>
                                    <path class="secondary"
                                          d="M21 20v-1a5 5 0 0 0-5-5H8a5 5 0 0 0-5 5v1c0 1.1.9 2 2 2h14a2 2 0 0 0 2-2z"></path>
                                </svg>
                            </div>
                            <div class="md:block ml-2 text-left">
                                <span class="text-sm mr-1 font-thin font-medium block">{{ auth()->user()->name }}</span>
                                <span
                                    class="text-xs mr-1 font-thin block leading-tight">{{ auth()->user()->customer->code }}</span>
                                <span
                                    class="text-xs mr-1 font-thin block leading-tight">{{ auth()->user()->customer->name }}</span>
                            </div>
                            <div>
                                <svg class="fill-current h-4 w-4 block opacity-50 ml-2"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path
                                        d="M4.516 7.548c.436-.446 1.043-.481 1.576 0L10 11.295l3.908-3.747c.533-.481 1.141-.446 1.574 0 .436.445.408 1.197 0 1.615-.406.418-4.695 4.502-4.695 4.502a1.095 1.095 0 0 1-1.576 0S4.924 9.581 4.516 9.163c-.409-.418-.436-1.17 0-1.615z"></path>
                                </svg>
                            </div>
                        </div>
                    </template>

                    <a href="{{ route('account') }}" class="dropdown-menu-item">My account</a>
                    <a href="#" class="dropdown-menu-item"
                       onclick="document.querySelector('#logout').submit()">Logout</a>

                    <form id="logout" method="POST" class="hidden" action="{{ route('logout') }}"></form>
                </dropdown>
            </div>
        </div>
    </div>
</header>
