<!-- Page Header -->
<header id="page-header"
    class="flex flex-none items-center h-16 bg-white shadow-sm fixed top-0 right-0 left-0 z-30 lg:pl-64 dark:bg-gray-800"
    :class="{
        'lg:pl-64': desktopSidebarOpen,
    }">
    <div class="flex justify-between max-w-10xl mx-auto px-4 lg:px-8 w-full">
        <!-- Left Section -->
        <div class="flex items-center space-x-2">
            <!-- Toggle Sidebar on Desktop -->
            <div class="hidden lg:block">
                <button x-on:click="desktopSidebarOpen = !desktopSidebarOpen" type="button"
                    class="inline-flex items-center justify-center space-x-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-semibold leading-5 text-gray-800 hover:border-gray-300 hover:text-gray-900 hover:shadow-sm focus:ring focus:ring-gray-300 focus:ring-opacity-25 active:border-gray-200 active:shadow-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:border-gray-600 dark:hover:text-gray-200 dark:focus:ring-gray-600 dark:focus:ring-opacity-40 dark:active:border-gray-700">
                    <svg class="hi-solid hi-menu-alt-1 inline-block h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
            <!-- END Toggle Sidebar on Desktop -->

            <!-- Toggle Sidebar on Mobile -->
            <div class="lg:hidden">
                <button x-on:click="mobileSidebarOpen = !mobileSidebarOpen" type="button"
                    class="inline-flex items-center justify-center space-x-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-semibold leading-5 text-gray-800 hover:border-gray-300 hover:text-gray-900 hover:shadow-sm focus:ring focus:ring-gray-300 focus:ring-opacity-25 active:border-gray-200 active:shadow-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:border-gray-600 dark:hover:text-gray-200 dark:focus:ring-gray-600 dark:focus:ring-opacity-40 dark:active:border-gray-700">
                    <svg class="hi-solid hi-menu-alt-1 inline-block h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
            <!-- END Toggle Sidebar on Mobile -->
        </div>
        <!-- END Left Section -->

        <!-- Center Section -->
        <div class="flex items-center">
            @if (auth()->user()->activeWarehouse != null)
                <span
                    class="group inline-flex items-center space-x-2 text-lg font-bold rounded text-primary-700 bg-primary-200 px-2 py-1">{{ auth()->user()->activeWarehouse->name }}</span>
            @else
                <span
                    class="group inline-flex items-center space-x-2 text-lg font-bold rounded text-red-700 bg-red-200 px-2 py-1">No
                    Active Warehouse</span>
            @endif
        </div>
        <!-- END Center Section -->

        <!-- Right Section -->
        <div class="flex items-center space-x-2">
            <!-- User Dropdown -->
            <Menu as="div" class="relative inline-block">
                <!-- Dropdown Toggle Button -->
                <button x-bind:aria-expanded="userDropdownOpen" x-on:click="userDropdownOpen = true" type="button"
                    id="dropdown-user"
                    class="inline-flex items-center justify-center space-x-1 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-semibold leading-5 text-gray-800 hover:border-gray-300 hover:text-gray-900 hover:shadow-sm focus:ring focus:ring-gray-300 focus:ring-opacity-25 active:border-gray-200 active:shadow-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:border-gray-600 dark:hover:text-gray-200 dark:focus:ring-gray-600 dark:focus:ring-opacity-40 dark:active:border-gray-700"
                    aria-haspopup="true">
                    <svg class="hi-mini hi-user-circle inline-block h-5 w-5 lg:hidden"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-5.5-2.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zM10 12a5.99 5.99 0 00-4.793 2.39A6.483 6.483 0 0010 16.5a6.483 6.483 0 004.793-2.11A5.99 5.99 0 0010 12z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="hidden lg:inline">{{ Auth::user()->name }}</span>
                    <svg class="hi-mini hi-chevron-down hidden h-5 w-5 opacity-40 lg:inline-block"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <!-- END Dropdown Toggle Button -->

                <!-- Dropdown -->
                <div x-cloak x-show="userDropdownOpen" x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="transform opacity-0 scale-75"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-75" x-on:click.outside="userDropdownOpen = false"
                    role="menu" aria-labelledby="dropdown-user"
                    class="absolute right-0 mt-2 w-48 origin-top-right rounded-lg shadow-xl focus:outline-none dark:shadow-gray-900">
                    <div
                        class="divide-y divide-gray-100 rounded-lg bg-white ring-1 ring-black ring-opacity-5 dark:divide-gray-700 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="space-y-1 p-2.5">
                            <a href="{{ route('profile.edit') }}"
                                class="group flex items-center justify-between space-x-2 rounded-lg border border-transparent px-2.5 py-2 text-sm font-medium hover:bg-primary-50 hover:text-primary-800 active:border-primary-100 dark:text-gray-300 dark:hover:bg-primary-500 dark:hover:bg-opacity-20 dark:hover:text-primary-100 dark:active:border-primary-500 dark:active:border-opacity-25">
                                <svg class="hi-mini hi-user-circle inline-block h-5 w-5 flex-none opacity-25 group-hover:opacity-50"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-5.5-2.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zM10 12a5.99 5.99 0 00-4.793 2.39A6.483 6.483 0 0010 16.5a6.483 6.483 0 004.793-2.11A5.99 5.99 0 0010 12z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="grow">Profile</span>
                            </a>

                            <a href="{{ route('warehouse.index') }}"
                                class="group flex items-center justify-between space-x-2 rounded-lg border border-transparent px-2.5 py-2 text-sm font-medium hover:bg-primary-50 hover:text-primary-800 active:border-primary-100 dark:text-gray-300 dark:hover:bg-primary-500 dark:hover:bg-opacity-20 dark:hover:text-primary-100 dark:active:border-primary-500 dark:active:border-opacity-25">
                                <svg class="hi-mini hi-cog-6-tooth inline-block h-5 w-5 flex-none opacity-25 group-hover:opacity-50"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M7.84 1.804A1 1 0 018.82 1h2.36a1 1 0 01.98.804l.331 1.652a6.993 6.993 0 011.929 1.115l1.598-.54a1 1 0 011.186.447l1.18 2.044a1 1 0 01-.205 1.251l-1.267 1.113a7.047 7.047 0 010 2.228l1.267 1.113a1 1 0 01.206 1.25l-1.18 2.045a1 1 0 01-1.187.447l-1.598-.54a6.993 6.993 0 01-1.929 1.115l-.33 1.652a1 1 0 01-.98.804H8.82a1 1 0 01-.98-.804l-.331-1.652a6.993 6.993 0 01-1.929-1.115l-1.598.54a1 1 0 01-1.186-.447l-1.18-2.044a1 1 0 01.205-1.251l1.267-1.114a7.05 7.05 0 010-2.227L1.821 7.773a1 1 0 01-.206-1.25l1.18-2.045a1 1 0 011.187-.447l1.598.54A6.993 6.993 0 017.51 3.456l.33-1.652zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="grow">Select Warehouse</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <a href=""
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                    class="group flex items-center justify-between space-x-2 rounded-lg border border-transparent px-2.5 py-2 text-sm font-medium hover:bg-primary-50 hover:text-primary-800 active:border-primary-100 dark:text-gray-300 dark:hover:bg-primary-500 dark:hover:bg-opacity-20 dark:hover:text-primary-100 dark:active:border-primary-500 dark:active:border-opacity-25">
                                    <span
                                        class="flex flex-none items-center text-primary-400 group-hover:text-primary-500 dark:group-hover:text-primary-200 opacity-25 group-hover:opacity-50">
                                        <svg class="hi-outline hi-lock-closed inline-block h-5 w-5"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                        </svg>
                                    </span>
                                    <span class="grow">Log Out</span>
                                </a>
                            </form>

                        </div>
                    </div>
                </div>
                <!-- END Dropdown -->
            </Menu>
            <!-- END User Dropdown -->
        </div>
        <!-- END Right Section -->
    </div>
</header>

{{--
