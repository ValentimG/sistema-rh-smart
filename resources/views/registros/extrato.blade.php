<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8"><link rel="icon" href="/favicon.svg" type="image/svg+xml"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Extrato de Horas — SMART RH</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/extrato.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    @include('layouts.header')
    <main class="pg pg-sm">
        <div class="extrato-header animate-in">
            <h1 class="extrato-title">Extrato de Banco de Horas</h1>
            <p class="extrato-sub">Acompanhe a evolucao do seu saldo nos ultimos 90 dias</p>
        </div>

        <div class="extrato-hero animate-in" style="animation-delay:.1s">
            <div class="extrato-hero-top">
                <div>
                    <div class="extrato-hero-label">Saldo Atual</div>
                    <div class="extrato-hero-valor">{{ number_format($saldoAtual, 1, ',', '.') }}h</div>
                    <div class="extrato-hero-info">{{ $saldoAtual >= 0 ? 'Voce esta com saldo positivo' : 'Voce esta com saldo negativo' }}</div>
                </div>
                <div class="extrato-hero-icon">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
            </div>
        </div>

        <div class="extrato-stats animate-in" style="animation-delay:.15s">
            <div class="extrato-stat">
                <div class="extrato-stat-value text-primary">{{ $registros->count() }}</div>
                <div class="extrato-stat-label">Registros no Periodo</div>
            </div>
            <div class="extrato-stat">
                <div class="extrato-stat-value text-success">{{ $registros->where('horasTrabalhadas()', '>=', 8)->count() }}</div>
                <div class="extrato-stat-label">Dias Completos (8h+)</div>
            </div>
            <div class="extrato-stat">
                @php $mediaPeriodo = $registros->count() > 0 ? round($registros->avg(fn($r) => $r->horasTrabalhadas()), 1) : 0; @endphp
                <div class="extrato-stat-value text-warning">{{ number_format($mediaPeriodo, 1, ',', '.') }}h</div>
                <div class="extrato-stat-label">Media Diaria</div>
            </div>
        </div>

        <div class="extrato-chart-card animate-in" style="animation-delay:.2s">
            <div class="chart-header">
                <div class="chart-title">Evolucao do Saldo</div>
                <div class="chart-legend">
                    <span><span class="chart-legend-dot" style="background:var(--success)"></span> Positivo</span>
                    <span><span class="chart-legend-dot" style="background:var(--danger)"></span> Negativo</span>
                </div>
            </div>
            <div class="chart-container"><canvas id="chart-extrato"></canvas></div>
        </div>

        <div class="extrato-table-card animate-in" style="animation-delay:.25s">
            <div class="table-responsive">
                <table class="tb">
                    <thead><tr>
                        <th>Data</th>
                        <th class="tc">Entrada</th>
                        <th class="tc">Saida</th>
                        <th class="tc">Horas</th>
                        <th class="tc">Diferenca</th>
                    </tr></thead>
                    <tbody>
                        @forelse($registros->take(30) as $r)
                        @php $diferenca = round($r->horasTrabalhadas() - 8, 2); @endphp
                        <tr>
                            <td>
                                <span class="fw-600">{{ $r->data->format('d/m/Y') }}</span>
                                <span class="text-muted text-sm">{{ ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'][$r->data->dayOfWeek] }}</span>
                            </td>
                            <td class="tc">{{ $r->entrada?->format('H:i') ?? '—' }}</td>
                            <td class="tc">{{ $r->saida?->format('H:i') ?? '—' }}</td>
                            <td class="tc fw-600">{{ $r->horasTrabalhadasFormatado() }}</td>
                            <td class="tc">
                                <span class="diferenca-badge {{ $diferenca >= 0 ? 'dif-pos' : 'dif-neg' }}">
                                    {{ $diferenca >= 0 ? '+' : '' }}{{ number_format($diferenca, 2, ',', '.') }}h
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Nenhum registro no periodo.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        var extratoLabels = {!! json_encode($labels) !!};
        var extratoSaldos = {!! json_encode($saldos) !!};
    </script>
    <script src="/js/extrato.js"></script>
    <script src="/js/dark.js"></script>
</body>
</html>
