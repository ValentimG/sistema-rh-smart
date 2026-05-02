<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Painel do Gestor — SMART RH</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root{--primary:#2563eb;--success:#10b981;--danger:#ef4444;--warning:#f59e0b;--info:#0891b2;--gray-50:#f8fafc;--gray-100:#f1f5f9;--gray-200:#e2e8f0;--gray-400:#94a3b8;--gray-600:#475569;--gray-800:#1e293b;--gray-900:#0f172a}
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Inter',sans-serif;background:linear-gradient(135deg,#eff6ff 0%,#f8fafc 50%,#fef3c7 100%);color:var(--gray-900);min-height:100vh}
        .hd{background:rgba(255,255,255,.9);backdrop-filter:blur(20px);border-bottom:1px solid rgba(0,0,0,.05);padding:0 40px;height:64px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:100}
        .logo{display:flex;align-items:center;gap:10px}
        .logo-ic{width:36px;height:36px;background:linear-gradient(135deg,var(--primary),#6366f1);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:900;font-size:.75rem;box-shadow:0 4px 12px rgba(37,99,235,.3)}
        .logo-n{font-size:.9rem;font-weight:800;color:var(--gray-900)}.logo-s{font-size:.55rem;color:var(--gray-400)}
        .hd-r{display:flex;align-items:center;gap:12px}.nav{display:flex;gap:3px}
        .nl{display:flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;color:var(--gray-600);text-decoration:none;font-size:.8rem;font-weight:500;transition:all .2s}
        .nl:hover,.nl.on{background:rgba(37,99,235,.08);color:var(--primary)}
        .av{width:34px;height:34px;background:linear-gradient(135deg,var(--primary),#6366f1);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.78rem}
        .lg-btn{display:flex;align-items:center;gap:5px;padding:7px 12px;border-radius:7px;color:var(--gray-400);font-size:.8rem;font-weight:500;background:none;border:none;cursor:pointer}.lg-btn:hover{background:var(--gray-100);color:var(--gray-800)}
        .pg{max-width:1100px;margin:0 auto;padding:40px 24px}
        .section-title{font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--gray-400);margin-bottom:16px}
        .stats-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:24px}
        .stat-card{background:#fff;border:1px solid var(--gray-200);border-radius:16px;padding:22px 24px;transition:all .3s;box-shadow:0 1px 3px rgba(0,0,0,.04)}
        .stat-card:hover{transform:translateY(-2px);box-shadow:0 8px 25px rgba(37,99,235,.08)}
        .stat-label{font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--gray-400);margin-bottom:8px}
        .stat-value{font-size:2.4rem;font-weight:800;line-height:1;margin-bottom:4px}
        .stat-sub{font-size:.72rem;color:var(--gray-400)}
        .text-primary{color:var(--primary)}.text-success{color:var(--success)}.text-danger{color:var(--danger)}
        .progress-bar{height:4px;border-radius:2px;background:var(--gray-100);margin-top:12px}
        .progress-fill{height:100%;border-radius:2px;transition:width .6s ease}
        .bg-green{background:var(--success)}.bg-red{background:var(--danger)}
        .metrics-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:24px}
        .metric-card{background:#fff;border:1px solid var(--gray-200);border-radius:16px;padding:18px 20px;transition:all .3s;box-shadow:0 1px 3px rgba(0,0,0,.04)}
        .metric-card:hover{transform:translateY(-2px)}
        .charts-row{display:grid;grid-template-columns:1fr 200px;gap:14px;margin-bottom:24px}
        .card{background:#fff;border:1px solid var(--gray-200);border-radius:16px;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.04)}
        .card-header{padding:16px 24px;border-bottom:1px solid var(--gray-100);display:flex;align-items:center;justify-content:space-between}
        .card-title{font-size:.85rem;font-weight:700;color:var(--gray-900)}
        .card-body{padding:24px}
        .card-subtitle{font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:1.2px;color:var(--gray-400);margin-bottom:16px}
        .card-center{text-align:center}
        .chart-container{position:relative;height:200px}
        .donut-wrap{position:relative;width:140px;height:140px;margin:0 auto}
        .donut-center{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center}
        .donut-value{font-size:1.8rem;font-weight:800;color:var(--success)}.donut-label{font-size:.6rem;color:var(--gray-400)}
        .tb{width:100%;border-collapse:collapse}
        .tb thead th{padding:12px 16px;text-align:left;font-size:.6rem;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:var(--gray-400);background:var(--gray-50);border-bottom:1px solid var(--gray-100);white-space:nowrap}
        .tb tbody tr{transition:all .2s}.tb tbody tr:nth-child(even){background:var(--gray-50)}
        .tb tbody tr:hover{background:rgba(37,99,235,.03)}
        .tb tbody td{padding:14px 16px;font-size:.82rem;color:var(--gray-800);border-bottom:1px solid var(--gray-100)}
        .badge{display:inline-flex;padding:4px 10px;border-radius:999px;font-size:.68rem;font-weight:700}
        .badge-success{background:#d1fae5;color:#065f46}.badge-warning{background:#fef3c7;color:#92400e}.badge-danger{background:#fee2e2;color:#991b1b}.badge-info{background:#dbeafe;color:#1e40af}
        .ausentes-item{display:flex;align-items:center;justify-content:space-between;padding:14px 24px;border-bottom:1px solid #fef2f2}
        .ausentes-item:last-child{border-bottom:none}.ausentes-item:hover{background:#fff5f5}
        .btn-link{color:var(--primary);font-size:.78rem;font-weight:600;text-decoration:none}.btn-link:hover{text-decoration:underline}
        .text-muted{color:var(--gray-400)}.text-center{text-align:center}.text-sm{font-size:.72rem}.fw-600{font-weight:600}.tc{text-align:center;font-variant-numeric:tabular-nums}
        .theme-toggle{width:38px;height:38px;border-radius:10px;border:1.5px solid var(--gray-200);background:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:1rem;transition:all .3s}
        .theme-toggle:hover{border-color:var(--primary)}
        body.dark{background:linear-gradient(135deg,#0f172a 0%,#1e293b 50%,#0f172a 100%);color:#e2e8f0}
        body.dark .hd{background:rgba(15,23,42,.9);border-bottom-color:rgba(255,255,255,.05)}
        body.dark .logo-n{color:#f1f5f9}
        body.dark .nl{color:#94a3b8}
        body.dark .nl:hover,body.dark .nl.on{background:rgba(37,99,235,.15);color:#60a5fa}
        body.dark .stat-card,body.dark .metric-card,body.dark .card{background:rgba(30,41,59,.8);border-color:rgba(255,255,255,.05)}
        body.dark .stat-label{color:#64748b}
        body.dark .tb thead th{background:rgba(15,23,42,.6);color:#64748b;border-bottom-color:rgba(255,255,255,.04)}
        body.dark .tb tbody tr:nth-child(even){background:rgba(30,41,59,.3)}
        body.dark .tb tbody td{color:#cbd5e1;border-bottom-color:rgba(255,255,255,.04)}
        body.dark .progress-bar{background:rgba(255,255,255,.06)}
        body.dark .ausentes-item{border-bottom-color:rgba(239,68,68,.1)}
        body.dark .ausentes-item:hover{background:rgba(239,68,68,.05)}
        body.dark .lg-btn{color:#64748b}
        body.dark .lg-btn:hover{background:rgba(255,255,255,.05);color:#94a3b8}
        body.dark .theme-toggle{background:#1e293b;border-color:#334155}
        body.dark .card-header{border-bottom-color:rgba(255,255,255,.04)}
        body.dark .card-subtitle{color:#64748b}
    </style>
</head>
<body>
    @include('layouts.header')
    <main class="pg">
        <div class="section-title">Visao Geral — Hoje</div>
        <div class="stats-grid">
            <div class="stat-card"><div class="stat-label">Total de Funcionarios</div><div class="stat-value text-primary">{{ $totalFuncionarios }}</div><div class="stat-sub">cadastrados no sistema</div></div>
            <div class="stat-card"><div class="stat-label">Presentes Hoje</div><div class="stat-value text-success">{{ $registrosHoje->count() }}</div><div class="stat-sub">{{ $totalFuncionarios>0?round($registrosHoje->count()/$totalFuncionarios*100):0 }}% do quadro</div><div class="progress-bar"><div class="progress-fill bg-green" style="width:{{ $totalFuncionarios>0?round($registrosHoje->count()/$totalFuncionarios*100):0 }}%"></div></div></div>
            <div class="stat-card"><div class="stat-label">Sem Registro Hoje</div><div class="stat-value text-danger">{{ $semPontoHoje->count() }}</div><div class="stat-sub">{{ $totalFuncionarios>0?round($semPontoHoje->count()/$totalFuncionarios*100):0 }}% do quadro</div><div class="progress-bar"><div class="progress-fill bg-red" style="width:{{ $totalFuncionarios>0?round($semPontoHoje->count()/$totalFuncionarios*100):0 }}%"></div></div></div>
        </div>
        <div class="metrics-grid">
            <div class="metric-card"><div class="stat-label">Total Horas Hoje</div><div class="stat-value text-primary" style="font-size:1.5rem">{{ sprintf('%02d:%02d',(int)$totalHorasHoje,(int)round(($totalHorasHoje-(int)$totalHorasHoje)*60)) }}</div></div>
            <div class="metric-card"><div class="stat-label">Media Diaria (7d)</div><div class="stat-value text-info" style="font-size:1.5rem">{{ sprintf('%02d:%02d',(int)$mediaHorasSemana,(int)round(($mediaHorasSemana-(int)$mediaHorasSemana)*60)) }}</div></div>
            <div class="metric-card"><div class="stat-label">Maior Banco</div><div class="stat-value text-success" style="font-size:1.2rem">{{ $maiorBanco?explode(' ',$maiorBanco->nome)[0]:'—' }}</div></div>
            <div class="metric-card"><div class="stat-label">Mais Afastamentos</div><div class="stat-value text-warning" style="font-size:1.2rem">{{ $maisFaltas?explode(' ',$maisFaltas->nome)[0]:'—' }}</div></div>
        </div>
        <div class="charts-row">
            <div class="card"><div class="card-body"><div class="card-subtitle">Banco de Horas por Funcionario</div><div class="chart-container"><canvas id="chart-banco"></canvas></div></div></div>
            <div class="card card-center"><div class="card-body"><div class="card-subtitle">Presenca Hoje</div><div class="donut-wrap"><canvas id="chart-presenca"></canvas><div class="donut-center"><span class="donut-value">{{ $totalFuncionarios>0?round($registrosHoje->count()/$totalFuncionarios*100):0 }}%</span><span class="donut-label">presentes</span></div></div></div></div>
        </div>
        <div class="card">
            <div class="card-header"><span class="card-title">Registros de Hoje</span><span class="badge badge-success">{{ $registrosHoje->count() }} func.</span></div>
            <div class="table-responsive"><table class="tb"><thead><tr><th>Funcionario</th><th class="tc">Entrada</th><th class="tc">Saida Almoco</th><th class="tc">Volta Almoco</th><th class="tc">Saida</th><th class="tc">Total</th><th class="tc">Status</th></tr></thead><tbody>@forelse($registrosHoje as $r)<tr><td><span class="fw-600">{{ $r->funcionario->nome }}</span><br><span class="text-muted text-sm">{{ $r->funcionario->cargo }}</span></td><td class="tc">{{ $r->entrada?->format('H:i')??'—' }}</td><td class="tc">{{ $r->saida_almoco?->format('H:i')??'—' }}</td><td class="tc">{{ $r->volta_almoco?->format('H:i')??'—' }}</td><td class="tc">{{ $r->saida?->format('H:i')??'—' }}</td><td class="tc">@if($r->horasTrabalhadas()>0)@php $h=(int)$r->horasTrabalhadas();$m=(int)round(($r->horasTrabalhadas()-$h)*60);@endphp<span class="badge {{ $r->horasTrabalhadas()>=8?'badge-success':'badge-warning' }}">{{ sprintf('%02d:%02d',$h,$m) }}</span>@else—@endif</td><td class="tc"><span class="badge {{ $r->saida?'badge-success':($r->entrada?'badge-info':'badge-warning') }}">{{ $r->saida?'Concluido':($r->entrada?'Andamento':'Pendente') }}</span></td></tr>@empty<tr><td colspan="7" class="text-center text-muted py-4">Nenhum registro hoje.</td></tr>@endforelse</tbody></table></div>
        </div>
        @if($semPontoHoje->count())
        <div class="card" style="border-color:#fecaca"><div class="card-header" style="background:#fff5f5"><span class="card-title" style="color:#991b1b">Sem Registro Hoje</span><span class="badge badge-danger">{{ $semPontoHoje->count() }} func.</span></div>@foreach($semPontoHoje as $f)<div class="ausentes-item"><div><span class="fw-600">{{ $f->nome }}</span><span class="text-muted text-sm" style="margin-left:8px">{{ $f->cargo }}</span></div><a href="{{ route('funcionarios.show',$f) }}" class="btn-link">Ver</a></div>@endforeach</div>
        @endif
    </main>
    <script>var chartBancoLabels={!! json_encode($chartBancoLabels) !!};var chartBancoData={!! json_encode($chartBancoData) !!};var chartPresentes={{ $chartPresentes }};var chartAusentes={{ $chartAusentes }};</script>
    <script src="/js/charts-gestor.js"></script>
    <script src="/js/dark.js"></script>
</body>
</html>