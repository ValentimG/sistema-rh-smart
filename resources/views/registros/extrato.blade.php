<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Extrato Banco de Horas — SMART RH</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/extrato.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    @include('layouts.header')
    <main class="pg pg-sm">
        <div class="extrato-header">
            <div>
                <h1 class="extrato-title">Extrato de Banco de Horas</h1>
                <p class="extrato-sub">Acompanhe a evolucao do seu saldo de horas</p>
            </div>
        </div>

        <div class="extrato-saldo-card">
            <div>
                <div class="extrato-saldo-label">Saldo Atual</div>
                <div class="extrato-saldo-valor">{{ number_format($saldoAtual, 1, ',', '.') }}h</div>
                <div class="extrato-saldo-info">{{ $saldoAtual >= 0 ? 'Saldo positivo' : 'Saldo negativo' }}</div>
            </div>
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" opacity="0.5">
                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
            </svg>
        </div>

        <div class="extrato-chart-card">
            <div style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:var(--gray-400);margin-bottom:16px">Evolucao do Saldo (90 dias)</div>
            <div class="chart-container"><canvas id="chart-extrato"></canvas></div>
        </div>

        <div class="extrato-table-card">
            <div class="table-responsive">
                <table class="tb">
                    <thead><tr>
                        <th>Data</th>
                        <th class="tc">Entrada</th>
                        <th class="tc">Saida</th>
                        <th class="tc">Horas Trabalhadas</th>
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
                            <td class="tc {{ $diferenca >= 0 ? 'saldo-positivo' : 'saldo-negativo' }}">
                                {{ $diferenca >= 0 ? '+' : '' }}{{ number_format($diferenca, 2, ',', '.') }}h
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Nenhum registro encontrado.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script src="/js/extrato.js"></script>
    <script>
        var extratoLabels = {!! json_encode($labels) !!};
        var extratoSaldos = {!! json_encode($saldos) !!};
    </script>
    <script src="/js/dark.js"></script>
</body>
</html>