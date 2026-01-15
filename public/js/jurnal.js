document.addEventListener('DOMContentLoaded', function () {

    // --------------------------------------------------------------------
    // Filter Logic - Toggle between views
    // --------------------------------------------------------------------
    const jurnalFilter = document.getElementById('jurnalFilter');
    const dailyView = document.getElementById('daily-view');
    const weeklyView = document.getElementById('weekly-view');
    const monthlyView = document.getElementById('monthly-view');

    if (jurnalFilter) {
        jurnalFilter.addEventListener('change', function () {
            const selectedValue = this.value;

            // Hide all views
            if (dailyView) dailyView.style.display = 'none';
            if (weeklyView) weeklyView.style.display = 'none';
            if (monthlyView) monthlyView.style.display = 'none';

            // Show selected view
            if (selectedValue === 'daily' && dailyView) {
                dailyView.style.display = 'block';
            } else if (selectedValue === 'weekly' && weeklyView) {
                weeklyView.style.display = 'block';
            } else if (selectedValue === 'monthly' && monthlyView) {
                monthlyView.style.display = 'block';
            }
        });
    }

    // --------------------------------------------------------------------
    // Chart Configs
    // --------------------------------------------------------------------
    const chartDefaults = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: {
                grid: { color: 'rgba(255, 255, 255, 0.05)', display: false },
                ticks: { color: '#8F9BB3', font: { size: 10 } },
                border: { display: false }
            },
            x: {
                grid: { display: false },
                ticks: { color: '#8F9BB3', font: { size: 10 } },
                border: { display: false }
            }
        }
    };

    // 1. Weekly Chart (Bar)
    const weeklyCtx = document.getElementById('weeklyChart');
    if (weeklyCtx) {
        new Chart(weeklyCtx, {
            type: 'bar',
            data: {
                labels: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                datasets: [{
                    data: [5, 7, 4, 9, 7, 7, 4], // Mock data based on image height
                    backgroundColor: [
                        '#a64d5d', // Muted Red
                        '#a64d5d',
                        '#a64d5d',
                        '#ea5455', // Bright Red (Highest)
                        '#a64d5d',
                        '#a64d5d',
                        '#a64d5d'
                    ],
                    borderRadius: 4,
                    barPercentage: 0.6
                }]
            },
            options: {
                ...chartDefaults,
                scales: {
                    ...chartDefaults.scales,
                    y: { ...chartDefaults.scales.y, max: 10, ticks: { stepSize: 2, callback: v => v + 'j' } }
                }
            }
        });
    }

    // 2. Monthly Chart (Bar)
    const monthlyCtx = document.getElementById('monthlyChart');
    if (monthlyCtx) {
        new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                datasets: [{
                    data: [5, 4, 7, 7],
                    backgroundColor: [
                        '#a64d5d',
                        '#a64d5d',
                        '#a64d5d',
                        '#a64d5d'
                    ],
                    borderRadius: 4,
                    barPercentage: 0.5
                }]
            },
            options: {
                ...chartDefaults,
                scales: {
                    ...chartDefaults.scales,
                    y: { ...chartDefaults.scales.y, max: 10, ticks: { stepSize: 2, callback: v => v + 'j' } }
                }
            }
        });
    }

    // 3. Daily Chart (Line)
    const dailyCtx = document.getElementById('dailyChart');
    let dailyChartInstance = null; // Store instance

    if (dailyCtx) {
        // Destroy existing chart if it exists to prevent overlap/collision
        if (Chart.getChart(dailyCtx)) {
            Chart.getChart(dailyCtx).destroy();
        }

        dailyChartInstance = new Chart(dailyCtx, {
            type: 'line',
            data: {
                labels: ['0j', '', '2j', '', '4j', '', '6j', '', '8j'], // Labels with gaps
                datasets: [{
                    label: 'Users',
                    data: [0, 900, 90, 90, 0, 100, 50, 40, 2400], // Adjusted to match visual reference closer
                    borderColor: '#FFC107', // Yellow
                    borderWidth: 2,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#fff',
                    pointRadius: 4,
                    tension: 0 // Straight lines
                }]
            },
            options: {
                ...chartDefaults,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        ...chartDefaults.scales.y,
                        max: 2500,
                        ticks: {
                            stepSize: 500,
                            color: '#fff',
                            font: { size: 14, family: "'Poppins', sans-serif" },
                            callback: function (value, index, values) {
                                return value;
                            }
                        },
                        grid: { display: false }
                    },
                    x: {
                        ...chartDefaults.scales.x,
                        ticks: {
                            color: '#8F9BB3',
                            font: { size: 12 },
                            padding: 10,
                            autoSkip: false,
                            maxRotation: 0
                        },
                        grid: { display: false }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    }
});
