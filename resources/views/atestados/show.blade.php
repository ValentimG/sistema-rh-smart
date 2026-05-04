<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Atestado — SMART RH</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/atestados.css">
</head>
<body>
    @include('layouts.header')
    <main class="pg pg-sm">
        <a href="{{ route('atestados.index') }}" class="back-link">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            Voltar
        </a>

        <div class="atestado-hero status-{{ $atestado->status }}">
            <div class="atestado-hero-badge">
                <span class="status-dot"></span>
                {{ $atestado->statusLabel() }}
            </div>
            <h1 class="atestado-hero-title">Atestado {{ $atestado->tipoLabel() }}</h1>
            <p class="atestado-hero-periodo">{{ $atestado->data_inicio->format('d/m/Y') }} → {{ $atestado->data_fim->format('d/m/Y') }} · {{ $atestado->dias_afastamento }} dia(s)</p>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="detail-grid">
                    <div class="detail-col">
                        <h3 class="detail-title">Funcionario</h3>
                        <div class="detail-avatar" style="background:{{ ['#2563eb','#059669','#d97706','#dc2626','#0891b2','#7c3aed'][$atestado->funcionario->id % 6] }}">
                            {{ strtoupper(substr($atestado->funcionario->nome, 0, 1)) }}
                        </div>
                        <p class="detail-name">{{ $atestado->funcionario->nome }}</p>
                        <p class="detail-cargo">{{ $atestado->funcionario->cargo }}</p>
                        <p class="detail-email">{{ $atestado->funcionario->email }}</p>
                    </div>
                    <div class="detail-col">
                        <h3 class="detail-title">Informacoes</h3>
                        <dl class="detail-list">
                            <div class="detail-row"><dt>Tipo</dt><dd>{{ $atestado->tipoLabel() }}</dd></div>
                            <div class="detail-row"><dt>Inicio</dt><dd>{{ $atestado->data_inicio->format('d/m/Y') }}</dd></div>
                            <div class="detail-row"><dt>Fim</dt><dd>{{ $atestado->data_fim->format('d/m/Y') }}</dd></div>
                            <div class="detail-row"><dt>Dias</dt><dd>{{ $atestado->dias_afastamento }} dia(s)</dd></div>
                            <div class="detail-row"><dt>Cobre Horas</dt><dd><span class="badge {{ $atestado->cobre_horas ? 'badge-success' : 'badge-warning' }}">{{ $atestado->cobre_horas ? 'Sim' : 'Nao' }}</span></dd></div>
                            <div class="detail-row"><dt>Enviado em</dt><dd>{{ $atestado->created_at->format('d/m/Y H:i') }}</dd></div>
                            @if($atestado->observacao)
                            <div class="detail-row detail-row-full"><dt>Observacao</dt><dd>{{ $atestado->observacao }}</dd></div>
                            @endif
                        </dl>
                    </div>
                </div>

                @if($atestado->arquivo_path)
                <div class="attachment-box">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    <span>Arquivo anexado</span>
                    <a href="{{ asset('storage/' . $atestado->arquivo_path) }}" target="_blank" class="btn btn-secondary btn-sm">Download</a>
                </div>
                @endif
            </div>
        </div>

        @if($atual->isGestor() && $atestado->status === 'pendente')
        <div class="action-bar">
            <form method="POST" action="{{ route('atestados.aprovar', $atestado) }}">@csrf<button class="btn btn-success btn-lg">Aprovar Atestado</button></form>
            <form method="POST" action="{{ route('atestados.reprovar', $atestado) }}">@csrf<button class="btn btn-danger btn-lg">Reprovar</button></form>
        </div>
        @endif
    </main>
    <script src="/js/dark.js"></script>
</body>
</html>