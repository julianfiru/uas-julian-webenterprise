// Dashboard JavaScript

document.addEventListener('DOMContentLoaded', function () {
    // --------------------------------------------------------------------
    // Chart Defaults
    // --------------------------------------------------------------------
    Chart.defaults.font.family = "'Poppins', sans-serif";
    Chart.defaults.color = "#8F9BB3";

    const colors = {
        female: '#e75e8d', // Pink
        male: '#2d6bce'    // Blue
    };

    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false, // Critical for compact sizing
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                border: { display: false },
                grid: {
                    color: 'rgba(255, 255, 255, 0.05)',
                    drawTicks: false
                },
                ticks: {
                    padding: 5,
                    font: { size: 9 } // Smaller font
                }
            },
            x: {
                border: { display: false },
                grid: { display: false },
                ticks: {
                    padding: 5,
                    font: { size: 9 } // Smaller font
                }
            }
        },
        barPercentage: 0.5,
        categoryPercentage: 0.6,
        borderRadius: 3
    };

    // --------------------------------------------------------------------
    // 1. Daily Chart
    // --------------------------------------------------------------------
    const dailyCtx = document.getElementById('dailyChart');
    if (dailyCtx) {
        new Chart(dailyCtx, {
            type: 'bar',
            data: {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                datasets: [
                    {
                        label: 'Female',
                        data: [2200, 1800, 1500, 2200, 2000, 500, 800],
                        backgroundColor: colors.female,
                    },
                    {
                        label: 'Male',
                        data: [1600, 2100, 1900, 2400, 800, 1600, 900],
                        backgroundColor: colors.male,
                    }
                ]
            },
            options: {
                ...commonOptions,
                scales: {
                    ...commonOptions.scales,
                    y: {
                        ...commonOptions.scales.y,
                        max: 2500,
                        ticks: { ...commonOptions.scales.y.ticks, stepSize: 1000 } // Reduced density
                    }
                }
            }
        });
    }

    // --------------------------------------------------------------------
    // 2. Weekly Chart
    // --------------------------------------------------------------------
    const weeklyCtx = document.getElementById('weeklyChart');
    if (weeklyCtx) {
        new Chart(weeklyCtx, {
            type: 'bar',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                datasets: [
                    {
                        label: 'Female',
                        data: [100, 1600, 1400, 2400],
                        backgroundColor: colors.female,
                    },
                    {
                        label: 'Male',
                        data: [1800, 1700, 1600, 2500],
                        backgroundColor: colors.male,
                    }
                ]
            },
            options: {
                ...commonOptions,
                barPercentage: 0.4,
                categoryPercentage: 0.5,
                scales: {
                    ...commonOptions.scales,
                    y: {
                        ...commonOptions.scales.y,
                        max: 2500,
                        ticks: { ...commonOptions.scales.y.ticks, stepSize: 500 }
                    }
                }
            }
        });
    }

    // --------------------------------------------------------------------
    // 3. Monthly Chart
    // --------------------------------------------------------------------
    const monthlyCtx = document.getElementById('monthlyChart');
    if (monthlyCtx) {
        new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt'],
                datasets: [
                    {
                        label: 'Female',
                        data: [2200, 1900, 1600, 2200, 1600, 2100, 1500, 1900, 1600, 1900],
                        backgroundColor: colors.female,
                    },
                    {
                        label: 'Male',
                        data: [1600, 2100, 1900, 2400, 700, 1600, 1600, 1900, 1400, 1900],
                        backgroundColor: colors.male,
                    }
                ]
            },
            options: {
                ...commonOptions,
                scales: {
                    ...commonOptions.scales,
                    y: {
                        ...commonOptions.scales.y,
                        max: 2500,
                        ticks: { ...commonOptions.scales.y.ticks, stepSize: 1000 }
                    }
                }
            }
        });
    }

    // --------------------------------------------------------------------
    // 4. Large Sleep Time Chart
    // --------------------------------------------------------------------
    const sleepTimeCtx = document.getElementById('sleepTimeChart');
    if (sleepTimeCtx) {
        new Chart(sleepTimeCtx, {
            type: 'line',
            data: {
                labels: ['Jan 01', 'Jan 02', 'Jan 03', 'Jan 04', 'Jan 05', 'Jan 06'],
                datasets: [
                    {
                        label: 'Female',
                        data: [2.0, 4.5, 5.0, 5.5, 6.0, 7.5],
                        borderColor: colors.female,
                        borderWidth: 2,
                        pointRadius: 4,
                        pointBackgroundColor: colors.female,
                        tension: 0.1,
                        fill: false
                    },
                    {
                        label: 'Male',
                        data: [3.0, 3.5, 4.8, 4.5, 5.5, 7.0],
                        borderColor: colors.male,
                        borderWidth: 2,
                        pointRadius: 4,
                        pointBackgroundColor: colors.male,
                        tension: 0.1,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        min: 0,
                        max: 10,
                        border: { display: false },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.05)',
                        },
                        ticks: {
                            stepSize: 2,
                            padding: 10,
                            font: { size: 10 }
                        }
                    },
                    x: {
                        border: { display: false },
                        grid: { display: false },
                        ticks: {
                            padding: 10,
                            font: { size: 10 },
                            autoSkip: false
                        }
                    }
                }
            }
        });
    }
});
