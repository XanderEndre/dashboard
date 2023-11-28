<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Dashtrac') }}</title>

    <!-- Favicons -->
    <link rel="icon" href="{{ asset('favicon.svg') }}" sizes="any" type="image/svg+xml">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

    <!-- Inter web font from Bunny.net (GDPR compliant) -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Load and set dark mode preference (blocking script to prevent flashing) -->
    <script src="/js/setDarkMode.js"></script>

    <script>
        localStorage.setItem('theme_color', '{{ session('theme_color') }}');
        theme = localStorage.getItem('theme_color') != null ? localStorage.getItem('theme_color') :
        ''; // Default to empty string if no theme set
        document.documentElement.dataset.theme = theme;
    </script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <!-- Page Container -->
    <div x-data="{ userDropdownOpen: false, colorDropdownOpen: false, mobileSidebarOpen: false, desktopSidebarOpen: true, submenuInventoryOpen: false, isCustomerModalOpen: false }" id="page-container"
        class="mx-auto flex min-h-screen w-full min-w-[320px] flex-col bg-ruin dark:bg-gray-900 dark:text-gray-100 lg:pl-64"
        x-bind:class="{
            'lg:pl-64': desktopSidebarOpen
        }">

        @include('layouts.sidebar')

        @include('layouts.navigation')

        <!-- Page Content -->
        <main id="page-content" class="flex flex-auto flex-col max-w-full pt-15">
            <!-- Page Section -->
            <div class="max-w-10xl mx-auto p-4 lg:p-8 w-full">
                @if (session('success'))
                    <div class="mb-5">
                        <div class="border-l-4 border-primary-400 bg-primary-50 p-4 ">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">

                                    <svg class="bi bi-check-circle-fill w-5 h-5 text-primary-400"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16"
                                        aria-hidden="true">
                                        <path
                                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                    </svg>
                                </div>

                                <div class="ml-3">
                                    <p class="text-sm text-primary-700">
                                        Success!
                                        <span
                                            class="font-medium text-primary-700 underline hover:text-primary-600">
                                            {{ session('success') }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif


                @if (session('error'))
                    <div class="mb-5">
                        <div class="border-l-4 border-red-500 bg-red-50 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-red-700">
                                        Error!
                                        <span class="font-medium text-red-700 underline hover:text-red-600">
                                            {{ session('error') }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{ $slot }}

            </div>
            <!-- END Page Section -->
        </main>
        <!-- END Page Content -->

        <!-- Page Footer -->
        <footer id="page-footer" class="flex flex-none items-center bg-white dark:bg-gray-800 dark:bg-opacity-50">
            <div
                class="text-center flex flex-col md:text-left md:flex-row md:justify-between text-sm max-w-10xl mx-auto px-4 lg:px-8 w-full">
                <div class="pt-4 pb-1 md:pb-4">
                    <a href="https://dashtrac.net" target="_blank">DashTrac.net</a>
                    © {{ now()->year }}
                </div>
                <div class="inline-flex items-center justify-center pb-4 pt-1 md:pt-4">
                    <span>Crafted with</span>
                    <svg class="hi-solid hi-heart mx-1 inline-block h-4 w-4 text-red-600" fill="currentColor"
                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>by
                        <a href="https://xanderendre.com" target="_blank">Xander
                            Endre</a></span>
                </div>
            </div>
        </footer>
        <!-- END Page Footer -->
    </div>

</body>

</html>
