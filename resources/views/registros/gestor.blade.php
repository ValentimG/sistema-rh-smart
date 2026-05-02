<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Painel do Gestor — SMART RH</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    @include('layouts.header')

    <main class="pg">
        <div class="section-title">Visao Geral — Hoje</div>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total de Funcionarios</div>
                <div class="stat-value text-primary">{{ $totalFuncionarios }}</div>
                <div class="stat-sub">cadastrados no sistema</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Presentes Hoje</div>
                <div class="stat-value text-success">{{ $registrosHoje->count() }}</div>
                <div class="stat-sub">{{ $totalFuncionarios > 0 ? round($registrosHoje->count() / $totalFuncionarios * 100) : 0 }}% do quadro</div>
                <div class="progress-bar"><div class="progress-fill bg-green" style="width:{{ $totalFuncionarios > 0 ? round($registrosHoje->count() / $totalFuncionarios * 100) : 0 }}%"></div></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Sem Registro Hoje</div>
                <div class="stat-value text-danger">{{ $semPontoHoje->count() }}</div>
                <div class="stat-sub">{{ $totalFuncionarios > 0 ? round($semPontoHoje->count() / $totalFuncionarios * 100) : 0 }}% do quadro</div>
                <div class="progress-bar"><div class="progress-fill bg-red" style="width:{{ $totalFuncionarios > 0 ? round($semPontoHoje->count() / $totalFuncionarios * 100) : 0 }}%"></div></div>
            </div>
        </div>

        <div class="metrics-grid">
            <div class="metric-card">
                <div class="stat-label">Total de Horas Hoje</div>
                <div class="stat-value text-primary" style="font-size:1.6rem">{{ sprintf('%02d:%02d', (int)$totalHorasHoje, (int)round(($totalHorasHoje - (int)$totalHorasHoje) * 60)) }}</div>
                <div class="stat-sub">soma de todos os registros</div>
            </div>
            <div class="metric-card">
                <div class="stat-label">Media Diaria (7 dias)</div>
                <div class="stat-value text-info" style="font-size:1.6rem">{{ sprintf('%02d:%02d', (int)$mediaHorasSemana, (int)round(($mediaHorasSemana - (int)$mediaHorasSemana) * 60)) }}</div>
                <div class="stat-sub">por funcionario/dia</div>
            </div>
            <div class="metric-card">
                <div class="stat-label">Maior Banco de Horas</div>
                <div class="stat-value text-success" style="font-size:1.2rem">{{ $maiorBanco ? explode(' ', $maiorBanco->nome)[0] : '—' }}</div>
                <div class="stat-sub">{{ $maiorBanco ? '+' . number_format($maiorBanco->banco_horas, 1, ',', '.') . 'h' : '' }}</div>
            </div>
            <div class="metric-card">
                <div class="stat-label">Mais Afastamentos</div>
                <div class="stat-value text-warning" style="font-size:1.2rem">{{ $maisFaltas ? explode(' ', $maisFaltas->nome)[0] : '—' }}</div>
                <div class="stat-sub">{{ $maisFaltas ? $maisFaltas->diasTotaisAfastamento() . 'd' : 'Nenhum' }}</div>
            </div>
        </div>

        <div class="charts-row">
            <div class="card">
                <div class="card-body">
                    <div class="card-subtitle">Banco de Horas por Funcionario</div>
                    <div class="chart-container"><canvas id="chart-banco"></canvas></div>
                </div>
            </div>
            <div class="card card-center">
                <div class="card-body">
                    <div class="card-subtitle">Presenca Hoje</div>
                    <div class="donut-wrap">
                        <canvas id="chart-presenca"></canvas>
                        <div class="donut-center">
                            <span class="donut-value">{{ $totalFuncionarios > 0 ? round($registrosHoje->count() / $totalFuncionarios * 100) : 0 }}%</span>
                            <span class="donut-label">presentes</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <span class="card-title">Registros de Hoje</span>
                <span class="badge badge-success">{{ $registrosHoje->count() }} funcionarios</span>
            </div>
            <div class="table-responsive">
                <table class="tb">
                    <thead><tr>
                        <th>Funcionario</th><th class="tc">Entrada</th><th class="tc">Saida Almoco</th><th class="tc">Volta Almoco</th><th class="tc">Saida</th><th class="tc">Total</th><th class="tc">Status</th><th></th>
                    </tr></thead>
                    <tbody>
                        @forelse($registrosHoje as $r)
                        <tr>
                            <td><div class="fw-600">{{ $r->funcionario->nome }}</div><div class="text-muted text-sm">{{ $r->funcionario->cargo }}</div></td>
                            <td class="tc">{{ $r->entrada?->format('H:i') ?? '—' }}</td>
                            <td class="tc">{{ $r->saida_almoco?->format('H:i') ?? '—' }}</td>
                            <td class="tc">{{ $r->volta_almoco?->format('H:i') ?? '—' }}</td>
                            <td class="tc">{{ $r->saida?->format('H:i') ?? '—' }}</td>
                            <td class="tc">
                                @if($r->horasTrabalhadas() > 0)
                                    @php $h=(int)$r->horasTrabalhadas(); $m=(int)round(($r->horasTrabalhadas()-$h)*60); @endphp
                                    <span class="badge {{ $r->horasTrabalhadas()>=8?'badge-success':'badge-warning' }}">{{ sprintf('%02d:%02d',$h,$m) }}</span>
                                @else<span class="text-muted">—</span>@endif
                            </td>
                            <td class="tc"><span class="badge {{ $r->saida?'badge-success':($r->entrada?'badge-info':'badge-warning') }}">{{ $r->saida?'Concluido':($r->entrada?'Andamento':'Pendente') }}</span></td>
                            <td class="tr"><a href="{{ route('funcionarios.show', $r->funcionario) }}" class="btn-link">Ver</a></td>
                        </tr>
                        @empty
                        <tr><td colspan="8" class="text-center text-muted py-4">Nenhum registro hoje.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($semPontoHoje->count())
        <div class="card" style="border-color:#fecaca">
            <div class="card-header" style="background:#fff5f5">
                <span class="card-title" style="color:#991b1b">Sem Registro Hoje</span>
                <span class="badge badge-danger">{{ $semPontoHoje->count() }} funcionarios</span>
            </div>
            <div class="ausentes-list">
                @foreach($semPontoHoje as $f)
                <div class="ausentes-item">
                    <div><span class="fw-600">{{ $f->nome }}</span><span class="text-muted text-sm ml-2">{{ $f->cargo }}</span></div>
                    <a href="{{ route('funcionarios.show', $f) }}" class="btn-link">Ver</a>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </main>

    <script src="/js/charts-gestor.js"></script>
    <script src="/js/dark.js"></script>
</body>
</html>