<div id="navigation" :class="isBurgerActive ? '' : 'hidden'"
     class="z-30 fixed inset-y-0 left-0 w-64 bg-gray-800 overflow-y-auto sm:static sm:block sm:translate-x-0 sm:transition-none -translate-x-full ease-in transition-medium">
    <div class="absolute top-0 left-0 pl-4 pt-3 sm:hidden">
        <button class="block text-gray-600 hover:text-gray-300">
            <svg fill="currentColor" class="h-6 w-6" @click="toggleNav()">
                <path
                    d="M17.293 18.707a1 1 0 001.414-1.414L13.414 12l5.293-5.293a1 1 0 00-1.414-1.414L12 10.586 6.707 5.293a1 1 0 00-1.414 1.414L10.586 12l-5.293 5.293a1 1 0 101.414 1.414L12 13.414l5.293 5.293z"></path>
            </svg>
        </button>
    </div>
    <nav class="mt-16 sm:mt-0">
        <div class="mt-8 px-6">
            <h2 class="text-xs font-semibold text-gray-100 uppercase tracking-wide">
                Main
            </h2>

            <div class="my-3">
                <a href="{{ route('cms.index') }}" class="menu-item {{ activeMenu('cms.index') }}">
                    <span class="inline-flex">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M3 6a3 3 0 013-3h12a3 3 0 013 3v12a3 3 0 01-3 3H6a3 3 0 01-3-3V6zm3-1a1 1 0 00-1 1v6h1.586A2 2 0 018 12.586L10.414 15h3.172L16 12.586A2 2 0 0117.414 12H19V6a1 1 0 00-1-1H6zm13 9h-1.586L15 16.414a2 2 0 01-1.414.586h-3.172A2 2 0 019 16.414L6.586 14H5v4a1 1 0 001 1h12a1 1 0 001-1v-4z"></path>
                        </svg>
                        <span class="menu-title">Dashboard</span>
                    </span>
                </a>

                <a href="{{ route('cms.site-users') }}" class="menu-item {{ activeMenu('cms.site-users') }}">
                    <span class="inline-flex">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M9 12A5 5 0 1 1 9 2a5 5 0 0 1 0 10zm0-2a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm7 11a1 1 0 0 1-2 0v-2a3 3 0 0 0-3-3H7a3 3 0 0 0-3 3v2a1 1 0 0 1-2 0v-2a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v2zm1-5a1 1 0 0 1 0-2 5 5 0 0 1 5 5v2a1 1 0 0 1-2 0v-2a3 3 0 0 0-3-3zm-2-4a1 1 0 0 1 0-2 3 3 0 0 0 0-6 1 1 0 0 1 0-2 5 5 0 0 1 0 10z"/></svg>
                        <span class="menu-title">Site Users</span>
                    </span>
                </a>

                <a href="{{ route('cms.admin-users') }}" class="menu-item {{ activeMenu('cms.admin-users') }}">
                    <span class="inline-flex">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M19 10h2a1 1 0 0 1 0 2h-2v2a1 1 0 0 1-2 0v-2h-2a1 1 0 0 1 0-2h2V8a1 1 0 0 1 2 0v2zM9 12A5 5 0 1 1 9 2a5 5 0 0 1 0 10zm0-2a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm8 11a1 1 0 0 1-2 0v-2a3 3 0 0 0-3-3H7a3 3 0 0 0-3 3v2a1 1 0 0 1-2 0v-2a5 5 0 0 1 5-5h5a5 5 0 0 1 5 5v2z"/></svg>
                        <span class="menu-title">Admin Users</span>
                    </span>
                </a>

                <a href="{{ route('cms.company-information') }}" class="menu-item {{ activeMenu('cms.company-information') }}">
                    <span class="inline-flex">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M19 10v6a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-2c0-1.1.9-2 2-2v-6a2 2 0 0 1-2-2V7a1 1 0 0 1 .55-.9l8-4a1 1 0 0 1 .9 0l8 4A1 1 0 0 1 21 7v1a2 2 0 0 1-2 2zm-6 0h-2v6h2v-6zm4 0h-2v6h2v-6zm-8 0H7v6h2v-6zM5 7.62V8h14v-.38l-7-3.5-7 3.5zM5 18v2h14v-2H5z"/></svg>
                        <span class="menu-title">Company Information</span>
                    </span>
                </a>

                <a href="{{ route('cms.contacts') }}" class="menu-item {{ activeMenu('cms.contacts') }}">
                    <span class="inline-flex">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M7 5H5v14h14V5h-2v10a1 1 0 0 1-1.45.9L12 14.11l-3.55 1.77A1 1 0 0 1 7 15V5zM5 3h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5c0-1.1.9-2 2-2zm4 2v8.38l2.55-1.27a1 1 0 0 1 .9 0L15 13.38V5H9z"/></svg>
                        <span class="menu-title">Site Contacts</span>
                    </span>
                </a>
            </div>

            <h2 class="text-xs font-semibold text-gray-300 uppercase tracking-wide">
                Settings
            </h2>

            <div class="my-3">
                <a href="{{ route('cms.home-links') }}" class="menu-item {{ activeMenu('cms.home-links') }}">
                    <span class="inline-flex">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                             class="h-6 w-6 fill-current text-gray-500 hover:text-gray-700">
                            <path
                                d="M19.48 13.03A4 4 0 0 1 16 19h-4a4 4 0 1 1 0-8h1a1 1 0 0 0 0-2h-1a6 6 0 1 0 0 12h4a6 6 0 0 0 5.21-8.98L21.2 12a1 1 0 1 0-1.72 1.03zM4.52 10.97A4 4 0 0 1 8 5h4a4 4 0 1 1 0 8h-1a1 1 0 0 0 0 2h1a6 6 0 1 0 0-12H8a6 6 0 0 0-5.21 8.98l.01.02a1 1 0 1 0 1.72-1.03z"/></svg>
                        <span class="ml-2">Home Links</span>
                    </span>
                </a>
                <a href="" class="menu-item">
                    <span class="inline-flex">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M20 6a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6c0-1.1.9-2 2-2h7.41l2 2H20zM4 6v12h16V8h-7.41l-2-2H4zm9 6h2a1 1 0 0 1 0 2h-2v2a1 1 0 0 1-2 0v-2H9a1 1 0 0 1 0-2h2v-2a1 1 0 0 1 2 0v2z"/></svg>
                        <span class="menu-title">Small Order Charge</span>
                    </span>
                </a>
                <a href="#"
                   class="mt-2 -mx-3 px-3 py-2 flex items-center justify-between text-sm font-medium text-gray-300 hover:bg-gray-200 hover:text-gray-700 rounded-lg"><span
                        class="inline-flex">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                             class="h-6 w-6 fill-current text-gray-500 hover:text-gray-700">
                            <path
                                d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm1-11v2h1a3 3 0 0 1 0 6h-1v1a1 1 0 0 1-2 0v-1H8a1 1 0 0 1 0-2h3v-2h-1a3 3 0 0 1 0-6h1V6a1 1 0 0 1 2 0v1h3a1 1 0 0 1 0 2h-3zm-2 0h-1a1 1 0 1 0 0 2h1V9zm2 6h1a1 1 0 0 0 0-2h-1v2z"/></svg>
                        <span class="ml-2">Discounts</span>
                    </span>
                </a>
                <a href="#"
                   class="mt-2 -mx-3 px-3 py-2 flex items-center justify-between text-sm font-medium text-gray-300 hover:bg-gray-200 hover:text-gray-700 rounded-lg"><span
                        class="inline-flex">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                             class="h-6 w-6 fill-current text-gray-500 hover:text-gray-700">
                            <path
                                d="M5 3h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5c0-1.1.9-2 2-2zm0 10v6h14v-6h-2.38l-1.45 2.9a2 2 0 0 1-1.79 1.1h-2.76a2 2 0 0 1-1.8-1.1L7.39 13H5zm14-2V5H5v6h2.38a2 2 0 0 1 1.8 1.1l1.44 2.9h2.76l1.45-2.9a2 2 0 0 1 1.79-1.1H19z"/></svg>
                        <span class="ml-2">Delivery Methods</span>
                    </span>
                </a>
                <a href="{{ route('cms.product-images') }}" class="menu-item {{ activeMenu('cms.product-images') }}">
                    <span class="inline-flex">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6c0-1.1.9-2 2-2zm16 8.59V6H4v6.59l4.3-4.3a1 1 0 0 1 1.4 0l5.3 5.3 2.3-2.3a1 1 0 0 1 1.4 0l1.3 1.3zm0 2.82l-2-2-2.3 2.3a1 1 0 0 1-1.4 0L9 10.4l-5 5V18h16v-2.59zM15 10a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/></svg>
                        <span class="menu-title">Product Images</span>
                    </span>
                </a>
            </div>
        </div>

        <div class="mt-8 p-6 border-t sm:hidden">
            <div class="flex items-center">
                <span class="ml-4 mr-2 text-sm font-medium text-gray-300">{{ auth()->user()->name }}</span>
            </div>
            <div class="mt-4">
                <a href="#" class="mt-4 block text-sm font-medium text-gray-300 hover:underline">
                    Log out
                </a>
            </div>
        </div>
    </nav>
</div><?php
