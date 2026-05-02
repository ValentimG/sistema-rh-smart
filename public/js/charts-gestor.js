document.addEventListener('DOMContentLoaded', function() {
    // Grafico de barras: banco de horas
    var canvasBanco = document.getElementById('chart-banco');
    if (canvasBanco && typeof chartBancoLabels !== 'undefined' && typeof chartBancoData !== 'undefined') {
        new Chart(canvasBanco, {
            type: 'bar',
            data: {
                labels: chartBancoLabels,
                datasets: [{
                    data: chartBancoData,
                    backgroundColor: chartBancoData.map(function(v) { return v >= 0 ? 'rgba(37,99,235,0.75)' : 'rgba(239,68,68,0.75)'; }),
                    borderRadius: 5,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { ticks: { font: { size: 10 }, callback: function(v) { return v + 'h'; } }, grid: { color: '#f3f4f6' } },
                    x: { ticks: { font: { size: 10 } }, grid: { display: false } }
                }
            }
        });
    }

    // Grafico de pizza: presenca
    var canvasPresenca = document.getElementById('chart-presenca');
    if (canvasPresenca && typeof chartPresentes !== 'undefined' && typeof chartAusentes !== 'undefined') {
        new Chart(canvasPresenca, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [chartPresentes, chartAusentes],
                    backgroundColor: ['rgba(5,150,105,.85)', 'rgba(239,68,68,.8)'],
                    borderWidth: 0,
                }]
            },
            options: { responsive: false, cutout: '70%', plugins: { legend: { display: false } } }
        });
    }
});