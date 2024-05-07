<nav class="pcoded-navbar">
    <div class="nav-list">
        <div class="pcoded-inner-navbar main-menu">
            <div class="pcoded-navigation-label">Dashboard</div>
            <ul class="pcoded-item pcoded-left-item">
                <li @class(['active' => Request::is('dashboard')])>
                    <a href="{{ route('dashboard.index') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="feather icon-home"></i>
                        </span>
                        <span class="pcoded-mtext">Dashboard</span>
                    </a>
                </li>
            </ul>

            @canany(['view invoice', 'view product', 'view order'])
                <div class="pcoded-navigation-label">Sales</div>
            @endcanany
            <ul class="pcoded-item pcoded-left-item">
                @can('view invoice')
                    <li class="">
                        <a href="" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="feather icon-edit"></i>
                            </span>
                            <span class="pcoded-mtext">Invoices</span>
                        </a>
                    </li>
                @endcan
                @can('view product')
                    <li class=" ">
                        <a href="" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="fas fa-cube"></i>
                            </span>
                            <span class="pcoded-mtext">Manage Products</span>
                        </a>
                    </li>
                @endcan

                @can('view order')
                    <li class=" ">
                        <a href="" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="fas fa-cube"></i>
                            </span>
                            <span class="pcoded-mtext">Manage Orders</span>
                        </a>
                    </li>
                @endcan
            </ul>

            @canany(['view user', 'view customer', 'view vehicle configuration', 'view vehicle', 'view branch', 'view
                inquiry', 'view inspection', 'view job'])
                <div class="pcoded-navigation-label">Administrator</div>
            @endcanany
            <ul class="pcoded-item pcoded-left-item">
                @can('view user')
                    <li @class([
                        'active' => Request::is('users', 'users/create', 'users/*/edit'),
                    ])>
                        <a href="{{ route('users.index') }}" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="feather icon-user"></i>
                            </span>
                            <span class="pcoded-mtext">User Management</span>
                        </a>
                    </li>
                @endcan
                @can('view customer')
                    <li class=" ">
                        <a href="" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="feather icon-users"></i>
                            </span>
                            <span class="pcoded-mtext">Customer Management</span>
                        </a>
                    </li>
                @endcan
                @can('view vehicle configuration')
                    <li @class([
                        'pcoded-hasmenu',
                        'pcoded-trigger active' => Request::is(
                            'vehicle-categories',
                            'vehicle-types',
                            'vehicle-brands',
                            'vehicle-models'),
                    ])>
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="fas fa-car"></i></span>
                            <span class="pcoded-mtext">Vehicle Configuration</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li @class(['active' => Request::is('vehicle-categories')])>
                                <a href="{{ route('vehicle-categories.index') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Vehicle Categories</span>
                                </a>
                            </li>
                            <li @class(['active' => Request::is('vehicle-types')])>
                                <a href="{{ route('vehicle-types.index') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Vehicle Types</span>
                                </a>
                            </li>
                            <li @class(['active' => Request::is('vehicle-brands')])>
                                <a href="{{ route('vehicle-brands.index') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Vehicle Brands</span>
                                </a>
                            </li>
                            <li @class(['active' => Request::is('vehicle-models')])>
                                <a href="{{ route('vehicle-models.index') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Vehicle Models</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{ route('vehicle-model-variants.index') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Vehicle Model Variants</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('view vehicle')
                    <li class=" ">
                        <a href="" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="fas fa-car"></i>
                            </span>
                            <span class="pcoded-mtext">Vehicles Management</span>
                        </a>
                    </li>
                @endcan

                @can('view branch')
                    <li @class([
                        'active' => Request::is('branches', 'branches/create', 'branches/*/edit'),
                    ])>
                        <a href="{{ route('branches.index') }}" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="feather icon-file-text"></i>
                            </span>
                            <span class="pcoded-mtext">Branch Management</span>
                        </a>
                    </li>
                @endcan
                @can('view inquiry')
                    <li class=" ">
                        <a href="" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="feather icon-file-text"></i>
                            </span>
                            <span class="pcoded-mtext">Inquiries</span>
                        </a>
                    </li>
                @endcan
                @can('view inspection')
                    <li class=" ">
                        <a href="" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="feather icon-file-text"></i>
                            </span>
                            <span class="pcoded-mtext">Inspection</span>
                        </a>
                    </li>
                @endcan
                @can('view job')
                    <li class=" ">
                        <a href="" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="feather icon-briefcase"></i>
                            </span>
                            <span class="pcoded-mtext">Job Management</span>
                        </a>
                    </li>
                @endcan
            </ul>
            <div class="pcoded-navigation-label">Settings</div>
            <ul class="pcoded-item pcoded-left-item">
                @can('view job')
                    <li class="view email template ">
                        <a href="" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="feather icon-mail"></i>
                            </span>
                            <span class="pcoded-mtext">Email Template</span>
                        </a>
                    </li>
                @endcan
                <li class=" ">
                    <a href="" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="feather icon-settings"></i>
                        </span>
                        <span class="pcoded-mtext">Settings</span>
                    </a>
                </li>

                @can('view roles & permissions')
                    <li @class([
                        'pcoded-hasmenu',
                        'pcoded-trigger active' => Request::is('roles', 'roles-and-permissions'),
                    ])>
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="feather icon-clipboard"></i></span>
                            <span class="pcoded-mtext">Roles & Permissions</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li @class(['active' => Request::is('roles')])>
                                <a href="{{ route('roles.index') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Manage Roles</span>
                                </a>
                            </li>
                            <li @class(['active' => Request::is('roles-and-permissions')])>
                                <a href="{{ route('roles-and-permissions.index') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Roles & Permissions</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
</nav>
