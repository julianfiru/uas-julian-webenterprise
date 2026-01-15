<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h4>Admin Site</h4>
        <button class="sidebar-close" id="sidebarClose">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <nav class="sidebar-nav">
        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <span>Dashboard</span>
        </a>
        <a href="{{ route('jurnal.daily') }}" class="sidebar-link {{ request()->routeIs('jurnal.*') ? 'active' : '' }}">
            <span>Jurnal</span>
        </a>
        <a href="#" class="sidebar-link">
            <span>Report</span>
        </a>

        <!-- Database User Item -->
        <a href="{{ route('database-user') }}" class="sidebar-link {{ request()->routeIs('database-user') ? 'active' : '' }}">
            <span>Database User</span>
        </a>

        @if(request()->routeIs('database-user'))
            <div class="sidebar-submenu" style="display: block;">
                <a href="#" class="sidebar-link">
                    <span>Update Data</span>
                </a>
                <a href="#" class="sidebar-link">
                    <span>Reset Password</span>
                </a>
            </div>
        @endif
    </nav>
</div>
