<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database User - Sleepy Panda</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <!-- Sidebar Component -->
    @include('components.sidebar')

    <!-- Main Content -->
    <div class="main-content">
        @include('components.navbar')

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <!-- Stats Row -->
            <div class="stats-row mb-4">
                <!-- Total Users -->
                <div class="stat-card">
                    <div class="stat-content">
                        <p class="stat-label">Total Users</p>
                        <div class="stat-flex">
                             <div class="stat-icon-wrapper">
                                <i class="far fa-user"></i>
                            </div>
                            <h3 class="stat-value">4500</h3>
                        </div>
                    </div>
                </div>

                <!-- Active Users -->
                <div class="stat-card">
                     <div class="stat-content">
                        <p class="stat-label">Active Users</p>
                        <div class="stat-flex">
                             <div class="stat-icon-wrapper">
                                <i class="far fa-user"></i>
                            </div>
                            <h3 class="stat-value">3500</h3>
                        </div>
                    </div>
                </div>

                <!-- New Users -->
                <div class="stat-card">
                     <div class="stat-content">
                        <p class="stat-label">New Users</p>
                        <div class="stat-flex">
                             <div class="stat-icon-wrapper">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <h3 class="stat-value">500</h3>
                        </div>
                    </div>
                </div>

                <!-- Inactive Users -->
                <div class="stat-card">
                    <div class="stat-content">
                        <p class="stat-label">Inactive Users</p>
                        <div class="stat-flex">
                            <div class="stat-icon-wrapper">
                                <i class="fas fa-user-slash"></i>
                            </div>
                            <h3 class="stat-value">500</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Database Table Card -->
             <div class="table-card-container">
                <!-- Table Controls -->
                <div class="table-controls">
                    <div class="search-bar-wide">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search by name, email, or ID">
                    </div>
                    <div class="control-actions">
                        <button class="btn-control"><i class="fas fa-filter"></i> Sort by</button>
                        <button class="btn-control"><i class="fas fa-redo"></i> Refresh</button>
                    </div>
                </div>

                <!-- Custom Table -->
                <div class="table-responsive">
                    <table class="table table-custom">
                        <thead>
                            <tr>
                                <th width="20%">User</th>
                                <th width="25%">Contact</th>
                                <th width="20%">Sleep Status</th>
                                <th width="15%">Status</th>
                                <th width="20%">Last Active</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Mock Row 1 -->
                            <tr>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-icon"><i class="far fa-user-circle"></i></div>
                                        <div>
                                            <div class="fw-bold">Alfonso de</div>
                                            <div class="text-white small">ID #418230</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="contact-cell">
                                        <div class="contact-icon"><i class="far fa-envelope"></i></div>
                                        <div>
                                            <div>Alfonso.de@gmail.com</div>
                                            <div class="small">+62123456789</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>Avg. Sleep: 7.2h</div>
                                    <div class="small">Quality: 85%</div>
                                </td>
                                <td>
                                    <span class="status-badge active">Active</span>
                                </td>
                                <td>
                                    <div>2024-02-01</div>
                                    <div class="small">14:30</div>
                                </td>
                            </tr>
                            
                            <!-- Mock Row 2 -->
                            <tr>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-icon"><i class="far fa-user-circle"></i></div>
                                        <div>
                                            <div class="fw-bold">Alfonso de</div>
                                            <div class="text-white small">ID #418230</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="contact-cell">
                                        <div class="contact-icon"><i class="far fa-envelope"></i></div>
                                        <div>
                                            <div>Alfonso.de@gmail.com</div>
                                            <div class="small">+62123456789</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>Avg. Sleep: 1.2h</div>
                                    <div class="small">Quality: 20%</div>
                                </td>
                                <td>
                                    <span class="status-badge inactive">Not Active</span>
                                </td>
                                <td>
                                    <div>2024-02-01</div>
                                    <div class="small">14:30</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
             </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/sidebar.js') }}"></script>
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>
