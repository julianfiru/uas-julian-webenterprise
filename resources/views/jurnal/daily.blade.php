@extends('layouts.app')

@section('title', 'Jurnal Tidur - Sleepy Panda')

@section('content')
    <h4 class="text-center text-white mb-3">Jurnal Tidur Report</h4>

    <!-- Main Container Card -->
    <div class="main-card d-flex flex-column" style="background: #232845; border-radius: 20px; padding: 15px; height: calc(100vh - 140px);">
        
        <!-- HEADER ROW: Dropdown -->
        <div class="d-flex justify-content-end align-items-center mb-3 flex-shrink-0">
            <select id="jurnalFilter" class="custom-select-button" onchange="window.location.href=this.value">
                <option value="{{ route('jurnal.daily') }}" selected>Daily</option>
                <option value="{{ route('jurnal.weekly') }}">Weekly</option>
                <option value="{{ route('jurnal.monthly') }}">Monthly</option>
            </select>
        </div>

        <!-- CONTENT ROW -->
        <div class="row g-3 flex-grow-1" style="min-height: 0;">
            <!-- Left: Summary Cards -->
            <div class="col-lg-4 d-flex flex-column">
                <div class="d-flex flex-column gap-2 h-100 justify-content-between">
                    <!-- Card 1 -->
                    <div class="summary-card-dark p-2 flex-fill d-flex flex-column justify-content-center">
                        <div class="text-center text-white small mb-1" style="font-size: 11px;">12 Agustus 2023</div>
                        <div class="d-flex align-items-center justify-content-around">
                            <div class="text-center">
                                <div class="emoji-md">🤩</div>
                                <div class="tiny-label">User</div>
                                <div class="fw-bold text-white small">1000</div>
                            </div>
                            <div class="text-center">
                                <i class="fas fa-clock text-danger"></i>
                                <div class="tiny-label">Avg Durasi</div>
                                <div class="fw-bold text-white small">7j 2m</div>
                            </div>
                            <div class="text-center">
                                <i class="fas fa-star text-warning"></i>
                                <div class="tiny-label">Waktu</div>
                                <div class="fw-bold text-white small">21:30-06:10</div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="summary-card-dark p-2 flex-fill d-flex flex-column justify-content-center">
                        <div class="text-center text-white small mb-1" style="font-size: 11px;">11 Agustus 2023</div>
                        <div class="d-flex align-items-center justify-content-around">
                            <div class="text-center">
                                <div class="emoji-md">😴</div>
                                <div class="tiny-label">User</div>
                                <div class="fw-bold text-white small">800</div>
                            </div>
                            <div class="text-center">
                                <i class="fas fa-clock text-danger"></i>
                                <div class="tiny-label">Avg Durasi</div>
                                <div class="fw-bold text-white small">6j 45m</div>
                            </div>
                            <div class="text-center">
                                <i class="fas fa-star text-warning"></i>
                                <div class="tiny-label">Waktu</div>
                                <div class="fw-bold text-white small">22:00-06:45</div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="summary-card-dark p-2 flex-fill d-flex flex-column justify-content-center">
                        <div class="text-center text-white small mb-1" style="font-size: 11px;">10 Agustus 2023</div>
                        <div class="d-flex align-items-center justify-content-around">
                            <div class="text-center">
                                <div class="emoji-md">😑</div>
                                <div class="tiny-label">User</div>
                                <div class="fw-bold text-white small">950</div>
                            </div>
                            <div class="text-center">
                                <i class="fas fa-clock text-danger"></i>
                                <div class="tiny-label">Avg Durasi</div>
                                <div class="fw-bold text-white small">5j 30m</div>
                            </div>
                            <div class="text-center">
                                <i class="fas fa-star text-warning"></i>
                                <div class="tiny-label">Waktu</div>
                                <div class="fw-bold text-white small">23:00-05:30</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Chart -->
            <div class="col-lg-8 d-flex flex-column">
                <div class="report-chart-box p-3 d-flex flex-column flex-grow-1" style="background: #2b3052; border-radius: 12px;">
                    <div class="d-flex justify-content-between align-items-start mb-2 flex-shrink-0">
                        <h5 class="text-white m-0" style="font-size: 18px;">Users</h5>
                        <div class="text-white small">12 Agustus 2023 <i class="fas fa-chevron-down ms-1"></i></div>
                    </div>
                    <div class="flex-grow-1" style="min-height: 0; position: relative;">
                        <canvas id="dailyChart" style="position: absolute; top: 0; left: 0; width: 100% !important; height: 100% !important;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/jurnal.js') }}"></script>
@endpush
