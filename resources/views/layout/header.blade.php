<header>
    <div class="container mx-auto px-4">
        <div class="flex items-center md:justify-between py-2">
            <div class="w-1/4 md:hidden">
                <svg class="fill-current text-white h-8 w-8" xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 20 20">
                    <path
                        d="M16.4 9H3.6c-.552 0-.6.447-.6 1 0 .553.048 1 .6 1h12.8c.552 0 .6-.447.6-1 0-.553-.048-1-.6-1zm0 4H3.6c-.552 0-.6.447-.6 1 0 .553.048 1 .6 1h12.8c.552 0 .6-.447.6-1 0-.553-.048-1-.6-1zM3.6 7h12.8c.552 0 .6-.447.6-1 0-.553-.048-1-.6-1H3.6c-.552 0-.6.447-.6 1 0 .553.048 1 .6 1z"/>
                </svg>
            </div>

            <a href="/">
                <img class="logo" src="{{ asset('images/logos/logo-' . config('app.name') .'.png') }}"
                     alt="{{ config('app.name') }}">
            </a>

            <div class="header-summary w-1/4 md:w-auto md:flex text-right p-3 bg-background_invert-color rounded">
                <div class="flex md:flex md:items-center mr-2">

                    <basket-dropdown>
                        <template v-slot:basket_button>
                            <a href="{{ route('basket') }}">
                                <button class="button button-secondary mr-2">Basket</button>
                            </a>
                        </template>
                    </basket-dropdown>

                    <a href="{{ route('checkout') }}">
                        <button class="button button-primary">Checkout</button>
                    </a>
                </div>

                <dropdown align="right">
                    <template v-slot:trigger>
                        <div class="dropdown md:block md:flex md:items-center rounded cursor-pointer">
                            <div class="mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-10 h-10 icon icon-user">
                                    <path class="primary" d="M12 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10z"></path>
                                    <path class="secondary"
                                          d="M21 20v-1a5 5 0 0 0-5-5H8a5 5 0 0 0-5 5v1c0 1.1.9 2 2 2h14a2 2 0 0 0 2-2z"></path>
                                </svg>
                            </div>
                            <div class="md:block ml-2 text-left">
                                <span class="text-sm mr-1 font-thin font-medium block">{{ auth()->user()->name }}</span>
                                <span class="text-xs mr-1 font-thin block leading-tight">{{ auth()->user()->customer->code }}</span>
                                <span class="text-xs mr-1 font-thin block leading-tight">{{ auth()->user()->customer->name }}</span>
{{--                                <div class="font-light">My Account</div>--}}
                            </div>
                            <div>
                                <svg class="fill-current h-4 w-4 block opacity-50 ml-2"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path
                                        d="M4.516 7.548c.436-.446 1.043-.481 1.576 0L10 11.295l3.908-3.747c.533-.481 1.141-.446 1.574 0 .436.445.408 1.197 0 1.615-.406.418-4.695 4.502-4.695 4.502a1.095 1.095 0 0 1-1.576 0S4.924 9.581 4.516 9.163c-.409-.418-.436-1.17 0-1.615z"/>
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
