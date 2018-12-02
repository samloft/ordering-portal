<div class="login-header">
    <div class="container">
        <div class="row">
            @if (!Auth::user())
                <div class="col d-flex">
                    <h4 class="align-self-center">Welcome to online ordering</h4>
                </div>
            @else
                <div class="col navigation">
                    <nav class="navbar navbar-expand-lg">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item text-center active">
                                    <a class="nav-link" href="{{ route('home') }}">{{ __('Home') }}</a>
                                </li>
                                <li class="nav-item text-center">
                                    <a class="nav-link" href="{{ route('products') }}">{{ __('Products') }}</a>
                                </li>
                                <li class="nav-item text-center">
                                    <a class="nav-link" href="{{ route('order-tracking') }}">{{ __('Order Tracking') }}</a>
                                </li>
                                <li class="nav-item text-center">
                                    <a class="nav-link" href="{{ route('upload') }}">{{ __('Upload Orders') }}</a>
                                </li>
                                <li class="nav-item text-center">
                                    <a class="nav-link" href="{{ route('saved-baskets') }}">{{ __('Saved Baskets') }}</a>
                                </li>
                                <li class="nav-item text-center">
                                    <a class="nav-link" href="{{ route('reports') }}">{{ __('Reports') }}</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            @endif

            @if (!Auth::user())
                <div class="col text-right">
                    <form class="pt-2 pb-2 m-0" method="POST" action="{{ route('login') }}">
                        <div class="form-row">
                            <div class="col-5">
                                <input class="form-control" name="username" placeholder="Username">
                            </div>
                            <div class="col-5">
                                <input type="password" class="form-control" name="password" placeholder="Password">
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                        <div class="row login-extra">
                            <div class="col-auto text-left">
                                <div class="form-check">
                                    <input class="form-check-input" name="remember" type="checkbox">
                                    <label class="form-check-label">
                                        Remember me
                                    </label>
                                </div>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('password.request') }}">Forgot Password?</a>
                            </div>
                        </div>
                    </form>
                </div>
            @else
                <div class="col">
                    <div class="user-details text-right">
                        <span>
                            <strong>Welcome {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</strong>, COMPANY NAME
                        </span>
                        <span>
                            <a href="">{{ __('Your Account') }}</a> |
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                        </span>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"></form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>