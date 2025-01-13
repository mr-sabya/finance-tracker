<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <livewire:components.menu-item title="Dashboard" route="{{ route('home') }}" icon="ri-dashboard-line" />
                <livewire:components.menu-item title="Profile" route="{{ route('profile') }}" icon="ri-calendar-2-line" />

                <livewire:components.menu-item title="Resource" route="{{ route('resource.index') }}" icon="ri-calendar-2-line" />

                <livewire:components.menu-item title="Income" route="{{ route('income.index') }}" icon="ri-calendar-2-line" />


                <livewire:components.menu-item title="Category" route="{{ route('category.index') }}" icon="ri-calendar-2-line" />
                <livewire:components.menu-item title="Expense" route="{{ route('expense.index') }}" icon="ri-calendar-2-line" />
                <livewire:components.menu-item title="Report" route="{{ route('report.index') }}" icon="ri-calendar-2-line" />

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