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
                        @if ($errors['no_customer'])
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
                                <strong>Your Basket</strong><br>
                                0 Lines - £0.00
                            </div>
                            <div class="col basket-buttons my-auto">
                                <a href="{{ route('basket') }}" class="btn-link">
                                    <button class="btn btn-secondary">Basket</button>
                                </a>
                                <button class="btn btn-primary">Checkout</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</header>