<header>
    <div class="container">
        <div class="brand">
            <div class="row">
                <div class="col">
                    <a href="/">
                        <img src="{{ asset('images/logo.png') }}">
                    </a>
                </div>
                @if (!Auth::user() && count($errors) > 0)
                    <div class="col text-right mt-auto">
                        <div class="text-left alert alert-danger">
                            <strong>Error!</strong> The credentials you supplied do not match our records. If you have
                            forgotten your
                            password, click <a href="{{ route('password.request') }}">here</a> to reset it.
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
                                    <button class="btn btn-primary">Basket</button>
                                    <button class="btn btn-primary">Checkout</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</header>