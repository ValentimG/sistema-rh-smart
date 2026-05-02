<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Solicitar Ferias — SMART RH</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/ferias.css">
    <style>
        .max-w-500 { max-width: 520px; }
        .form-group { margin-bottom: 18px; }
        .form-label { display: block; font-size: .78rem; font-weight: 600; color: var(--gray-800); margin-bottom: 5px; }
        .form-input { width: 100%; padding: 12px 16px; border: 1.5px solid var(--gray-200); border-radius: 12px; font-size: .87rem; outline: none; transition: all .2s; background: #fff; }
        .form-input:focus { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(37,99,235,.06); }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .dias-preview { text-align: center; padding: 16px; background: var(--gray-50); border-radius: 12px; margin-bottom: 18px; font-size: .85rem; color: var(--gray-600); }
        .dias-preview strong { color: var(--primary); font-size: 1.2rem; }
        body.dark .form-label { color: #cbd5e1; }
        body.dark .form-input { background: #1e293b; border-color: #334155; color: #e2e8f0; }
        body.dark .dias-preview { background: rgba(255,255,255,.03); color: #94a3b8; }
    </style>
</head>
<body>
    @include('layouts.header')
    <main class="pg">
        <div class="max-w-500">
            <div class="page-header">
                <div>
                    <h1 class="page-title">Solicitar Ferias</h1>
                    <p class="page-sub">Preencha o periodo desejado</p>
                </div>
            </div>

            @if($errors->any())
            <div class="alert alert-error">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('ferias.store') }}" id="form-ferias">
                        @csrf
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Data Inicio</label>
                                <input type="date" name="data_inicio" id="data_inicio" class="form-input" value="{{ old('data_inicio') }}" required onchange="calcularDias()">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Data Fim</label>
                                <input type="date" name="data_fim" id="data_fim" class="form-input" value="{{ old('data_fim') }}" required onchange="calcularDias()">
                            </div>
                        </div>

                        <div class="dias-preview" id="dias-preview" style="display:none">
                            Total: <strong id="dias-total">0</strong> dias de ferias
                        </div>

                        <div class="form-group">
                            <label class="form-label">Observacao</label>
                            <textarea name="observacao" class="form-input" rows="3" placeholder="Motivo ou observacoes...">{{ old('observacao') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width:100%">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="5 12 12 5 19 12"/></svg>
                            Enviar Solicitacao
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script>
        function calcularDias() {
            var inicio = document.getElementById('data_inicio').value;
            var fim = document.getElementById('data_fim').value;
            var preview = document.getElementById('dias-preview');
            var total = document.getElementById('dias-total');

            if (inicio && fim) {
                var d1 = new Date(inicio + 'T00:00:00');
                var d2 = new Date(fim + 'T00:00:00');
                var dias = Math.round((d2 - d1) / (1000 * 60 * 60 * 24)) + 1;
                if (dias > 0) {
                    total.textContent = dias;
                    preview.style.display = 'block';
                } else {
                    preview.style.display = 'none';
                }
            }
        }
    </script>
    <script src="/js/dark.js"></script>
</body>
</html>