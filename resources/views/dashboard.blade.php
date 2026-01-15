@extends('layouts.app')

@section('title', 'Dashboard - Sleepy Panda')

@section('content')
    <h4 class="page-title mb-4">Dashboard</h4>

    <!-- Charts Row (Daily, Weekly, Monthly) -->
    <div class="charts-row">
        <!-- Daily Chart -->
        <div class="chart-card">
            <div class="chart-header">
                <h6>Daily Report</h6>
                <div class="chart-legend">
                    <span class="legend-item"><span class="dot female"></span> Female</span>
                    <span class="legend-item"><span class="dot male"></span> Male</span>
                </div>
            </div>
            <div class="chart-body">
                <canvas id="dailyChart"></canvas>
            </div>
        </div>

        <!-- Weekly Chart -->
        <div class="chart-card">
            <div class="chart-header">
                <h6>Weekly Report</h6>
                <div class="chart-legend">
                    <span class="legend-item"><span class="dot female"></span> Female</span>
                    <span class="legend-item"><span class="dot male"></span> Male</span>
                </div>
            </div>
            <div class="chart-body">
                <canvas id="weeklyChart"></canvas>
            </div>
        </div>

        <!-- Monthly Chart -->
        <div class="chart-card">
            <div class="chart-header">
                <h6>Monthly Report</h6>
                <div class="chart-legend">
                    <span class="legend-item"><span class="dot female"></span> Female</span>
                    <span class="legend-item"><span class="dot male"></span> Male</span>
                </div>
            </div>
            <div class="chart-body">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="stats-row">
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

        <!-- Female Users -->
        <div class="stat-card">
             <div class="stat-content">
                <p class="stat-label">Female Users</p>
                <div class="stat-flex">
                     <div class="stat-icon-wrapper">
                        <i class="far fa-user"></i>
                    </div>
                    <h3 class="stat-value">2000</h3>
                </div>
            </div>
        </div>

        <!-- Male Users -->
        <div class="stat-card">
             <div class="stat-content">
                <p class="stat-label">Male Users</p>
                <div class="stat-flex">
                     <div class="stat-icon-wrapper">
                        <i class="far fa-user"></i>
                    </div>
                    <h3 class="stat-value">2500</h3>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script>
        // Inline chart initialization if needed, but dashboard.js handles it.
        // If data needs to be dynamic from controller, pass it here.
    </script>
@endpush
