<header>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="brand">
                    <a href="/">
                        <img src="https://scolmoreonline.com/assets/images/scolmore_small.png">
                    </a>
                </div>
            </div>
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

            @auth
                @php($basket = \App\Models\Basket::show())
                <div class="col mt-auto mb-auto">
                    <div class="header-basket float-right text-center">
                        <div class="row">
                            <div class="col text-center basket-info">
                                <strong>{{ __('Your Basket') }}</strong><br>
                                <span class="order-lines">{{ $basket['line_count'] }}</span> Lines - <span
                                        class="order-total">{{ $basket['summary']['goods_total'] }}</span>
                            </div>
                            <div class="col basket-buttons my-auto">
                                <a href="{{ route('basket') }}" class="btn-link">
                                    <button id="header-basket" class="btn btn-secondary">{{ __('Basket') }}</button>
                                </a>
                                <a href="{{ route('checkout') }}" id="header-checkout" class="btn-link" @if($basket['line_count'] == 0) style="display:none;" @endif>
                                    <button class="btn btn-primary">{{ __('Checkout') }}</button>
                                </a>
                            </div>
                        </div>
                        <div class="basket-dropdown" style="display: none;">
                            <div class="basket-dropdown-content text-left"></div>
                        </div>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</header>
