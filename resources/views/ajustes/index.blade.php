<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ajustes de Ponto — SMART RH</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <style>
        .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
        .page-title { font-size: 1.3rem; font-weight: 800; color: var(--gray-900); }
        .page-sub { font-size: .8rem; color: var(--gray-400); margin-top: 4px; }
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 24px; }
        .stat-card { background: #fff; border: 1px solid var(--gray-200); border-radius: 16px; padding: 20px 24px; text-align: center; transition: all .3s; box-shadow: 0 1px 3px rgba(0,0,0,.04); }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(37,99,235,.06); }
        .stat-value { font-size: 2rem; font-weight: 800; line-height: 1; margin-bottom: 6px; }
        .stat-label { font-size: .7rem; color: var(--gray-400); text-transform: uppercase; letter-spacing: .8px; font-weight: 600; }
        .tb tbody td { vertical-align: middle; }
        .status-badge { display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 999px; font-size: .74rem; font-weight: 600; }
        .status-pendente { background: #fef3c7; color: #92400e; }
        .status-aprovado { background: #d1fae5; color: #065f46; }
        .status-reprovado { background: #fee2e2; color: #991b1b; }
        .status-dot { width: 6px; height: 6px; border-radius: 50%; }
        .status-pendente .status-dot { background: #f59e0b; }
        .status-aprovado .status-dot { background: #10b981; }
        .status-reprovado .status-dot { background: #ef4444; }
        .empty-state { text-align: center; padding: 48px 20px; }
        .empty-state svg { width: 56px; height: 56px; stroke: var(--gray-200); margin-bottom: 16px; }
        .empty-state p { color: var(--gray-400); font-size: .85rem; }
        .btn-sm { padding: 5px 14px; font-size: .72rem; border-radius: 8px; border: 1px solid var(--gray-200); background: #fff; color: var(--gray-600); cursor: pointer; transition: all .2s; font-weight: 600; }
        .btn-sm:hover { border-color: var(--primary); color: var(--primary); }
        .btn-sm-success:hover { border-color: var(--success); color: var(--success); }
        .btn-sm-danger:hover { border-color: var(--danger); color: var(--danger); }
        body.dark .stat-card { background: rgba(30,41,59,.8); border-color: rgba(255,255,255,.05); }
        body.dark .stat-label { color: #64748b; }
        body.dark .page-title { color: #f1f5f9; }
        body.dark .btn-sm { background: #1e293b; border-color: #334155; color: #94a3b8; }
        body.dark .empty-state svg { stroke: #334155; }
    </style>
</head>
<body>
    @include('layouts.header')
    <main class="pg">
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

        <div class="page-header">
            <div>
                <h1 class="page-title">Ajustes de Ponto</h1>
                <p class="page-sub">{{ $isGestor ? 'Gerencie as solicitacoes de ajuste' : 'Suas solicitacoes de ajuste' }}</p>
            </div>
            @if(!$isGestor)
            <a href="{{ route('ajustes.create') }}" class="btn btn-primary">+ Nova Solicitacao</a>
            @endif
        </div>

        <div class="stats-grid">
            <div class="stat-card"><div class="stat-value" style="color:var(--primary)">{{ $ajustes->total() }}</div><div class="stat-label">Total</div></div>
            <div class="stat-card"><div class="stat-value" style="color:#f59e0b">{{ $ajustes->where('status','pendente')->count() }}</div><div class="stat-label">Pendentes</div></div>
            <div class="stat-card"><div class="stat-value" style="color:var(--success)">{{ $ajustes->where('status','aprovado')->count() }}</div><div class="stat-label">Aprovados</div></div>
        </div>

        <div class="card">
            <div class="table-responsive">
                <table class="tb">
                    <thead><tr>
                        @if($isGestor)<th>Funcionario</th>@endif
                        <th>Data</th><th>Tipo</th><th>Horario</th><th>Motivo</th><th class="text-center">Status</th><th class="text-center">Acoes</th>
                    </tr></thead>
                    <tbody>
                        @forelse($ajustes as $a)
                        <tr>
                            @if($isGestor)<td><span class="fw-600">{{ $a->funcionario->nome }}</span></td>@endif
                            <td class="fw-600">{{ $a->data->format('d/m/Y') }}</td>
                            <td>{{ ucfirst(str_replace('_',' ',$a->tipo)) }}</td>
                            <td class="fw-600">{{ \Carbon\Carbon::parse($a->horario_solicitado)->format('H:i') }}</td>
                            <td class="text-muted text-sm">{{ Str::limit($a->motivo, 50) }}</td>
                            <td class="text-center">
                                <span class="status-badge status-{{ $a->status }}">
                                    <span class="status-dot"></span> {{ $a->statusLabel() }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($isGestor && $a->status == 'pendente')
                                <form method="POST" action="{{ route('ajustes.aprovar', $a) }}" style="display:inline">@csrf<button class="btn-sm btn-sm-success">Aprovar</button></form>
                                <form method="POST" action="{{ route('ajustes.reprovar', $a) }}" style="display:inline">@csrf<button class="btn-sm btn-sm-danger">Reprovar</button></form>
                                @else
                                <span class="text-muted text-sm">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="{{ $isGestor?7:6 }}">
                            <div class="empty-state">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                <p>Nenhuma solicitacao de ajuste encontrada.</p>
                            </div>
                        </td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <script src="/js/dark.js"></script>
</body>
</html>