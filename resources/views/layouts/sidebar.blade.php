<!-- Page Sidebar -->
<nav id="page-sidebar"
    class="dark fixed bottom-0 left-0 top-0 z-50 flex h-full w-full flex-col border-r border-gray-800 bg-gray-800 text-gray-200 transition-transform duration-500 ease-out lg:w-64 -translate-x-full lg:translate-x-0"
    x-bind:class="{
        '-translate-x-full': !mobileSidebarOpen,
        'translate-x-0': mobileSidebarOpen,
        'lg:-translate-x-full': !desktopSidebarOpen,
        'lg:translate-x-0': desktopSidebarOpen,
    }"
    aria-label="Main Sidebar Navigation">
    <!-- Sidebar Header -->
    <div class="flex h-16 w-full flex-none items-center justify-between px-4 dark:bg-gray-600 dark:bg-opacity-25">
        <!-- Brand -->
        <a href=""
            class="group inline-flex items-center text-left space-x-2 text-lg font-bold text-gray-900 active:opacity-90 dark:font-semibold dark:text-gray-100">
            <span>DashTrac</span>
        </a>
        <!-- END Brand -->
        <div>
            {{-- <button type="button" class="bg-gray-900 p-1 rounded text-center items-center space-x-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" aria-hidden="true" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z">
                    </path>
                </svg>
            </button> --}}
            <Menu as="div" class="relative inline-block z-100">
                <!-- Dropdown Toggle Button -->
                <button x-bind:aria-expanded="colorDropdownOpen" x-on:click="colorDropdownOpen = true" type="button"
                    id="dropdown-user"
                    class="inline-flex items-center justify-center space-x-1 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-semibold leading-5 text-gray-800 hover:border-gray-300 hover:text-gray-900 hover:shadow-sm focus:ring focus:ring-gray-300 focus:ring-opacity-25 active:border-gray-200 active:shadow-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:border-gray-600 dark:hover:text-gray-200 dark:focus:ring-gray-600 dark:focus:ring-opacity-40 dark:active:border-gray-700"
                    aria-haspopup="true">
                    <svg class="hi-mini hi-user-circle inline-block h-5 w-5 lg:hidden"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-5.5-2.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zM10 12a5.99 5.99 0 00-4.793 2.39A6.483 6.483 0 0010 16.5a6.483 6.483 0 004.793-2.11A5.99 5.99 0 0010 12z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="hidden lg:inline"> <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                            class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4.098 19.902a3.75 3.75 0 005.304 0l6.401-6.402M6.75 21A3.75 3.75 0 013 17.25V4.125C3 3.504 3.504 3 4.125 3h5.25c.621 0 1.125.504 1.125 1.125v4.072M6.75 21a3.75 3.75 0 003.75-3.75V8.197M6.75 21h13.125c.621 0 1.125-.504 1.125-1.125v-5.25c0-.621-.504-1.125-1.125-1.125h-4.072M10.5 8.197l2.88-2.88c.438-.439 1.15-.439 1.59 0l3.712 3.713c.44.44.44 1.152 0 1.59l-2.879 2.88M6.75 17.25h.008v.008H6.75v-.008z">
                            </path>
                        </svg></span>
                    <svg class="hi-mini hi-chevron-down hidden h-5 w-5 opacity-40 lg:inline-block"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <!-- END Dropdown Toggle Button -->

                <!-- Dropdown -->
                <div x-cloak x-show="colorDropdownOpen" x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="transform opacity-0 scale-75"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-75" x-on:click.outside="colorDropdownOpen = false"
                    role="menu" aria-labelledby="dropdown-user"
                    class="absolute right-0 mt-2 w-48 origin-top-right rounded-lg shadow-xl focus:outline-none dark:shadow-gray-900">
                    <div
                        class="divide-y divide-gray-100 rounded-lg bg-white ring-1 ring-black ring-opacity-5 dark:divide-gray-700 dark:bg-gray-800 dark:ring-gray-700">
                        <div class="space-y-1 p-2.5">
                            <form method="POST" action="{{ route('profile.update.color') }}">
                                @csrf <!-- CSRF Token -->
                                <input type="hidden" name="theme_color" id="theme_color" value="">

                                <button type="submit" id="darkModeToggle" value=""
                                    class="w-full text-left group flex items-center justify-between space-x-2 rounded-lg border border-transparent px-2.5 py-2 text-sm font-medium hover:bg-primary-50 hover:text-primary-800 active:border-primary-100 dark:text-gray-300 dark:hover:bg-primary-500 dark:hover:bg-opacity-20 dark:hover:text-primary-100 dark:active:border-primary-500 dark:active:border-opacity-25">
                                    <span
                                        class="mr-2 inline-block h-3 w-3 rounded-full border-2 border-white border-opacity-75 bg-red-500"></span>
                                    <span class="grow">Dark Mode</span>
                                </button>

                                <button type="submit" name="theme_color" value="red"
                                    class="w-full text-left group flex items-center justify-between space-x-2 rounded-lg border border-transparent px-2.5 py-2 text-sm font-medium hover:bg-primary-50 hover:text-primary-800 active:border-primary-100 dark:text-gray-300 dark:hover:bg-primary-500 dark:hover:bg-opacity-20 dark:hover:text-primary-100 dark:active:border-primary-500 dark:active:border-opacity-25">
                                    <span
                                        class="mr-2 inline-block h-3 w-3 rounded-full border-2 border-white border-opacity-75 bg-red-500"></span>
                                    <span class="grow">Red</span>
                                </button>

                                <button type="submit" name="theme_color" value="orange"
                                    class="w-full text-left group flex items-center justify-between space-x-2 rounded-lg border border-transparent px-2.5 py-2 text-sm font-medium hover:bg-primary-50 hover:text-primary-800 active:border-primary-100 dark:text-gray-300 dark:hover:bg-primary-500 dark:hover:bg-opacity-20 dark:hover:text-primary-100 dark:active:border-primary-500 dark:active:border-opacity-25">
                                    <span
                                        class="mr-2 inline-block h-3 w-3 rounded-full border-2 border-white border-opacity-75 bg-orange-500"></span>
                                    <span class="grow">Orange</span>
                                </button>

                                <button type="submit" name="theme_color" value="yellow"
                                    class="w-full text-left group flex items-center justify-between space-x-2 rounded-lg border border-transparent px-2.5 py-2 text-sm font-medium hover:bg-primary-50 hover:text-primary-800 active:border-primary-100 dark:text-gray-300 dark:hover:bg-primary-500 dark:hover:bg-opacity-20 dark:hover:text-primary-100 dark:active:border-primary-500 dark:active:border-opacity-25">
                                    <span
                                        class="mr-2 inline-block h-3 w-3 rounded-full border-2 border-white border-opacity-75 bg-yellow-500"></span>
                                    <span class="grow">Yellow</span>
                                </button>

                                <button type="submit" name="theme_color" value="green"
                                    class="w-full text-left group flex items-center justify-between space-x-2 rounded-lg border border-transparent px-2.5 py-2 text-sm font-medium hover:bg-primary-50 hover:text-primary-800 active:border-primary-100 dark:text-gray-300 dark:hover:bg-primary-500 dark:hover:bg-opacity-20 dark:hover:text-primary-100 dark:active:border-primary-500 dark:active:border-opacity-25">
                                    <span
                                        class="mr-2 inline-block h-3 w-3 rounded-full border-2 border-white border-opacity-75 bg-green-500"></span>
                                    <span class="grow">Green</span>
                                </button>

                                <button type="submit" name="theme_color" value="blue"
                                    class="w-full text-left group flex items-center justify-between space-x-2 rounded-lg border border-transparent px-2.5 py-2 text-sm font-medium hover:bg-primary-50 hover:text-primary-800 active:border-primary-100 dark:text-gray-300 dark:hover:bg-primary-500 dark:hover:bg-opacity-20 dark:hover:text-primary-100 dark:active:border-primary-500 dark:active:border-opacity-25">
                                    <span
                                        class="mr-2 inline-block h-3 w-3 rounded-full border-2 border-white border-opacity-75 bg-blue-500"></span>
                                    <span class="grow">Blue</span>
                                </button>

                                <button type="submit" name="theme_color" value="purple"
                                    class="w-full text-left group flex items-center justify-between space-x-2 rounded-lg border border-transparent px-2.5 py-2 text-sm font-medium hover:bg-primary-50 hover:text-primary-800 active:border-primary-100 dark:text-gray-300 dark:hover:bg-primary-500 dark:hover:bg-opacity-20 dark:hover:text-primary-100 dark:active:border-primary-500 dark:active:border-opacity-25">
                                    <span
                                        class="mr-2 inline-block h-3 w-3 rounded-full border-2 border-white border-opacity-75 bg-purple-500"></span>
                                    <span class="grow">Purple</span>
                                </button>

                                <button type="submit" name="theme_color" value="pink"
                                    class="w-full text-left group flex items-center justify-between space-x-2 rounded-lg border border-transparent px-2.5 py-2 text-sm font-medium hover:bg-primary-50 hover:text-primary-800 active:border-primary-100 dark:text-gray-300 dark:hover:bg-primary-500 dark:hover:bg-opacity-20 dark:hover:text-primary-100 dark:active:border-primary-500 dark:active:border-opacity-25">
                                    <span
                                        class="mr-2 inline-block h-3 w-3 rounded-full border-2 border-white border-opacity-75 bg-pink-500"></span>
                                    <span class="grow">Pink</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- END Dropdown -->
            </Menu>
            <!-- END User Dropdown -->
            {{-- <button type="button" class="bg-gray-900 p-1 rounded text-center items-center space-x-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" aria-hidden="true" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4.098 19.902a3.75 3.75 0 005.304 0l6.401-6.402M6.75 21A3.75 3.75 0 013 17.25V4.125C3 3.504 3.504 3 4.125 3h5.25c.621 0 1.125.504 1.125 1.125v4.072M6.75 21a3.75 3.75 0 003.75-3.75V8.197M6.75 21h13.125c.621 0 1.125-.504 1.125-1.125v-5.25c0-.621-.504-1.125-1.125-1.125h-4.072M10.5 8.197l2.88-2.88c.438-.439 1.15-.439 1.59 0l3.712 3.713c.44.44.44 1.152 0 1.59l-2.879 2.88M6.75 17.25h.008v.008H6.75v-.008z">
                    </path>
                </svg>
            </button> --}}
        </div>

        <!-- Close Sidebar on Mobile -->
        <div class="lg:hidden">
            <button x-on:click="mobileSidebarOpen = false" type="button"
                class="inline-flex items-center justify-center space-x-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-semibold leading-5 text-gray-800 hover:border-gray-300 hover:text-gray-900 hover:shadow-sm focus:ring focus:ring-gray-300 focus:ring-opacity-25 active:border-gray-200 active:shadow-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:border-gray-600 dark:hover:text-gray-200 dark:focus:ring-gray-600 dark:focus:ring-opacity-40 dark:active:border-gray-700">
                <svg class="hi-mini hi-x-mark -mx-0.5 inline-block h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path
                        d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                </svg>
            </button>
        </div>
        <!-- END Close Sidebar on Mobile -->
    </div>
    <!-- END Sidebar Header -->

    <!-- Sidebar Navigation -->
    <div id="simplebar" class="sidebar-scroll-section-warehouse">
        <div class="w-full p-4">
            <nav class="space-y-1">
                <div class="px-3 pb-2 pt-5 text-xs font-semibold uppercase tracking-wider text-gray-500">
                    Warehouse


                </div>
                <x-navigation.nav-link :route="'dashboard.index'" :label="'Dashboard'">
                    <svg class="hi-outline hi-home inline-block h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                </x-navigation.nav-link>
                @if (auth()->user()->activeWarehouse != null)
                    @if (auth()->user()->activeWarehouse->warehouse_owner_id == auth()->user()->id)
                        <x-navigation.dropdown label="Settings" :dropdownName="'settings'" :submenuItems="[
                            'Modify Warehouse' => 'warehouse.edit',
                            'Employees' => 'warehouse.employee.index',
                            'Audit Logs' => 'warehouse.tenants.logs.index',
                        ]">
                            <svg class="hi-outline hi-cog-8-tooth inline-block h-5 w-5"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 011.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 01-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.397.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 01-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.107-1.204l-.527-.738a1.125 1.125 0 01.12-1.45l.773-.773a1.125 1.125 0 011.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </x-navigation.dropdown>
                    @endif
                @endif


                <div class="px-3 pb-2 pt-5 text-xs font-semibold uppercase tracking-wider text-gray-500">
                    Orders
                </div>
                <x-navigation.nav-link :route="'warehouse.edit'" :label="'Orders'">
                    <svg class="hi-outline hi-home inline-block h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                </x-navigation.nav-link>

                <div class="px-3 pb-2 pt-5 text-xs font-semibold uppercase tracking-wider text-gray-500">
                    Inventory
                </div>

                <x-navigation.nav-link :route="'warehouse.tenants.inventory.index'" :label="'Items'">
                    <svg class="bi bi-basket inline-block w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                        <path
                            d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1v4.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 13.5V9a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h1.217L5.07 1.243a.5.5 0 0 1 .686-.172zM2 9v4.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V9H2zM1 7v1h14V7H1zm3 3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 4 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 6 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 8 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5z" />
                    </svg>
                </x-navigation.nav-link>
                <x-navigation.dropdown label="Recipes" :dropdownName="'recipes'" :submenuItems="[
                    'Recipes' => 'warehouse.tenants.inventory.recipes.index',
                    'Recipe Packaging' => 'warehouse.tenants.inventory.recipes.packaging.index',
                    'Recipe Types' => 'warehouse.tenants.inventory.recipes.packaging.types.index',
                    'Recipe Decorations' => 'warehouse.tenants.inventory.recipes.packaging.decorations.index',
                ]">
                    <svg class="hi-outline hi-cog-8-tooth inline-block h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 011.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 01-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.397.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 01-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.107-1.204l-.527-.738a1.125 1.125 0 01.12-1.45l.773-.773a1.125 1.125 0 011.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </x-navigation.dropdown>
                <x-navigation.nav-link :route="'warehouse.inventory.items.index'" :label="'Recipes'">
                    <svg class="bi bi-box-seam inline-block w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                        <path
                            d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z" />
                    </svg>
                </x-navigation.nav-link>
                {{-- 
                <x-navigation.nav-link :route="'warehouse.inventory.index'" :label="'Inventory'">
                    <svg class="bi bi-box-seam inline-block w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                        <path
                            d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z" />
                    </svg>
                </x-navigation.nav-link> --}}
                {{-- <x-navigation.nav-link :route="'warehouse.inventory.categories.index'" :label="'Categories'">
                     <svg class="bi bi-card-checklist inline-block w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                        <path
                            d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                        <path
                            d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z" />
                    </svg>
                </x-navigation.nav-link> --}}
                {{-- <x-navigation.nav-link :route="'warehouse.inventory.products.index'" :label="'Products'">
                    <svg class="bi bi-back inline-block w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                        <path
                            d="M0 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v2h2a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-2H2a2 2 0 0 1-2-2V2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H2z" />
                    </svg>
                </x-navigation.nav-link> --}}




                <div class="px-3 pb-2 pt-5 text-xs font-semibold uppercase tracking-wider text-gray-500">
                    Customers
                </div>
                <x-navigation.nav-link :route="'warehouse.customer.index'" :label="'Customers'">
                    <svg class="bi bi-people inline-block w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                        <path
                            d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z" />
                    </svg>
                </x-navigation.nav-link>


                <div class="px-3 pb-2 pt-5 text-xs font-semibold uppercase tracking-wider text-gray-500">
                    Vendors
                </div>
                <x-navigation.nav-link :route="'warehouse.vendor.index'" :label="'Vendors'">
                    <svg class="bi bi-shop inline-block w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                        <path
                            d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zM4 15h3v-5H4v5zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3zm3 0h-2v3h2v-3z" />
                    </svg>
                </x-navigation.nav-link>

                <div class="px-3 pb-2 pt-5 text-xs font-semibold uppercase tracking-wider text-gray-500">
                    Account
                </div>
                <x-navigation.nav-link :route="'profile.edit'" :label="'Profile'">
                    <svg class="hi-outline hi-user-circle inline-block h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </x-navigation.nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <a href="#"
                        onclick="event.preventDefault();
                    this.closest('form').submit();"
                        class="group flex items-center space-x-2 rounded-lg border border-transparent px-2.5 text-sm font-medium text-gray-800 hover:bg-primary-50 hover:text-gray-900 dark:border-transparent dark:text-gray-200 dark:hover:bg-gray-700/75 dark:hover:text-white">
                        <span
                            class="flex flex-none items-center text-gray-400 group-hover:text-primary-500 dark:group-hover:text-primary-200">
                            <svg class="hi-outline hi-lock-closed inline-block h-5 w-5"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        </span>
                        <span class="grow py-2">Log Out</span>
                    </a>
                </form>

            </nav>
        </div>
    </div>
    <!-- END Sidebar Navigation -->
</nav>
<!-- Page Sidebar -->
