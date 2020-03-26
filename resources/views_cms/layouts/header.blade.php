<header class="flex flex-shrink-0">
    <div class="flex flex-shrink-0 px-4 py-3 bg-gray-700 lg:w-64">
        <button class="block text-gray-400 mr-4 hover:text-gray-200 sm:hidden" @click="toggleNav()">
            <svg viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6">
                <path
                    d="M3 6a1 1 0 011-1h16a1 1 0 110 2H4a1 1 0 01-1-1zM3 12a1 1 0 011-1h16a1 1 0 110 2H4a1 1 0 01-1-1zM4 17a1 1 0 100 2h7a1 1 0 100-2H4z"></path>
            </svg>
        </button>
        <a href="{{ route('cms.index') }}" class="mx-auto hover:opacity-75">
            <img class="h-8" src="{{ asset('images/logos/logo-' . config('app.name') .'.png') }}"
                 alt="{{ config('app.name') }}">
        </a>
    </div>
    <div class="flex-1 flex items-center justify-between pl-2 pr-6 bg-gray-700 lg:px-6">
        <div class="ml-auto flex items-center">
            <dropdown>
                <template v-slot:trigger>
                    <button class="hidden p-1 sm:flex sm:items-center sm:w-full rounded-lg hover:bg-gray-600">
                        <span
                            class="hidden lg:inline ml-2 mr-2 text-sm font-medium text-white">{{ auth()->user()->name }}</span>
                        <svg viewBox="0 0 24 24" class="ml-2 h-6 w-6 fill-current text-gray-400 lg:ml-auto">
                            <path
                                d="M7.293 9.293a1 1 0 011.414 0L12 12.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"></path>
                        </svg>
                    </button>
                </template>

                <a href="#" class="block no-underline text-sm leading-loose rounded-lg px-2 py-1 hover:bg-gray-600"
                   onclick="document.querySelector('#logout').submit()">Logout</a>

                <form id="logout" method="POST" action="{{ route('cms.logout') }}"></form>
            </dropdown>
        </div>
    </div>
</header>
