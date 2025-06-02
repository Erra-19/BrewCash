<nav class="sidebar-nav">
    <ul id="sidebarnav" class="p-t-30">
        <!-- Dashboard -->
        <li class="sidebar-item">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('backend.dashboard') }}" aria-expanded="false">
                <i class="mdi mdi-view-dashboard"></i>
                <span class="hide-menu">Dashboard</span>
            </a>
        </li>
        <!-- Store Dropdown -->
        <li class="sidebar-item">
            <a href="{{ route('backend.store.index') }}" class="sidebar-link">
                <i class="mdi mdi-store"></i>
                <span class="hide-menu">Store Info</span>
            </a>
        </li>
        <!-- Products Dropdown -->
        <li class="sidebar-item">
            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                <i class="mdi mdi-shopping"></i>
                <span class="hide-menu">Products</span>
            </a>
            <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item">
                    <a href="{{ route('backend.category.index') }}" class="sidebar-link">
                        <i class="mdi mdi-chevron-right"></i>
                        <span class="hide-menu">Categories</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('backend.product.index') }}" class="sidebar-link">
                        <i class="mdi mdi-chevron-right"></i>
                        <span class="hide-menu">Products</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('backend.modifier.index') }}" class="sidebar-link">
                        <i class="mdi mdi-chevron-right"></i>
                        <span class="hide-menu">Modifiers</span>
                    </a>
                </li>
            </ul>
        </li>
        <!-- Sales & Finance Dropdown -->
        <li class="sidebar-item">
            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                <i class="mdi mdi-cash-multiple"></i>
                <span class="hide-menu">Sales & Finance</span>
            </a>
            <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item">
                    <a href="{{ route('backend.logs.index') }}" class="sidebar-link">
                        <i class="mdi mdi-chevron-right"></i>
                        <span class="hide-menu">Logs / Reports</span>
                    </a>
                </li>
                <!--<li class="sidebar-item">
                    {{-- <a href="{{ route('backend.finance.index') }}" class="sidebar-link">
                        <i class="mdi mdi-chevron-right"></i>
                        <span class="hide-menu">Finance</span>
                    </a> --}}
                    <a href="#" class="sidebar-link">
                        <i class="mdi mdi-chevron-right"></i>
                        <span class="hide-menu">Finance</span>
                    </a>
                </li>-->
            </ul>
        </li>
        <!-- Settings Dropdown -->
        <!--<li class="sidebar-item">
            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                <i class="mdi mdi-settings"></i>
                <span class="hide-menu">Settings</span>
            </a>
            <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item">
                    {{-- <a href="{{ route('backend.settings.index') }}" class="sidebar-link">
                        <i class="mdi mdi-chevron-right"></i>
                        <span class="hide-menu">General Settings</span>
                    </a> --}}
                    <a href="#" class="sidebar-link">
                        <i class="mdi mdi-chevron-right"></i>
                        <span class="hide-menu">General Settings</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    {{-- <a href="{{ route('backend.profile') }}" class="sidebar-link">
                        <i class="mdi mdi-chevron-right"></i>
                        <span class="hide-menu">Profile</span>
                    </a> --}}
                    <a href="#" class="sidebar-link">
                        <i class="mdi mdi-chevron-right"></i>
                        <span class="hide-menu">Profile</span>
                    </a>
                </li>
            </ul>
        </li>-->
        <!-- Support -->
        <!--<li class="sidebar-item">
            {{-- <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('backend.support') }}" aria-expanded="false">
                <i class="mdi mdi-lifebuoy"></i>
                <span class="hide-menu">Support</span>
            </a> --}}
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="#" aria-expanded="false">
                <i class="mdi mdi-lifebuoy"></i>
                <span class="hide-menu">Support</span>
            </a>
        </li>-->
    </ul>
</nav>