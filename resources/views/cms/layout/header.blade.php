<div id="header" class="mdk-header js-mdk-header m-0" data-fixed>
    <div class="mdk-header__content">

        <div class="navbar navbar-expand-sm navbar-main navbar-dark bg-primary-dark pr-0" id="navbar" data-primary>
            <div class="container-fluid p-0">

                <button class="navbar-toggler navbar-toggler-right d-block d-md-none" type="button"
                        data-toggle="sidebar">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <a href="/" class="navbar-brand ">
                    <img class="navbar-brand-icon" src="https://scolmoreonline.com/assets/images/scolmore_small.png" height="35"
                         alt="Scolmore">
                </a>

                <a class="dropdown-item" href="/logout"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>

                <ul class="nav navbar-nav d-none d-sm-flex border-left navbar-height align-items-center">
                    <li class="nav-item dropdown">
                        <a href="" class="nav-link dropdown-toggle" data-toggle="dropdown"
                           data-caret="false">
                            <span class="ml-1 d-flex-inline">
                                        <span class="text-light">
                                            {{ Auth::guard('admin')->user()->first_name . ' ' . Auth::guard('admin')->user()->last_name }}
                                        </span>
                                <i class="material-icons">arrow_drop_down</i>
                                    </span>
                        </a>
                        <div id="account_menu" class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#">{{ __('Edit Account') }}</a>

                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item" href="/logout"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>

                            <form id="logout-form" action="{{ route('cms.logout') }}" method="POST"
                                  style="display: none;"></form>
                        </div>
                    </li>
                </ul>

            </div>
        </div>

    </div>
</div>
