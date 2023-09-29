<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <li>
                    <a href="{{route('admin.dashboard')}}" class="waves-effect">
                        <i class="ri-dashboard-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="menu-title">Contests</li>
                <li>
                    <a href="{{route('admin.categories')}}" class=" waves-effect">
                        <i class="fa fa-folder"></i>
                        <span>Categories</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.contestants')}}" class=" waves-effect">
                        <i class="fas fa-users"></i>
                        <span>All Contestants</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.results')}}" class=" waves-effect">
                        <i class="fas fa-check"></i>
                        <span>Voting Results</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-file-text-line"></i>
                        <span>Transactions</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="{{route('admin.payment.history')}}">Payment History</a></li>
                        <li><a href="{{route('admin.voting.history')}}">Free Voting History</a></li>
                    </ul>
                </li>

                <li class="menu-title">Settings</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fa fa-cog"></i>
                        <span>Settings</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="{{route('admin.settings.payment')}}">Payment Settings</a></li>
                        <li><a href="{{route('admin.settings')}}">General Settings</a></li>
                    </ul>
                </li>
                <li class="menu-title">Account</li>
                <li>
                    <a href="{{route('admin.profile')}}" class=" waves-effect">
                        <i class="fa fa-user-cog"></i>
                        <span>Account Settings</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('logout')}}" class=" waves-effect">
                        <i class="fa fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
