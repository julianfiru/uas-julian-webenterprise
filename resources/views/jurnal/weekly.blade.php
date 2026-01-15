@extends('layouts.app')

@section('title', 'Jurnal Tidur Weekly - Sleepy Panda')

@section('content')
    <h4 class="text-center text-white mb-3">Jurnal Tidur Report</h4>

    <!-- Main Container Card -->
    <div class="main-card" style="background: #232845; border-radius: 20px; padding: 15px;">
        
        <!-- HEADER ROW: Dropdown -->
        <div class="d-flex justify-content-end align-items-center mb-3">
            <select id="jurnalFilter" class="custom-select-button" onchange="window.location.href=this.value">
                <option value="{{ route('jurnal.daily') }}">Daily</option>
                <option value="{{ route('jurnal.weekly') }}" selected>Weekly</option>
                <option value="{{ route('jurnal.monthly') }}">Monthly</option>
            </select>
        </div>

        <!-- CONTENT ROW -->
        <div class="row g-3">
            <!-- Left: Summary Card -->
            <div class="col-lg-4">
                <div class="summary-card-dark p-3" style="height: 250px;">
                    <div class="text-center text-white mb-3">1 Juni - 7 Juni 2023</div>
                    <div class="row g-2 align-items-center">
                        <div class="col-3 text-center">
                            <div class="emoji-md">😑</div>
                            <div class="tiny-label">User</div>
                            <div class="fw-bold text-white">4000</div>
                        </div>
                        <div class="col-9">
                            <div class="row g-2">
                                <div class="col-6 text-center">
                                    <i class="fas fa-clock text-danger"></i>
                                    <div class="tiny-label">Avg Durasi</div>
                                    <div class="fw-bold text-white small">8j 2m</div>
                                </div>
                                <div class="col-6 text-center">
                                    <i class="fas fa-star text-warning"></i>
                                    <div class="tiny-label">Total Durasi</div>
                                    <div class="fw-bold text-white small">60j 51m</div>
                                </div>
                                <div class="col-6 text-center">
                                    <i class="fas fa-bed text-primary"></i>
                                    <div class="tiny-label">Avg Mulai</div>
                                    <div class="fw-bold text-white small">21:08</div>
                                </div>
                                <div class="col-6 text-center">
                                    <i class="fas fa-sun text-warning"></i>
                                    <div class="tiny-label">Avg Bangun</div>
                                    <div class="fw-bold text-white small">06:30</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Chart -->
            <div class="col-lg-8">
                <div class="report-chart-box p-3" style="background: #2b3052; border-radius: 12px; height: 250px;">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="text-white m-0" style="font-size: 18px;">Weekly Report</h5>
                        <div class="text-white small">1 Juni - 7 Juni 2023 <i class="fas fa-chevron-down ms-1"></i></div>
                    </div>
                    <div style="height: 180px;">
                        <canvas id="weeklyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/jurnal.js') }}"></script>
@endpush
