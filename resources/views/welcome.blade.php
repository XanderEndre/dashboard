<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>DashTrac</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>


</head>

<body class="antialiased">

    <!-- Hero Section: Image Side with Social Proof -->
    <div class="relative overflow-hidden bg-white dark:bg-gray-900 dark:text-gray-100">
        <!-- Main Header -->
        <header id="page-header" class="relative flex flex-none items-center py-8">
            <!-- Main Header Content -->
            <div
                class="container mx-auto flex flex-col gap-4 px-4 text-center md:flex-row md:items-center md:justify-between md:gap-0 lg:px-8 xl:max-w-7xl">
                <div class="flex flex-col items-center gap-4 text-center md:flex-row md:justify-between lg:gap-10">
                    <a href="javascript:void(0)"
                        class="group inline-flex items-center gap-2 text-lg font-bold tracking-wide text-gray-900 hover:text-gray-600 dark:text-gray-100 dark:hover:text-gray-300">
                        <x-application-logo class="w-10 h-10 text-gray-500 fill-current" />
                        <span>DashTrac</span>
                    </a>
                </div>
                <div class="flex flex-col gap-4 text-center md:flex-row md:items-center md:justify-between md:gap-0">
                    <div class="flex items-center justify-center gap-2">
                        @if (Route::has('login'))
                            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                                @auth
                                    <a href="{{ url('/dashboard') }}"
                                        class="inline-flex items-center justify-center gap-2 rounded-lg border border-transparent bg-white px-3 py-2 text-sm font-semibold leading-5 text-gray-800 hover:border-gray-300 hover:text-gray-900 hover:shadow-sm focus:ring focus:ring-gray-300 focus:ring-opacity-25 active:border-gray-200 active:shadow-none dark:bg-transparent dark:text-gray-300 dark:hover:border-gray-600 dark:hover:text-gray-200 dark:focus:ring-gray-600 dark:focus:ring-opacity-40 dark:active:border-gray-700">
                                        <span>Dashboard</span>
                                    </a>
                                @else
                                    <a href="{{ url('/login') }}"
                                        class="inline-flex items-center justify-center gap-2 rounded-lg border border-transparent bg-white px-3 py-2 text-sm font-semibold leading-5 text-gray-800 hover:border-gray-300 hover:text-gray-900 hover:shadow-sm focus:ring focus:ring-gray-300 focus:ring-opacity-25 active:border-gray-200 active:shadow-none dark:bg-transparent dark:text-gray-300 dark:hover:border-gray-600 dark:hover:text-gray-200 dark:focus:ring-gray-600 dark:focus:ring-opacity-40 dark:active:border-gray-700">
                                        <span>Sign In</span>
                                    </a>

                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}"
                                            class="group inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-semibold leading-5 text-gray-800 hover:border-gray-300 hover:text-gray-900 hover:shadow-sm focus:ring focus:ring-gray-300 focus:ring-opacity-25 active:border-gray-200 active:shadow-none dark:border-gray-700 dark:bg-transparent dark:text-gray-300 dark:hover:border-gray-600 dark:hover:text-gray-200 dark:focus:ring-gray-600 dark:focus:ring-opacity-40 dark:active:border-gray-700">
                                            <span>Sign up</span>
                                            <svg class="hi-mini hi-arrow-right inline-block h-5 w-5 opacity-50 transition group-hover:translate-x-1"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- END Main Header Content -->
        </header>
        <!-- END Main Header -->

        <!-- Hero Content -->
        <div
            class="container relative mx-auto grid grid-cols-1 gap-16 px-4 py-16 text-center lg:grid-cols-2 lg:px-8 lg:py-32 lg:text-left xl:max-w-7xl">
            <div class="lg:flex lg:items-center">
                <div>
                    <h1 class="mb-4 text-5xl font-black tracking-tight text-black dark:text-white xl:text-6xl">
                        Warehouse Management
                        Done with Ease
                    </h1>
                    <h2 class="text-lg font-medium leading-relaxed text-gray-700 dark:text-gray-300">
                        Stop worrying about your warehouse management and let us know guide you through. Start
                        today and increase productivity by 150%.
                    </h2>
                    <div class="flex items-center justify-center gap-2 pb-10 pt-5 leading-4 lg:justify-start">
                        <div class="flex-none">
                            <img src="https://cdn.tailkit.com/media/placeholders/avatar-iFgRcqHznqg-160x160.jpg"
                                alt="User Avatar"
                                class="inline-block h-10 w-10 rounded-full border-2 border-white dark:border-gray-900" />
                            <img src="https://cdn.tailkit.com/media/placeholders/avatar-bY4GXQKfZrA-160x160.jpg"
                                alt="User Avatar"
                                class="-ml-6 inline-block h-10 w-10 rounded-full border-2 border-white dark:border-gray-900" />
                            <img src="https://cdn.tailkit.com/media/placeholders/avatar-8PMvB4VyVXA-160x160.jpg"
                                alt="User Avatar"
                                class="-ml-6 inline-block h-10 w-10 rounded-full border-2 border-white dark:border-gray-900" />
                            <img src="https://cdn.tailkit.com/media/placeholders/avatar-mEZ3PoFGs_k-160x160.jpg"
                                alt="User Avatar"
                                class="-ml-6 inline-block h-10 w-10 rounded-full border-2 border-white dark:border-gray-900" />
                            <img src="https://cdn.tailkit.com/media/placeholders/avatar-euZ2n8dGUcQ-160x160.jpg"
                                alt="User Avatar"
                                class="-ml-6 inline-block h-10 w-10 rounded-full border-2 border-white dark:border-gray-900" />
                        </div>
                    </div>
                    <div class="flex flex-col justify-center gap-3 sm:flex-row sm:items-center lg:justify-start">
                        <a href="javascript:void(0)"
                            class="group inline-flex items-center justify-center gap-2 rounded-lg border border-blue-700 bg-blue-700 px-7 py-3.5 text-sm font-semibold text-white hover:border-blue-600 hover:bg-blue-600 hover:text-white focus:ring focus:ring-blue-400 focus:ring-opacity-50 active:border-blue-700 active:bg-blue-700 dark:focus:ring-blue-400 dark:focus:ring-opacity-90">
                            <span>Start for free today</span>
                            <svg class="hi-mini hi-arrow-right inline-block h-5 w-5 opacity-50 transition group-hover:translate-x-1"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="javascript:void(0)"
                            class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-7 py-3.5 text-sm font-semibold text-gray-800 hover:border-gray-300 hover:text-gray-900 hover:shadow-sm focus:ring focus:ring-gray-300 focus:ring-opacity-25 active:border-gray-200 active:shadow-none dark:border-gray-700 dark:bg-transparent dark:text-gray-300 dark:hover:border-gray-600 dark:hover:text-gray-200 dark:focus:ring-gray-600 dark:focus:ring-opacity-40 dark:active:border-gray-700">
                            <span>Learn more</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="relative lg:flex lg:items-center lg:justify-center">
                <div
                    class="absolute left-0 top-20 h-16 w-16 rounded-3xl bg-gradient-to-br from-slate-200 dark:from-slate-800">
                </div>
                <div
                    class="absolute bottom-20 right-0 h-16 w-16 rotate-12 rounded-3xl bg-gradient-to-tl from-pink-200 dark:from-pink-900">
                </div>
                <div
                    class="absolute right-0 top-0 h-16 w-16 -rotate-6 rounded-full bg-gradient-to-bl from-orange-200 dark:from-orange-800">
                </div>
                <div
                    class="absolute bottom-0 left-0 h-16 w-16 rotate-12 rounded-full bg-gradient-to-tr from-sky-200 dark:from-sky-800">
                </div>
                <div
                    class="absolute right-0 top-0 h-40 w-40 rounded-full border-2 border-orange-200 bg-white dark:border-orange-900 dark:bg-gray-900 sm:h-72 sm:w-72">
                </div>
                <div
                    class="absolute bottom-0 left-0 h-40 w-40 rounded-full border-2 border-sky-200 bg-white dark:border-sky-900 dark:bg-gray-900 sm:h-72 sm:w-72">
                </div>
                <div class="relative w-full">
                    <div class="aspect-h-1 aspect-w-1">
                        <x-application-logo class="text-gray-500 fill-current" />

                    </div>
                </div>
            </div>
        </div>
        <!-- END Hero Content -->
    </div>
    <!-- END Hero Section: Image Side with Social Proof -->

    </div>
</body>

</html>
