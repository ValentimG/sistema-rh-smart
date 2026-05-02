<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8"><link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Controle de Ponto — SMART RH</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root{--primary:#2563eb;--success:#10b981;--danger:#ef4444;--warning:#f59e0b;--gray-50:#f8fafc;--gray-100:#f1f5f9;--gray-200:#e2e8f0;--gray-400:#94a3b8;--gray-600:#475569;--gray-800:#1e293b;--gray-900:#0f172a}
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Inter',sans-serif;background:linear-gradient(135deg,#eff6ff 0%,#f8fafc 50%,#fef3c7 100%);color:var(--gray-900);min-height:100vh}
        .hd{background:rgba(255,255,255,.9);backdrop-filter:blur(20px);border-bottom:1px solid rgba(0,0,0,.05);padding:0 40px;height:64px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:100}
        .logo{display:flex;align-items:center;gap:10px}
        .logo-ic{width:36px;height:36px;background:linear-gradient(135deg,var(--primary),#6366f1);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:900;font-size:.75rem;box-shadow:0 4px 12px rgba(37,99,235,.3)}
        .logo-n{font-size:.9rem;font-weight:800;color:var(--gray-900)}
        .logo-s{font-size:.55rem;color:var(--gray-400);font-weight:500}
        .hd-r{display:flex;align-items:center;gap:12px}
        .nav{display:flex;gap:3px}
        .nl{display:flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;color:var(--gray-600);text-decoration:none;font-size:.8rem;font-weight:500;transition:all .2s}
        .nl:hover,.nl.on{background:rgba(37,99,235,.08);color:var(--primary)}
        .av{width:34px;height:34px;background:linear-gradient(135deg,var(--primary),#6366f1);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.78rem}
        .lg-btn{display:flex;align-items:center;gap:5px;padding:7px 12px;border-radius:7px;color:var(--gray-400);font-size:.8rem;font-weight:500;background:none;border:none;cursor:pointer}
        .lg-btn:hover{background:var(--gray-100);color:var(--gray-800)}
        .pg{max-width:720px;margin:0 auto;padding:40px 24px}
        .clock-section{text-align:center;padding:32px 0 40px}
        .clock-time{font-size:4.5rem;font-weight:800;background:linear-gradient(135deg,var(--primary),#6366f1);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;line-height:1;letter-spacing:4px}
        .clock-date{font-size:.9rem;color:var(--gray-400);font-weight:500;margin-top:8px}
        .journey-done{background:linear-gradient(135deg,rgba(16,185,129,.1),rgba(16,185,129,.05));border:1px solid rgba(16,185,129,.2);border-radius:16px;padding:16px 24px;margin-bottom:28px;display:flex;align-items:center;gap:14px;animation:fadeInUp .5s ease-out}
        .journey-done svg{width:22px;height:22px;stroke:var(--success);fill:none;stroke-width:2.5;flex-shrink:0}
        .journey-done-title{font-size:.9rem;font-weight:700;color:#065f46}
        .journey-done-sub{font-size:.8rem;color:var(--success);margin-top:3px;font-weight:500}
        .timeline{display:grid;grid-template-columns:repeat(4,1fr);gap:3px;background:rgba(255,255,255,.5);backdrop-filter:blur(12px);border:1px solid rgba(0,0,0,.04);border-radius:16px;overflow:hidden;margin-bottom:32px}
        .tl-item{background:#fff;padding:20px 12px;text-align:center;transition:all .3s}
        .tl-done{background:linear-gradient(180deg,rgba(16,185,129,.06),rgba(16,185,129,.02))}
        .tl-dot{width:10px;height:10px;border-radius:50%;margin:0 auto 10px;background:var(--gray-200);transition:all .3s}
        .tl-done .tl-dot{background:var(--success);box-shadow:0 0 0 4px rgba(16,185,129,.15)}
        .tl-label{font-size:.6rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--gray-400);margin-bottom:6px}
        .tl-time{font-size:1.3rem;font-weight:700;color:var(--gray-200);font-variant-numeric:tabular-nums}
        .tl-done .tl-time{color:var(--gray-800)}
        .actions-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:14px;margin-bottom:32px}
        .btn-action{background:#fff;border:1.5px solid var(--gray-200);border-radius:16px;padding:24px 20px;cursor:pointer;display:flex;align-items:center;gap:16px;transition:all .3s;text-align:left;width:100%;font-family:inherit;box-shadow:0 1px 3px rgba(0,0,0,.04)}
        .btn-action:hover:not(:disabled){transform:translateY(-3px);box-shadow:0 8px 30px rgba(37,99,235,.12);border-color:var(--primary)}
        .btn-action-disabled{opacity:.35;cursor:not-allowed;pointer-events:none}
        .btn-action-done{background:linear-gradient(135deg,rgba(16,185,129,.04),rgba(16,185,129,.01));border-color:rgba(16,185,129,.15);cursor:default}
        .btn-action-icon{width:48px;height:48px;border-radius:14px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .btn-action-icon svg{width:20px;height:20px;stroke:currentColor;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}
        .btn-action-title{font-size:.9rem;font-weight:700;color:var(--gray-900);margin-bottom:2px}
        .btn-action-sub{font-size:.74rem;color:var(--gray-400)}
        .bg-green{background:linear-gradient(135deg,#10b981,#34d399);color:#fff;box-shadow:0 4px 14px rgba(16,185,129,.3)}
        .bg-orange{background:linear-gradient(135deg,#f59e0b,#fbbf24);color:#fff;box-shadow:0 4px 14px rgba(245,158,11,.3)}
        .bg-blue{background:linear-gradient(135deg,#2563eb,#6366f1);color:#fff;box-shadow:0 4px 14px rgba(37,99,235,.3)}
        .bg-red{background:linear-gradient(135deg,#ef4444,#f87171);color:#fff;box-shadow:0 4px 14px rgba(239,68,68,.3)}
        .bg-green-light{background:linear-gradient(135deg,#d1fae5,#a7f3d0);color:#059669}
        .bg-gray{background:var(--gray-100);color:var(--gray-400)}
        .card{background:#fff;border:1px solid var(--gray-200);border-radius:16px;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.04);margin-bottom:20px}
        .card-body{padding:24px}
        .card-subtitle{font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:1.2px;color:var(--gray-400);margin-bottom:16px}
        .card-center{text-align:center}
        .section-title{font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:1.2px;color:var(--gray-400);margin-bottom:16px}
        .charts-row{display:grid;grid-template-columns:1fr 180px;gap:14px;margin-bottom:32px}
        .chart-container{position:relative;height:190px}
        .banco-valor{font-size:2.5rem;font-weight:800;font-variant-numeric:tabular-nums;line-height:1;margin-bottom:6px}
        .banco-status{font-size:.72rem;color:var(--gray-400);margin-bottom:12px}
        .banco-hoje{font-size:.78rem;color:var(--gray-600);border-top:1px solid var(--gray-100);padding-top:12px;margin-top:8px}
        .tb{width:100%;border-collapse:collapse}
        .tb thead th{padding:12px 16px;text-align:left;font-size:.6rem;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:var(--gray-400);background:var(--gray-50);border-bottom:1px solid var(--gray-100);white-space:nowrap}
        .tb tbody tr{transition:all .2s}
        .tb tbody tr:nth-child(even){background:var(--gray-50)}
        .tb tbody tr:hover{background:rgba(37,99,235,.03)}
        .tb tbody td{padding:14px 16px;font-size:.82rem;color:var(--gray-800);border-bottom:1px solid var(--gray-100)}
        .tb tbody tr:last-child td{border-bottom:none}
        .table-responsive{overflow-x:auto}
        .badge{display:inline-flex;padding:4px 10px;border-radius:999px;font-size:.68rem;font-weight:700}
        .badge-success{background:#d1fae5;color:#065f46}
        .badge-warning{background:#fef3c7;color:#92400e}
        #toast-root{position:fixed;top:20px;right:20px;z-index:9999;display:flex;flex-direction:column;gap:10px}
        .toast{padding:14px 20px;border-radius:12px;font-size:.84rem;font-weight:600;color:#fff;box-shadow:0 8px 28px rgba(0,0,0,.2);max-width:320px;animation:slideInRight .4s ease-out}
        .toast-success{background:linear-gradient(135deg,#10b981,#34d399)}
        .toast-error{background:linear-gradient(135deg,#ef4444,#f87171)}
        .text-success{color:var(--success)}.text-danger{color:var(--danger)}.text-muted{color:var(--gray-400)}
        .text-center{text-align:center}.text-sm{font-size:.72rem}.fw-600{font-weight:600}
        .tc{text-align:center;font-variant-numeric:tabular-nums}.tr{text-align:right;padding-right:20px}.py-4{padding:28px 0}
        @keyframes fadeInUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
        @keyframes slideInRight{from{opacity:0;transform:translateX(100px)}to{opacity:1;transform:translateX(0)}}
        .theme-toggle{width:38px;height:38px;border-radius:10px;border:1.5px solid var(--gray-200);background:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:1rem;transition:all .3s}
        .theme-toggle:hover{border-color:var(--primary)}
        body.dark{background:linear-gradient(135deg,#0f172a 0%,#1e293b 50%,#0f172a 100%);color:#e2e8f0}
        body.dark .hd{background:rgba(15,23,42,.9);border-bottom-color:rgba(255,255,255,.05)}
        body.dark .logo-n{color:#f1f5f9}
        body.dark .nl{color:#94a3b8}
        body.dark .nl:hover,body.dark .nl.on{background:rgba(37,99,235,.15);color:#60a5fa}
        body.dark .card{background:rgba(30,41,59,.8);border-color:rgba(255,255,255,.05)}
        body.dark .btn-action{background:rgba(30,41,59,.8);border-color:rgba(255,255,255,.06)}
        body.dark .btn-action:hover:not(:disabled){border-color:#60a5fa;box-shadow:0 8px 30px rgba(37,99,235,.2)}
        body.dark .btn-action-title{color:#f1f5f9}
        body.dark .btn-action-sub{color:#94a3b8}
        body.dark .btn-action-disabled{opacity:.25}
        body.dark .btn-action-done{background:rgba(16,185,129,.1);border-color:rgba(16,185,129,.2)}
        body.dark .btn-action-done .btn-action-title{color:#34d399}
        body.dark .btn-action-done .btn-action-sub{color:#10b981}
        body.dark .tl-item{background:rgba(30,41,59,.6)}
        body.dark .tl-done{background:rgba(16,185,129,.08)}
        body.dark .tl-dot{background:rgba(255,255,255,.1)}
        body.dark .tl-done .tl-dot{background:var(--success);box-shadow:0 0 0 4px rgba(16,185,129,.2)}
        body.dark .tl-label{color:#64748b}
        body.dark .tl-time{color:#475569}
        body.dark .tl-done .tl-time{color:#e2e8f0}
        body.dark .tb thead th{background:rgba(15,23,42,.6);color:#64748b;border-bottom-color:rgba(255,255,255,.04)}
        body.dark .tb tbody tr:nth-child(even){background:rgba(30,41,59,.3)}
        body.dark .tb tbody tr:hover{background:rgba(37,99,235,.08)}
        body.dark .tb tbody td{color:#cbd5e1;border-bottom-color:rgba(255,255,255,.04)}
        body.dark .section-title,body.dark .card-subtitle{color:#64748b}
        body.dark .banco-status{color:#64748b}
        body.dark .banco-hoje{color:#94a3b8;border-top-color:rgba(255,255,255,.06)}
        body.dark .lg-btn{color:#64748b}
        body.dark .lg-btn:hover{background:rgba(255,255,255,.05);color:#94a3b8}
        body.dark .theme-toggle{background:#1e293b;border-color:#334155}
        body.dark .journey-done{background:rgba(16,185,129,.1);border-color:rgba(16,185,129,.15)}
        body.dark .journey-done-title{color:#34d399}
        body.dark .journey-done-sub{color:#10b981}
        body.dark .clock-time{background:linear-gradient(135deg,#60a5fa,#818cf8);-webkit-background-clip:text;background-clip:text}
    </style>
</head>
<body>
    @include('layouts.header')
    <main class="pg">
        <div class="clock-section"><div class="clock-time" id="clock">--:--:--</div><div class="clock-date" id="clock-date"></div></div>

        @if($hoje->saida)
        <div class="journey-done"><svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg><div><div class="journey-done-title">Jornada encerrada</div><div class="journey-done-sub">Total: {{ $hoje->horasTrabalhadasFormatado() }}</div></div></div>
        @endif

        <div class="timeline">
            <div class="tl-item {{ $hoje->entrada?'tl-done':'' }}"><div class="tl-dot"></div><div class="tl-label">Entrada</div><div class="tl-time">{{ $hoje->entrada?->format('H:i')??'--:--' }}</div></div>
            <div class="tl-item {{ $hoje->saida_almoco?'tl-done':'' }}"><div class="tl-dot"></div><div class="tl-label">Saida Almoco</div><div class="tl-time">{{ $hoje->saida_almoco?->format('H:i')??'--:--' }}</div></div>
            <div class="tl-item {{ $hoje->volta_almoco?'tl-done':'' }}"><div class="tl-dot"></div><div class="tl-label">Volta Almoco</div><div class="tl-time">{{ $hoje->volta_almoco?->format('H:i')??'--:--' }}</div></div>
            <div class="tl-item {{ $hoje->saida?'tl-done':'' }}"><div class="tl-dot"></div><div class="tl-label">Saida</div><div class="tl-time">{{ $hoje->saida?->format('H:i')??'--:--' }}</div></div>
        </div>

        @unless($hoje->saida)
        <div class="actions-grid">
            @include('registros.partials.btn-entrada')
            @include('registros.partials.btn-saida-almoco')
            @include('registros.partials.btn-volta-almoco')
            @include('registros.partials.btn-saida')
        </div>
        @endunless

        <div class="section-title">Resumo da Semana</div>
        <div class="charts-row">
            <div class="card"><div class="card-body"><div class="card-subtitle">Horas Trabalhadas — Ultimos 7 Dias</div><div class="chart-container"><canvas id="chart-dias"></canvas></div></div></div>
            <div class="card card-center"><div class="card-body"><div class="card-subtitle">Banco de Horas</div><div class="banco-valor {{ $bancoHoras>=0?'text-success':'text-danger' }}">{{ ($bancoHoras>=0?'+':'').number_format($bancoHoras,1,',','.') }}h</div><div class="banco-status">{{ $bancoHoras>=0?'Banco em dia':'Banco negativo' }}</div>@if($hoje->saida)<div class="banco-hoje">{{ $hoje->horasTrabalhadasFormatado() }} hoje</div>@endif</div></div>
        </div>

        <div class="section-title">Historico — Ultimos 7 Dias</div>
        <div class="card"><div class="table-responsive"><table class="tb"><thead><tr><th>Data</th><th class="tc">Entrada</th><th class="tc">Saida Almoco</th><th class="tc">Volta Almoco</th><th class="tc">Saida</th><th class="tr">Total</th></tr></thead><tbody>@forelse($historico as $r)<tr><td><span class="fw-600">{{ $r->data->format('d/m/Y') }}</span><span class="text-muted text-sm">{{ ['Domingo','Segunda','Terca','Quarta','Quinta','Sexta','Sabado'][$r->data->dayOfWeek] }}</span></td><td class="tc">{{ $r->entrada?->format('H:i')??'—' }}</td><td class="tc">{{ $r->saida_almoco?->format('H:i')??'—' }}</td><td class="tc">{{ $r->volta_almoco?->format('H:i')??'—' }}</td><td class="tc">{{ $r->saida?->format('H:i')??'—' }}</td><td class="tr">@if($r->horasTrabalhadas()>0)@php $h=(int)$r->horasTrabalhadas();$m=(int)round(($r->horasTrabalhadas()-$h)*60);@endphp<span class="badge {{ $r->horasTrabalhadas()>=8?'badge-success':'badge-warning' }}">{{ $h }}h{{ $m>0?" {$m}min":'' }}</span>@else<span class="text-muted">—</span>@endif</td></tr>@empty<tr><td colspan="6" class="text-center text-muted py-4">Nenhum registro nos ultimos 7 dias.</td></tr>@endforelse</tbody></table></div></div>
    </main>
    <div id="toast-root"></div>
    <script src="/js/ponto.js"></script>
    <script>const chartData={labels:{!! json_encode($chartDias) !!},data:{!! json_encode($chartHoras) !!}};</script>
    <script src="/js/charts.js"></script>
    <script src="/js/dark.js"></script>
</body>
</html>
