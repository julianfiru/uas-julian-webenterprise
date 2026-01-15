@extends('layouts.app')

@section('title', 'Jurnal Tidur - Sleepy Panda')

@section('content')
    <h4 class="text-center text-white mb-4">Jurnal Tidur Report</h4>

    <!-- Main Container Card -->
    <div class="main-card d-flex flex-column" style="background: #232845; border-radius: 20px; height: calc(100vh - 85px); min-height: 500px; padding: 15px;">
        
        <!-- HEADER ROW: Title placeholder (optional) & Dropdown -->
        <div class="d-flex justify-content-end align-items-center mb-2 flex-shrink-0">
            <div class="filter-container z-3">
                <select id="jurnalFilter" class="custom-select-button" onchange="window.location.href=this.value">
                    <option value="{{ route('jurnal.daily') }}" selected>Daily</option>
                    <option value="{{ route('jurnal.weekly') }}">Weekly</option>
                    <option value="{{ route('jurnal.monthly') }}">Monthly</option>
                </select>
            </div>
        </div>

        <!-- CONTENT ROW -->
        <div class="row g-2 flex-grow-1" style="overflow: hidden;">
            <!-- Left: Summary Cards -->
            <div class="col-lg-4 d-flex flex-column h-100 gap-2">
                <!-- Card 1 -->
                 <div class="summary-card-dark flex-fill d-flex flex-column justify-content-center py-1">
                    <div class="text-center text-white small mb-1 opacity-75" style="font-size: 0.75rem;">12 Agustus 2023</div>
                    <div class="d-flex align-items-center justify-content-around px-1">
                        <div class="text-center">
                            <div class="tiny-label mb-0">User</div>
                            <div class="emoji-md mb-0">🤩</div>
                            <div class="fw-bold text-white small">1000</div>
                        </div>
                        <div class="text-center">
                            <div class="tiny-label mb-0">Avarage Durasi<br>tidur</div>
                            <div class="icon-md mb-0"><i class="fas fa-clock text-danger"></i></div>
                            <div class="fw-bold text-white small">7 jam 2 menit</div>
                        </div>
                        <div class="text-center">
                             <div class="tiny-label mb-0">Avarage Waktu<br>tidur</div>
                            <div class="icon-md mb-0"><i class="fas fa-star text-warning"></i></div>
                            <div class="fw-bold text-white small">21:30 - 06:10</div>
                        </div>
                    </div>
                </div>

                 <!-- Card 2 -->
                 <div class="summary-card-dark flex-fill d-flex flex-column justify-content-center py-1">
                    <div class="text-center text-white small mb-1 opacity-75" style="font-size: 0.75rem;">12 Agustus 2023</div>
                    <div class="d-flex align-items-center justify-content-around px-1">
                        <div class="text-center">
                            <div class="tiny-label mb-0">User</div>
                            <div class="emoji-md mb-0">🤩</div>
                            <div class="fw-bold text-white small">1000</div>
                        </div>
                        <div class="text-center">
                            <div class="tiny-label mb-0">Avarage Durasi<br>tidur</div>
                            <div class="icon-md mb-0"><i class="fas fa-clock text-danger"></i></div>
                            <div class="fw-bold text-white small">7 jam 2 menit</div>
                        </div>
                        <div class="text-center">
                             <div class="tiny-label mb-0">Avarage Waktu<br>tidur</div>
                            <div class="icon-md mb-0"><i class="fas fa-star text-warning"></i></div>
                            <div class="fw-bold text-white small">21:30 - 06:10</div>
                        </div>
                    </div>
                </div>

                 <!-- Card 3 -->
                 <div class="summary-card-dark flex-fill d-flex flex-column justify-content-center py-1">
                    <div class="text-center text-white small mb-1 opacity-75" style="font-size: 0.75rem;">12 Agustus 2023</div>
                    <div class="d-flex align-items-center justify-content-around px-1">
                        <div class="text-center">
                            <div class="tiny-label mb-0">User</div>
                            <div class="emoji-md mb-0">🤩</div>
                            <div class="fw-bold text-white small">1000</div>
                        </div>
                        <div class="text-center">
                            <div class="tiny-label mb-0">Avarage Durasi<br>tidur</div>
                            <div class="icon-md mb-0"><i class="fas fa-clock text-danger"></i></div>
                            <div class="fw-bold text-white small">7 jam 2 menit</div>
                        </div>
                        <div class="text-center">
                             <div class="tiny-label mb-0">Avarage Waktu<br>tidur</div>
                            <div class="icon-md mb-0"><i class="fas fa-star text-warning"></i></div>
                            <div class="fw-bold text-white small">21:30 - 06:10</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Chart -->
            <div class="col-lg-8 h-100">
                 <div class="report-chart-box d-flex flex-column h-100 p-4" style="background: #2b3052; border-radius: 12px;">
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
@endsection

@push('scripts')
    <script src="{{ asset('js/jurnal.js') }}"></script>
@endpush
