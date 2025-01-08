<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <livewire:components.menu-item title="Dashboard" route="{{ route('home') }}" icon="ri-dashboard-line" />

                <li>
                    <a href="#" wire:navigate class=" waves-effect">
                        <i class="ri-calendar-2-line"></i>
                        <span>Profile</span>
                    </a>
                </li>
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