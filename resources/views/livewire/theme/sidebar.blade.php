<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>


                <livewire:components.menu-item
                    :url="'home'"
                    :icon="'ri-dashboard-line'"
                    :label="'Dashboard'"
                    :hasSubMenu="false" />

                <!-- profile -->
                <livewire:components.menu-item
                    :url="'profile'"
                    :icon="'ri-dashboard-line'"
                    :label="'Profile'"
                    :hasSubMenu="false" />

                <livewire:components.menu-item
                    :url="''"
                    :icon="'ri-layout-3-line'"
                    :label="'Income'"
                    :hasSubMenu="true"
                    :subMenuItems="
                    [
                        ['url' => 'resource.index', 'label' => 'Resource'],
                        ['url' => 'income.index', 'label' => 'Income'],
                    ]" />

                <!-- expense -->
                <livewire:components.menu-item
                    :url="''"
                    :icon="'ri-layout-3-line'"
                    :label="'Expense'"
                    :hasSubMenu="true"
                    :subMenuItems="
                    [
                        ['url' => 'category.index', 'label' => 'Category'],
                        ['url' => 'expense.index', 'label' => 'Expense'],
                    ]" />


                <livewire:components.menu-item
                    :url="'report.index'"
                    :icon="'ri-dashboard-line'"
                    :label="'Report'"
                    :hasSubMenu="false" />
                


                <li>
                    <a href="#" wire:navigate class=" waves-effect">
                        <i class="ri-calendar-2-line"></i>
                        <span>Change password</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>