<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jurnal Tidur - Sleepy Panda</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <!-- Custom Jurnal CSS will be appended to dashboard.css or inline for now? Let's use dashboard.css updates -->
</head>
<body>
    @include('components.sidebar')

    <div class="main-content">
        @include('components.navbar')

        <div class="dashboard-content">
            <h4 class="text-center text-white mb-4">Jurnal Tidur Report</h4>

            <!-- Main Jurnal Card -->
            <!-- Main Container Card -->
            <div class="main-card p-3 p-lg-4 d-flex flex-column" style="background: #232845; border-radius: 20px; position: relative; height: calc(100vh - 140px); overflow: hidden;">
                
                <!-- Filter Dropdown (Absolute Top Right) -->
                <div class="filter-container" style="position: absolute; top: 20px; right: 20px; z-index: 10;">
                    <select id="jurnalFilter" class="custom-select-button">
                        <option value="daily" selected>Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly">Monthly</option>
                    </select>
                </div>

                <!-- DAILY VIEW (Default) -->
                <div id="daily-view" class="view-section h-100">
                    <div class="row g-3 h-100">
                        <!-- Left: Summary Cards -->
                        <div class="col-lg-4 d-flex flex-column gap-3 justify-content-between h-100" style="overflow-y: auto;">
                            <!-- Card 1 -->
                             <div class="summary-card-dark flex-fill justify-content-center">
                                <div class="text-center text-white small mb-2 opacity-75">12 Agustus 2023</div>
                                <div class="d-flex align-items-center justify-content-around px-2">
                                    <!-- User -->
                                    <div class="text-center">
                                        <div class="tiny-label mb-1">User</div>
                                        <div class="emoji-md mb-1">🤩</div>
                                        <div class="fw-bold text-white">1000</div>
                                    </div>
                                    <!-- Avg Durasi -->
                                    <div class="text-center">
                                        <div class="tiny-label mb-1">Avarage Durasi<br>tidur</div>
                                        <div class="icon-md mb-1"><i class="fas fa-clock text-danger"></i></div>
                                        <div class="fw-bold text-white small">7 jam 2 menit</div>
                                    </div>
                                    <!-- Avg Waktu -->
                                    <div class="text-center">
                                         <div class="tiny-label mb-1">Avarage Waktu<br>tidur</div>
                                        <div class="icon-md mb-1"><i class="fas fa-star text-warning"></i></div>
                                        <div class="fw-bold text-white small">21:30 - 06:10</div>
                                    </div>
                                </div>
                            </div>

                             <!-- Card 2 -->
                             <div class="summary-card-dark flex-fill justify-content-center">
                                <div class="text-center text-white small mb-2 opacity-75">12 Agustus 2023</div>
                                <div class="d-flex align-items-center justify-content-around px-2">
                                    <!-- User -->
                                    <div class="text-center">
                                        <div class="tiny-label mb-1">User</div>
                                        <div class="emoji-md mb-1">🤩</div>
                                        <div class="fw-bold text-white">1000</div>
                                    </div>
                                    <!-- Avg Durasi -->
                                    <div class="text-center">
                                        <div class="tiny-label mb-1">Avarage Durasi<br>tidur</div>
                                        <div class="icon-md mb-1"><i class="fas fa-clock text-danger"></i></div>
                                        <div class="fw-bold text-white small">7 jam 2 menit</div>
                                    </div>
                                    <!-- Avg Waktu -->
                                    <div class="text-center">
                                         <div class="tiny-label mb-1">Avarage Waktu<br>tidur</div>
                                        <div class="icon-md mb-1"><i class="fas fa-star text-warning"></i></div>
                                        <div class="fw-bold text-white small">21:30 - 06:10</div>
                                    </div>
                                </div>
                            </div>

                             <!-- Card 3 -->
                             <div class="summary-card-dark flex-fill justify-content-center">
                                <div class="text-center text-white small mb-2 opacity-75">12 Agustus 2023</div>
                                <div class="d-flex align-items-center justify-content-around px-2">
                                    <!-- User -->
                                    <div class="text-center">
                                        <div class="tiny-label mb-1">User</div>
                                        <div class="emoji-md mb-1">🤩</div>
                                        <div class="fw-bold text-white">1000</div>
                                    </div>
                                    <!-- Avg Durasi -->
                                    <div class="text-center">
                                        <div class="tiny-label mb-1">Avarage Durasi<br>tidur</div>
                                        <div class="icon-md mb-1"><i class="fas fa-clock text-danger"></i></div>
                                        <div class="fw-bold text-white small">7 jam 2 menit</div>
                                    </div>
                                    <!-- Avg Waktu -->
                                    <div class="text-center">
                                         <div class="tiny-label mb-1">Avarage Waktu<br>tidur</div>
                                        <div class="icon-md mb-1"><i class="fas fa-star text-warning"></i></div>
                                        <div class="fw-bold text-white small">21:30 - 06:10</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right: Chart -->
                        <div class="col-lg-8 h-100">
                             <div class="report-chart-box p-4 d-flex flex-column" style="background: #2b3052; border-radius: 12px; height: 100%;">
                                <div class="d-flex justify-content-between align-items-start mb-2 flex-shrink-0">
                                     <h5 class="text-white m-0 section-title" style="font-size: 20px;">Users</h5>
                                     <div class="dropdown-mock text-white small">
                                        12 Agustus 2023 <i class="fas fa-chevron-down ms-1"></i>
                                     </div>
                                </div>
                                <div class="chart-wrapper flex-grow-1" style="min-height: 0;">
                                    <canvas id="dailyChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- MONTHLY VIEW -->
                <div id="monthly-view" class="view-section" style="display: none;">
                    <div class="row h-100">
                        <div class="col-lg-5 mb-3 mb-lg-0 d-flex flex-column gap-3">
                             <div class="summary-card">
                                <div class="text-center text-white small mb-3">Juni 2023</div>
                                <div class="row g-2 align-items-center">
                                    <div class="col-2 text-center">
                                        <div class="emoji-icon">😐</div>
                                        <div class="small text-white">User</div>
                                        <div class="text-white fw-bold">5000</div>
                                    </div>
                                    <div class="col-10">
                                         <div class="row g-2">
                                            <div class="col-6"><div class="detail-item"><i class="fas fa-clock text-danger"></i><div><div class="label">Average Durasi</div><div class="value">8 jam 2 m</div></div></div></div>
                                            <div class="col-6"><div class="detail-item"><i class="fas fa-star text-warning"></i><div><div class="label">Total Durasi</div><div class="value">60 jam 51 m</div></div></div></div>
                                            <div class="col-6"><div class="detail-item"><i class="fas fa-bed text-primary"></i><div><div class="label">Average Mulai</div><div class="value">21:58</div></div></div></div>
                                            <div class="col-6"><div class="detail-item"><i class="fas fa-sun text-warning"></i><div><div class="label">Average Bangun</div><div class="value">07:10</div></div></div></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Second Card for Monthly -->
                             <div class="summary-card">
                                <div class="text-center text-white small mb-3">Mei 2023</div>
                                <div class="row g-2 align-items-center">
                                    <div class="col-2 text-center">
                                        <div class="emoji-icon">😍</div>
                                        <div class="small text-white">User</div>
                                        <div class="text-white fw-bold">8000</div>
                                    </div>
                                    <div class="col-10">
                                        <div class="row g-2">
                                            <div class="col-6"><div class="detail-item"><i class="fas fa-clock text-danger"></i><div><div class="label">Average Durasi</div><div class="value">7 jam 35 m</div></div></div></div>
                                            <div class="col-6"><div class="detail-item"><i class="fas fa-star text-warning"></i><div><div class="label">Total Durasi</div><div class="value">63 jam 18 m</div></div></div></div>
                                            <div class="col-6"><div class="detail-item"><i class="fas fa-bed text-primary"></i><div><div class="label">Average Mulai</div><div class="value">22:48</div></div></div></div>
                                            <div class="col-6"><div class="detail-item"><i class="fas fa-sun text-warning"></i><div><div class="label">Average Bangun</div><div class="value">06:40</div></div></div></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                             <div class="report-chart-box">
                                <div class="d-flex justify-content-end mb-2">
                                     <small class="text-white">Juni 2023 <i class="fas fa-chevron-down"></i></small>
                                </div>
                                <div class="chart-wrapper">
                                    <canvas id="monthlyChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- WEEKLY VIEW -->
                <div id="weekly-view" class="view-section h-100" style="display: none;">
                    <div class="row g-3 h-100">
                        <!-- Left: Summary Card -->
                        <div class="col-lg-4 d-flex flex-column h-100">
                            <div class="summary-card flex-grow-1 d-flex flex-column">
                                <div class="text-center text-white small mb-3">1 Juni - 7 Juni 2023</div>
                                <div class="row g-2 align-items-center flex-grow-1">
                                    <div class="col-3 text-center">
                                        <div class="emoji-icon">😑</div>
                                        <div class="tiny-label">User</div>
                                        <div class="text-white fw-bold">4000</div>
                                    </div>
                                    <div class="col-9">
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <div class="detail-item">
                                                    <i class="fas fa-clock text-danger"></i>
                                                    <div>
                                                        <div class="label">Average Durasi tidur</div>
                                                        <div class="value">8 jam 2 menit</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="detail-item">
                                                    <i class="fas fa-star text-warning"></i>
                                                    <div>
                                                        <div class="label">Total Durasi tidur</div>
                                                        <div class="value">60 jam 51 menit</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="detail-item">
                                                    <i class="fas fa-bed text-primary"></i>
                                                    <div>
                                                        <div class="label">Average Mulai tidur</div>
                                                        <div class="value">21:08</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="detail-item">
                                                    <i class="fas fa-sun text-warning"></i>
                                                    <div>
                                                        <div class="label">Average Bangun tidur</div>
                                                        <div class="value">06:30</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Right: Chart -->
                        <div class="col-lg-8 h-100">
                            <div class="report-chart-box weekly-chart-box p-4 d-flex flex-column" style="height: 100%;">
                                <div class="d-flex justify-content-between align-items-center mb-3 flex-shrink-0">
                                    <h5 class="text-white m-0" style="font-size: 18px;">Weekly Report</h5>
                                    <div class="dropdown-mock text-white small">
                                        1 Juni - 7 Juni 2023 <i class="fas fa-chevron-down ms-1"></i>
                                    </div>
                                </div>
                                <div class="chart-wrapper weekly-bar-wrapper flex-grow-1 d-flex flex-column justify-content-end" style="min-height: 0;">
                                    <canvas id="weeklyChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/sidebar.js') }}"></script>
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="{{ asset('js/jurnal.js') }}"></script>
</body>
</html>
