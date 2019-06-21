<div class="mdk-drawer  js-mdk-drawer" id="default-drawer" data-align="start">
    <div class="mdk-drawer__content">
        <div class="sidebar sidebar-light sidebar-left simplebar" data-simplebar>
            <div class="sidebar-heading sidebar-m-t pt-3">{{ __('Menu') }}</div>

            <ul class="sidebar-menu" id="components_menu">
                <li class="sidebar-menu-item {{ setActive('cms.index') }}">
                    <a class="sidebar-menu-button" href="{{ route('cms.index') }}">
                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">dvr</i>
                        <span class="sidebar-menu-text">{{ __('Dashboard') }}</span>
                    </a>
                </li>

                <li class="sidebar-menu-item {{ setActive('cms.site-users') }}">
                    <a class="sidebar-menu-button" href="{{ route('cms.site-users') }}">
                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">people</i>
                        <span class="sidebar-menu-text">{{ __('Site Users') }}</span>
                    </a>
                </li>

                <li class="sidebar-menu-item">
                    <a class="sidebar-menu-button" href="#">
                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">nature_people</i>
                        <span class="sidebar-menu-text">{{ __('Admin Users') }}</span>
                    </a>
                </li>

                <li class="sidebar-menu-item {{ setActive('cms.company-information') }}">
                    <a class="sidebar-menu-button" href="{{ route('cms.company-information') }}">
                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">business</i>
                        <span class="sidebar-menu-text">{{ __('Company Details') }}</span>
                    </a>
                </li>
            </ul>

            <div class="sidebar-heading">{{ __('Settings') }}</div>

            <div class="sidebar-block p-0">
                <ul class="sidebar-menu">
                    <li class="sidebar-menu-item {{ setActive('cms.home-links') }}">
                        <a class="sidebar-menu-button" href="{{ route('cms.home-links') }}">
                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">insert_link</i>
                            <span class="sidebar-menu-text">{{ __('Home Links') }}</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item">
                        <a class="sidebar-menu-button" href="#">
                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">money_off</i>
                            <span class="sidebar-menu-text">{{ __('Discounts') }}</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item">
                        <a class="sidebar-menu-button" href="#">
                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">local_shipping</i>
                            <span class="sidebar-menu-text">{{ __('Delivery Methods') }}</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item">
                        <a class="sidebar-menu-button" href="#">
                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">contact_mail</i>
                            <span class="sidebar-menu-text">{{ __('Contacts') }}</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item {{ setActive('cms.product-images') }}">
                        <a class="sidebar-menu-button" href="{{ route('cms.product-images') }}">
                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">image</i>
                            <span class="sidebar-menu-text">{{ __('Product Images') }}</span>
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</div>