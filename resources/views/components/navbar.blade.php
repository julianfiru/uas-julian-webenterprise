<!-- Top Navbar -->
<nav class="top-navbar">
    <div class="navbar-left">
        <button class="menu-toggle" id="menuToggle">
            <i class="fas fa-bars"></i>
        </button>
        <div class="navbar-brand">
            <img src="{{ asset('logo-panda.png') }}" alt="Logo">
            <span>Sleepy Panda</span>
        </div>
    </div>
    <div class="navbar-center">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search">
        </div>
    </div>
    <div class="navbar-right">
        <div class="user-profile dropdown">
            <button class="profile-btn" id="profileBtn">
                <div class="avatar"></div>
                <span class="d-none d-md-block">Halo. {{ session('user_name') ?? 'Anthony' }}</span>
            </button>
            <div class="profile-dropdown" id="profileDropdown">
                <a href="#"><i class="fas fa-user"></i> Profile</a>
                <a href="#"><i class="fas fa-cog"></i> Settings</a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    </div>
</nav>
