<x-app-layout>

    <!-- Page Headings: With Actions and Breadcrumb -->
    <div
        class="text-left flex items-center justify-between sm:border-b-2 sm:border-gray-200 mb-4 lg:mb-5 dark:border-gray-700">
        <div class="py-3 space-y-1">
            <div>
                <h2 class="text-2xl font-bold">
                    Task Name
                </h2>
                <p class="text-gray-300 text-sm">
                    Task Description
                </p>
            </div>
        </div>
        <div>
            <x-badges.danger>Task Not Completed</x-badges.danger>
        </div>

    </div>
    <!-- END Page Headings: With Actions and Breadcrumb -->

    <div>
        <!-- Statistics: Bordered with Info and Action -->
        <div class="grid grid-rows-3 grid-flow-col  gap-4 lg:gap-8 mb-5">
            <!-- Card -->
            <!-- $warehouse->customers->count() -->
            <x-cards.statistic-card :number="'5 Minutes'" :label="'Estimated Time'" :description="'Estimated Time this Task Takes'" />
            <x-cards.statistic-card :number="'25 Minutes'" :label="'Screen Time'" :description="'Reward for completing this task!'" />

            <div class="col-span-3 row-span-3">
                <x-cards.card>
                    <x-cards.header :title="'Task Breakdown'" :description="'A breakdown of <Task .Name>'" />


                    <x-cards.body>
                        <x-tables.table :headers="['Step Number', 'Step Name', 'Step Status', 'Actions']">
                            <tbody>
                                <tr>
                                    <x-tables.td>1</x-tables.td>
                                    <x-tables.td>Cry</x-tables.td>
                                    <x-tables.td>
                                        <x-badges.success>Completed</x-badges.success>
                                    </x-tables.td>
                                    <x-tables.td class="text-right">
                                        <x-buttons.secondary-button>View</x-buttons.danger-button>
                                        <x-buttons.danger-button>Undo</x-buttons.danger-button>
                                    </x-tables.td>
                                </tr>
                                <tr>
                                    <x-tables.td>2</x-tables.td>
                                    <x-tables.td>UrMomIsGae</x-tables.td>
                                    <x-tables.td>
                                        <x-badges.success>Completed</x-badges.success>
                                    </x-tables.td>
                                    <x-tables.td class="text-right">
                                        <x-buttons.secondary-button>View</x-buttons.danger-button>
                                        <x-buttons.danger-button>Undo</x-buttons.danger-button>
                                    </x-tables.td>
                                </tr>
                                <tr>
                                    <x-tables.td>3</x-tables.td>
                                    <x-tables.td>Cry</x-tables.td>
                                    <x-tables.td>
                                        <x-badges.warning>In Progress</x-badges.warning>
                                    </x-tables.td>
                                    <x-tables.td class="text-right">
                                        <x-buttons.secondary-button>View</x-buttons.danger-button>
                                        <x-buttons.primary-button>Complete</x-buttons.primary-button>
                                    </x-tables.td>
                                </tr>
                                <tr>
                                    <x-tables.td>4</x-tables.td>
                                    <x-tables.td>Cry</x-tables.td>
                                    <x-tables.td>
                                        <x-badges.danger>Incomplete</x-badges.danger>
                                    </x-tables.td>
                                    <x-tables.td class="text-right">
                                        <x-buttons.secondary-button>View</x-buttons.danger-button>
                                        <x-buttons.primary-button>UComplete</x-buttons.primary-button>
                                    </x-tables.td>
                                </tr>
                            </tbody>

                        </x-tables.table>
                    </x-cards.body>
                </x-cards.card>

            </div>
        </div>


    </div>
</x-app-layout>
