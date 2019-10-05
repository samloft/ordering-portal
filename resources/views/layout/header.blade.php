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

            <img class="logo" src="{{ asset('images/logos/logo-' . config('app.name') .'.png') }}"
                 alt="{{ config('app.name') }}">

            <div class="w-1/4 md:w-auto md:flex text-right p-3 bg-background_invert-color rounded">
                <div class="flex md:flex md:items-center mr-2">
                    <div class="mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-10 icon icon-shopping-cart"><path class="primary" d="M7 4h14a1 1 0 0 1 .9 1.45l-4 8a1 1 0 0 1-.9.55H7a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1z"></path><path class="secondary" d="M17.73 19a2 2 0 1 1-3.46 0H8.73a2 2 0 1 1-3.42-.08A3 3 0 0 1 5 13.17V4H3a1 1 0 1 1 0-2h3a1 1 0 0 1 1 1v10h11a1 1 0 0 1 0 2H6a1 1 0 0 0 0 2h12a1 1 0 0 1 0 2h-.27z"></path></svg>
                    </div>
                    <div class="md:block ml-2 text-left flex mr-5">
                        <span class="text-sm font-thin">My Cart</span>
                        <div class="font-light">£0.00</div>
                    </div>
                    <button class="button button-secondary mr-2">Basket</button>
                    <button class="button button-primary">Checkout</button>
                </div>

                <dropdown align="right">
                    <template v-slot:trigger>
                        <div class="dropdown md:block md:flex md:items-center rounded cursor-pointer">
                            <div class="mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-10 icon icon-user">
                                    <path class="primary" d="M12 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10z"></path>
                                    <path class="secondary"
                                          d="M21 20v-1a5 5 0 0 0-5-5H8a5 5 0 0 0-5 5v1c0 1.1.9 2 2 2h14a2 2 0 0 0 2-2z"></path>
                                </svg>
                            </div>
                            <div class="md:block ml-2 text-left">
                                <span class="text-sm mr-1 font-thin">{{ auth()->user()->name }}</span>
                                <div class="font-light">My Account</div>
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

                    <a href="{{ route('account') }}" class="dropdown-menu-item">{{ __('My account') }}</a>
                    <a href="#" class="dropdown-menu-item"
                       onclick="document.querySelector('#logout').submit()">{{ __('Logout') }}</a>

                    <form id="logout" method="POST" class="hidden" action="{{ route('logout') }}"></form>
                </dropdown>
            </div>
        </div>
    </div>
</header>


{{--<header>--}}
{{--    <div class="container">--}}
{{--        <div class="row">--}}
{{--            <div class="col">--}}
{{--                <div class="brand">--}}
{{--                    <a href="/">--}}
{{--                        <img src="https://scolmoreonline.com/assets/images/scolmore_small.png">--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            @if (!Auth::user() && count($errors) > 0)--}}
{{--                <div class="col text-right mt-auto">--}}
{{--                    <div class="text-left alert alert-danger">--}}
{{--                        @if (is_array($errors))--}}
{{--                            <strong>Error!</strong> {{ $errors['no_customer'] }}--}}
{{--                        @else--}}
{{--                            <strong>Error!</strong> The credentials you supplied do not match our records. If you have--}}
{{--                            forgotten your--}}
{{--                            password, click <a href="{{ route('password.request') }}">here</a> to reset it.--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}

{{--            @auth--}}
{{--                @php($basket = \App\Models\Basket::show())--}}
{{--                <div class="col mt-auto mb-auto">--}}
{{--                    <div class="header-basket float-right text-center">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col text-center basket-info">--}}
{{--                                <strong>{{ __('Your Basket') }}</strong><br>--}}
{{--                                <span class="order-lines">{{ $basket['line_count'] }}</span> Lines - <span--}}
{{--                                        class="order-total">{{ $basket['summary']['goods_total'] }}</span>--}}
{{--                            </div>--}}
{{--                            <div class="col basket-buttons my-auto">--}}
{{--                                <a href="{{ route('basket') }}" class="btn-link">--}}
{{--                                    <button id="header-basket" class="btn btn-secondary">{{ __('Basket') }}</button>--}}
{{--                                </a>--}}
{{--                                <a href="{{ route('checkout') }}" id="header-checkout" class="btn-link" @if($basket['line_count'] == 0) style="display:none;" @endif>--}}
{{--                                    <button class="btn btn-primary">{{ __('Checkout') }}</button>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="basket-dropdown" style="display: none;">--}}
{{--                            <div class="basket-dropdown-content text-left"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endauth--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</header>--}}
