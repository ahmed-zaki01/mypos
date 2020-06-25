<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('dashboard.index')}}" class="brand-link">
        <img src="{{asset('dashboard/img')}}/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: 0.8;" />
        <span class="brand-text font-weight-normal">MyPOS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('dashboard/img')}}/avatar5.png" class="img-circle elevation-2" alt="User Image" />
            </div>
            <div class="info">
                <span class="text-light">{{auth()->user()->first_name . ' ' . auth()->user()->last_name}}</span>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="{{route('dashboard.index')}}" class="nav-link">
                        <i class="fas fa-home"></i>
                        <p class="ml-1">Dashboard</p>
                    </a>
                </li>

                @if (auth()->user()->hasPermission('read_users'))

                <li class="nav-item">
                    <a href="{{route('dashboard.users.index')}}" class="nav-link">
                        <i class="fas fa-users"></i>
                        <p class="ml-1">Users</p>
                    </a>
                </li>
                @endif

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>