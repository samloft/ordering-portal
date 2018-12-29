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
            @if (!Auth::user() && count($errors) > 0)
                <div class="col text-right mt-auto">
                    <div class="text-left alert alert-danger">
                        @if (is_array($errors))
                            <strong>Error!</strong> {{ $errors['no_customer'] }}
                        @else
                            <strong>Error!</strong> The credentials you supplied do not match our records. If you have
                            forgotten your
                            password, click <a href="{{ route('password.request') }}">here</a> to reset it.
                        @endif
                    </div>
                </div>
            @endif

            @if (Auth::user())
                <div class="col mt-auto mb-auto">
                    <div class="header-basket float-right">
                        <div class="row">
                            <div class="col text-center basket-info">
                                <strong>{{ __('Your Basket') }}</strong><br>
                                0 Lines - £0.00
                            </div>
                            <div class="col basket-buttons my-auto">
                                <a href="{{ route('basket') }}" class="btn-link">
                                    <button id="header-basket" class="btn btn-secondary">{{ __('Basket') }}</button>
                                </a>
                                <a href="{{ route('checkout') }}" class="btn-link">
                                    <button class="btn btn-primary">{{ __('Checkout') }}</button>
                                </a>
                            </div>
                        </div>
                        <div class="basket-dropdown text-right" style="display: none;">
                            <div class="text-left">Here would be some basket stuffs.</div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</header>