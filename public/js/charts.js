// Grafico de horas trabalhadas
document.addEventListener('DOMContentLoaded', function() {
    var canvas = document.getElementById('chart-dias');
    if (!canvas || !chartData) return;

    new Chart(canvas, {
        type: 'line',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Horas trabalhadas',
                data: chartData.data,
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37,99,235,0.06)',
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#2563eb',
                pointBorderWidth: 2.5,
                borderWidth: 2.5,
            }, {
                label: 'Meta (8h)',
                data: Array(chartData.labels.length).fill(8),
                borderColor: '#ef4444',
                borderWidth: 1.5,
                borderDash: [6, 4],
                pointRadius: 0,
                fill: false,
                tension: 0,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 11,
                    ticks: { stepSize: 2, font: { size: 10 }, callback: function(v) { return v + 'h'; } },
                    grid: { color: '#f3f4f6' }
                },
                x: {
                    ticks: { font: { size: 10 } },
                    grid: { display: false }
                }
            }
        }
    });
});