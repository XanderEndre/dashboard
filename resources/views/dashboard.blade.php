<x-app-layout>

    <!-- Page Headings: With Actions and Breadcrumb -->
    <div
        class="text-center sm:text-left sm:flex sm:items-center sm:justify-between sm:border-b-2 sm:border-gray-200 mb-4 lg:mb-5 dark:border-gray-700">
        <div class="py-3 space-y-1">
            <h2 class="text-2xl font-bold">
                Dashboard
            </h2>
            <p>Welcome <span class="text-primary-600">{{ $user->name }}</span>, everything looks great.</p>
        </div>

    </div>
    <!-- END Page Headings: With Actions and Breadcrumb -->

    <div>
        <!-- Statistics: Bordered with Info and Action -->
        <div class="grid grid-cols-1 md:grid-cols-4 sm:grid-cols-2 gap-4 lg:gap-8 mb-5">
            <!-- Card -->
            <!-- $warehouse->customers->count() -->
            <x-cards.statistic-card :number="1" :label="'Total Orders'" :description="'All orders'">
                <svg class="bi bi-box-seam inline-block w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 16 16" aria-hidden="true">
                    <path
                        d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z" />
                </svg>
            </x-cards.statistic-card>

            <x-cards.statistic-card :number="1" :label="'Customers'" :description="'All active customers'">
                <svg class="hi-outline hi-users inline-block w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
            </x-cards.statistic-card>

            <x-cards.statistic-card :number="1" :label="'Vendors'" :description="'All active vendors'">
                <svg class="bi bi-shop inline-block w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 16 16" aria-hidden="true">
                    <path
                        d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zM4 15h3v-5H4v5zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3zm3 0h-2v3h2v-3z" />
                </svg>
            </x-cards.statistic-card>

            <x-cards.statistic-card :number="1" :label="'Inventory Items'" :description="'All active inventory items'">
                <svg class="bi bi-cart-check inline-block w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                    <path
                        d="M11.354 6.354a.5.5 0 0 0-.708-.708L8 8.293 6.854 7.146a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z" />
                    <path
                        d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                </svg>
            </x-cards.statistic-card>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 lg:gap-8">
            <div class="col-span-3">
                <x-cards.card>
                    <x-cards.header :title="'Recent Orders'" :description="'Manage all recent orders'" />


                    <x-cards.body>
                        <div>Content</div>
                    </x-cards.body>
                </x-cards.card>

            </div>

            <div class="col-span-3 md:col-span-1">
                <x-cards.card>
                    <x-cards.header :title="'Recent Orders'" :description="'Manage all recent orders'" />


                    <x-cards.body>
                        <div>Content</div>
                    </x-cards.body>
                </x-cards.card>

                <x-cards.card>
                    <x-cards.header :title="'Recent Orders'" :description="'Manage all recent orders'" />


                    <x-cards.body>
                        <div>Content</div>
                    </x-cards.body>
                </x-cards.card>
            </div>
        </div>
    </div>
</x-app-layout>
