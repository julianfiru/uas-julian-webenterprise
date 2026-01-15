@extends('layouts.app')

@section('title', 'Jurnal Tidur Monthly - Sleepy Panda')

@section('content')
    <h4 class="text-center text-white mb-4">Jurnal Tidur Report</h4>

    <!-- Main Container Card -->
    <div class="main-card d-flex flex-column" style="background: #232845; border-radius: 20px; height: calc(100vh - 85px); min-height: 500px; padding: 15px;">
        
        <!-- HEADER ROW: Title placeholder (optional) & Dropdown -->
        <div class="d-flex justify-content-end align-items-center mb-2 flex-shrink-0">
            <div class="filter-container z-3">
                <select id="jurnalFilter" class="custom-select-button" onchange="window.location.href=this.value">
                    <option value="{{ route('jurnal.daily') }}">Daily</option>
                    <option value="{{ route('jurnal.weekly') }}">Weekly</option>
                    <option value="{{ route('jurnal.monthly') }}" selected>Monthly</option>
                </select>
            </div>
        </div>

        <!-- CONTENT ROW -->
        <div class="row g-2 flex-grow-1" style="overflow: hidden;">
             <!-- Left: Summary Cards -->
            <div class="col-lg-4 d-flex flex-column h-100 gap-2">
                 <!-- Card 1 -->
                <div class="summary-card-dark flex-fill d-flex flex-column justify-content-center py-2">
                     <div class="text-center text-white small mb-3">Juni 2023</div>
                     <div class="row g-2 align-items-center px-2">
                        <div class="col-3 text-center">
                            <div class="emoji-md mb-0">😐</div>
                            <div class="tiny-label mb-0">User</div>
                            <div class="fw-bold text-white small">5000</div>
                        </div>
                        <div class="col-9">
                            <div class="row g-2">
                                <div class="col-6"><div class="text-center"><div class="icon-md mb-0"><i class="fas fa-clock text-danger"></i></div><div class="tiny-label mb-0">Avg Durasi</div><div class="fw-bold text-white small">8j 2m</div></div></div>
                                <div class="col-6"><div class="text-center"><div class="icon-md mb-0"><i class="fas fa-star text-warning"></i></div><div class="tiny-label mb-0">Total Durasi</div><div class="fw-bold text-white small">60j 51m</div></div></div>
                                <div class="col-6"><div class="text-center"><div class="icon-md mb-0"><i class="fas fa-bed text-primary"></i></div><div class="tiny-label mb-0">Avg Mulai</div><div class="fw-bold text-white small">21:58</div></div></div>
                                <div class="col-6"><div class="text-center"><div class="icon-md mb-0"><i class="fas fa-sun text-warning"></i></div><div class="tiny-label mb-0">Avg Bangun</div><div class="fw-bold text-white small">07:10</div></div></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                 <!-- Card 2 -->
                <div class="summary-card-dark flex-fill d-flex flex-column justify-content-center py-2">
                     <div class="text-center text-white small mb-3">Mei 2023</div>
                     <div class="row g-2 align-items-center px-2">
                        <div class="col-3 text-center">
                            <div class="emoji-md mb-0">😍</div>
                            <div class="tiny-label mb-0">User</div>
                            <div class="fw-bold text-white small">8000</div>
                        </div>
                        <div class="col-9">
                            <div class="row g-2">
                                <div class="col-6"><div class="text-center"><div class="icon-md mb-0"><i class="fas fa-clock text-danger"></i></div><div class="tiny-label mb-0">Avg Durasi</div><div class="fw-bold text-white small">7j 35m</div></div></div>
                                <div class="col-6"><div class="text-center"><div class="icon-md mb-0"><i class="fas fa-star text-warning"></i></div><div class="tiny-label mb-0">Total Durasi</div><div class="fw-bold text-white small">63j 18m</div></div></div>
                                <div class="col-6"><div class="text-center"><div class="icon-md mb-0"><i class="fas fa-bed text-primary"></i></div><div class="tiny-label mb-0">Avg Mulai</div><div class="fw-bold text-white small">22:48</div></div></div>
                                <div class="col-6"><div class="text-center"><div class="icon-md mb-0"><i class="fas fa-sun text-warning"></i></div><div class="tiny-label mb-0">Avg Bangun</div><div class="fw-bold text-white small">06:40</div></div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Chart -->
            <div class="col-lg-8 h-100">
                 <div class="report-chart-box d-flex flex-column h-100 p-4" style="background: #2b3052; border-radius: 12px;">
                    <div class="d-flex justify-content-between align-items-start mb-2 flex-shrink-0">
                         <h5 class="text-white m-0 section-title" style="font-size: 20px;">Monthly Report</h5>
                         <div class="dropdown-mock text-white small">
                            Juni 2023 <i class="fas fa-chevron-down ms-1"></i>
                         </div>
                    </div>
                    <div class="chart-wrapper flex-grow-1" style="min-height: 0;">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/jurnal.js') }}"></script>
@endpush
