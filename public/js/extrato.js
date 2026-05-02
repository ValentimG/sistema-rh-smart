document.addEventListener('DOMContentLoaded', function() {
    var canvas = document.getElementById('chart-extrato');
    if (!canvas || !extratoLabels || !extratoSaldos) return;

    var cores = extratoSaldos.map(function(v) {
        return v >= 0 ? 'rgba(16,185,129,.7)' : 'rgba(239,68,68,.7)';
    });

    new Chart(canvas, {
        type: 'bar',
        data: {
            labels: extratoLabels,
            datasets: [{
                data: extratoSaldos,
                backgroundColor: cores,
                borderRadius: 4,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    ticks: { font: { size: 10 }, callback: function(v) { return v + 'h'; } },
                    grid: { color: '#f3f4f6' }
                },
                x: {
                    ticks: { font: { size: 9 }, maxRotation: 45 },
                    grid: { display: false }
                }
            }
        }
    });
});
