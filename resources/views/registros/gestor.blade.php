<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard — SMART RH</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    @include('layouts.header')
    <main class="pg">
        <div class="page-header">
            <div>
                <h1 class="page-title">Dashboard</h1>
                <p class="page-sub">Visao geral da equipe</p>
            </div>
            <div class="page-date" id="page-date"></div>
        </div>

        @php $pct = $totalFuncionarios > 0 ? round($registrosHoje->count() / $totalFuncionarios * 100) : 0; @endphp

        <div class="stats-grid">
            <div class="stat-card stat-card-primary">
                <div class="stat-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
                <div class="stat-value">{{ $totalFuncionarios }}</div>
                <div class="stat-label">Total de Funcionarios</div>
            </div>
            <div class="stat-card stat-card-success">
                <div class="stat-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg></div>
                <div class="stat-value">{{ $registrosHoje->count() }}</div>
                <div class="stat-label">Presentes Hoje</div>
                <div class="progress-bar mt-3"><div class="progress-fill bg-success" style="width:{{ $pct }}%"></div></div>
                <div class="stat-sub">{{ $pct }}% do quadro</div>
            </div>
            <div class="stat-card stat-card-danger">
                <div class="stat-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></div>
                <div class="stat-value">{{ $semPontoHoje->count() }}</div>
                <div class="stat-label">Sem Registro Hoje</div>
                <div class="progress-bar mt-3"><div class="progress-fill bg-danger" style="width:{{ 100 - $pct }}%"></div></div>
                <div class="stat-sub">{{ 100 - $pct }}% do quadro</div>
            </div>
        </div>

        <div class="metrics-grid">
            <div class="metric-card">
                <div class="metric-icon bg-blue-light"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                <div>
                    <div class="metric-value">{{ sprintf('%02d:%02d', (int)$totalHorasHoje, (int)round(($totalHorasHoje - (int)$totalHorasHoje) * 60)) }}</div>
                    <div class="metric-label">Total Horas Hoje</div>
                </div>
            </div>
            <div class="metric-card">
                <div class="metric-icon bg-green-light"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg></div>
                <div>
                    <div class="metric-value">{{ sprintf('%02d:%02d', (int)$mediaHorasSemana, (int)round(($mediaHorasSemana - (int)$mediaHorasSemana) * 60)) }}</div>
                    <div class="metric-label">Media Diaria (7d)</div>
                </div>
            </div>
            <div class="metric-card">
                <div class="metric-icon bg-purple-light"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20V10"/><path d="M18 20V4"/><path d="M6 20v-4"/></svg></div>
                <div>
                    <div class="metric-value text-success">{{ $maiorBanco ? explode(' ', $maiorBanco->nome)[0] : '—' }}</div>
                    <div class="metric-label">Maior Banco</div>
                </div>
            </div>
            <div class="metric-card">
                <div class="metric-icon bg-orange-light"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
                <div>
                    <div class="metric-value text-warning">{{ $maisFaltas ? explode(' ', $maisFaltas->nome)[0] : '—' }}</div>
                    <div class="metric-label">Mais Afastamentos</div>
                </div>
            </div>
        </div>

        <div class="charts-row">
            <div class="card"><div class="card-body">
                <div class="card-title-sm">Banco de Horas por Funcionario</div>
                <div class="chart-container"><canvas id="chart-banco"></canvas></div>
            </div></div>
            <div class="card"><div class="card-body" style="text-align:center">
                <div class="card-title-sm">Presenca Hoje</div>
                <div class="donut-wrap">
                    <canvas id="chart-presenca"></canvas>
                    <div class="donut-center">
                        <span class="donut-value">{{ $pct }}%</span>
                        <span class="donut-label">presentes</span>
                    </div>
                </div>
            </div></div>
        </div>

        <div class="card">
            <div class="card-header">
                <span class="card-title">Registros de Hoje</span>
                <span class="badge badge-success">{{ $registrosHoje->count() }} funcionarios</span>
            </div>
            <div class="table-responsive">
                <table class="tb">
                    <thead><tr><th>Funcionario</th><th class="tc">Entrada</th><th class="tc">S. Almoco</th><th class="tc">V. Almoco</th><th class="tc">Saida</th><th class="tc">Total</th><th class="tc">Status</th></tr></thead>
                    <tbody>
                        @forelse($registrosHoje as $r)
                        <tr>
                            <td><span class="fw-600">{{ $r->funcionario->nome }}</span></td>
                            <td class="tc">{{ $r->entrada?->format('H:i') ?? '—' }}</td>
                            <td class="tc">{{ $r->saida_almoco?->format('H:i') ?? '—' }}</td>
                            <td class="tc">{{ $r->volta_almoco?->format('H:i') ?? '—' }}</td>
                            <td class="tc">{{ $r->saida?->format('H:i') ?? '—' }}</td>
                            <td class="tc">@if($r->horasTrabalhadas() > 0)<span class="badge {{ $r->horasTrabalhadas() >= 8 ? 'badge-success' : 'badge-warning' }}">{{ $r->horasTrabalhadasFormatado() }}</span>@else—@endif</td>
                            <td class="tc"><span class="badge {{ $r->saida ? 'badge-success' : 'badge-info' }}">{{ $r->saida ? 'Concluido' : 'Andamento' }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Nenhum registro hoje.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($semPontoHoje->count())
        <div class="card card-danger-border">
            <div class="card-header card-header-danger">
                <span class="card-title text-danger">Sem Registro Hoje</span>
                <span class="badge badge-danger">{{ $semPontoHoje->count() }} funcionarios</span>
            </div>
            <div class="ausentes-grid">
                @foreach($semPontoHoje as $f)
                <div class="ausente-item">
                    <div class="func-cell">
                        <div class="func-avatar" style="background:{{ ['#2563eb','#059669','#d97706','#dc2626','#0891b2','#7c3aed'][$f->id % 6] }}">{{ strtoupper(substr($f->nome, 0, 1)) }}</div>
                        <div>
                            <span class="fw-600">{{ $f->nome }}</span>
                            <span class="text-muted text-sm" style="display:block">{{ $f->cargo }}</span>
                        </div>
                    </div>
                    <a href="{{ route('funcionarios.show', $f) }}" class="btn-sm">Ver</a>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </main>

    <script>
        var chartBancoLabels = {!! json_encode($chartBancoLabels) !!};
        var chartBancoData = {!! json_encode($chartBancoData) !!};
        var chartPresentes = {{ $chartPresentes }};
        var chartAusentes = {{ $chartAusentes }};
    </script>
    <script src="/js/charts-gestor.js"></script>
    <script>
        var meses = ['janeiro','fevereiro','marco','abril','maio','junho','julho','agosto','setembro','outubro','novembro','dezembro'];
        var dias = ['Domingo','Segunda-feira','Terca-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado'];
        var d = new Date();
        document.getElementById('page-date').textContent = dias[d.getDay()] + ', ' + d.getDate() + ' de ' + meses[d.getMonth()] + ' de ' + d.getFullYear();
    </script>
    <script src="/js/dark.js"></script>
</body>
</html>