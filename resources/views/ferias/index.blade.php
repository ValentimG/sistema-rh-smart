<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8"><link rel="icon" href="/favicon.svg" type="image/svg+xml"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ferias — SMART RH</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/ferias.css">
</head>
<body>
    @include('layouts.header')
    <main class="pg">
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert alert-error">{{ session('error') }}</div> @endif

        <div class="page-header">
            <div>
                <h1 class="page-title">Ferias</h1>
                <p class="page-sub">{{ $isGestor ? 'Gerencie as solicitacoes da equipe' : 'Suas solicitacoes de ferias' }}</p>
            </div>
            @if(!$isGestor)
            <a href="{{ route('ferias.create') }}" class="btn btn-primary btn-add">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Nova Solicitacao
            </a>
            @endif
        </div>

        <!-- Cards de resumo -->
        <div class="ferias-stats">
            <div class="ferias-stat">
                <div class="ferias-stat-value text-primary">{{ $ferias->total() }}</div>
                <div class="ferias-stat-label">Total</div>
            </div>
            <div class="ferias-stat">
                <div class="ferias-stat-value text-warning">{{ $ferias->where('status','pendente')->count() }}</div>
                <div class="ferias-stat-label">Pendentes</div>
            </div>
            <div class="ferias-stat">
                <div class="ferias-stat-value text-success">{{ $ferias->where('status','aprovado')->count() }}</div>
                <div class="ferias-stat-label">Aprovadas</div>
            </div>
            <div class="ferias-stat">
                <div class="ferias-stat-value text-danger">{{ $ferias->where('status','reprovado')->count() }}</div>
                <div class="ferias-stat-label">Reprovadas</div>
            </div>
        </div>

        <div class="card">
            <div class="table-responsive">
                <table class="tb">
                    <thead><tr>
                        @if($isGestor)<th>Funcionario</th>@endif
                        <th>Periodo</th>
                        <th class="text-center">Dias</th>
                        <th class="text-center">Status</th>
                        <th>Solicitado em</th>
                        <th class="text-center">Acoes</th>
                    </tr></thead>
                    <tbody>
                        @forelse($ferias as $f)
                        <tr>
                            @if($isGestor)
                            <td>
                                <div class="func-info">
                                    <div class="func-avatar" style="background:{{ ['#2563eb','#059669','#d97706','#dc2626','#0891b2','#7c3aed'][$f->funcionario->id % 6] }}">{{ strtoupper(substr($f->funcionario->nome,0,1)) }}</div>
                                    <div>
                                        <span class="fw-600">{{ $f->funcionario->nome }}</span>
                                        <span class="text-muted text-sm" style="display:block">{{ $f->funcionario->cargo }}</span>
                                    </div>
                                </div>
                            </td>
                            @endif
                            <td>
                                <div class="periodo-info">
                                    <span class="fw-600">{{ $f->data_inicio->format('d/m/Y') }}</span>
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--gray-400)"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                                    <span class="fw-600">{{ $f->data_fim->format('d/m/Y') }}</span>
                                </div>
                            </td>
                            <td class="text-center"><span class="dias-badge">{{ $f->dias }} dias</span></td>
                            <td class="text-center">
                                <span class="status-badge status-{{ $f->status }}">
                                    <span class="status-dot"></span>
                                    {{ $f->statusLabel() }}
                                </span>
                            </td>
                            <td class="text-muted text-sm">{{ $f->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-center">
                                <div class="action-btns">
                                    @if($isGestor && $f->status == 'pendente')
                                    <form method="POST" action="{{ route('ferias.aprovar', $f) }}" style="display:inline">@csrf<button class="btn-sm btn-sm-success">Aprovar</button></form>
                                    <form method="POST" action="{{ route('ferias.reprovar', $f) }}" style="display:inline">@csrf<button class="btn-sm btn-sm-danger">Reprovar</button></form>
                                    @endif
                                    @if($f->status == 'pendente' && !$isGestor)
                                    <form method="POST" action="{{ route('ferias.destroy', $f) }}" style="display:inline" onsubmit="return confirm('Cancelar esta solicitacao?')">@csrf @method('DELETE')<button class="btn-sm btn-sm-danger">Cancelar</button></form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="{{ $isGestor?6:5 }}">
                            <div class="empty-state">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><path d="M8 14h.01M12 14h.01M16 14h.01"/></svg>
                                <p>Nenhuma solicitacao de ferias encontrada.</p>
                                @if(!$isGestor)<a href="{{ route('ferias.create') }}" class="btn btn-primary" style="margin-top:12px">Solicitar Ferias</a>@endif
                            </div>
                        </td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($ferias->hasPages())
        <div class="pagination-wrap">{{ $ferias->links() }}</div>
        @endif
    </main>
    <script src="/js/dark.js"></script>
</body>
</html>
