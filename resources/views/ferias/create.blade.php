<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Solicitar Ferias — SMART RH</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/ferias.css">
</head>
<body>
    @include('layouts.header')
    <main class="pg pg-sm">
        <div class="page-header">
            <div>
                <h1 class="page-title">Solicitar Ferias</h1>
                <p class="page-sub">Preencha o periodo desejado para suas ferias</p>
            </div>
        </div>

        @if($errors->any())
        <div class="alert alert-error">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
        @endif

        <form method="POST" action="{{ route('ferias.store') }}" id="form-ferias">
            @csrf

            <div class="card">
                <div class="card-body">
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
                        <div class="dias-preview-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </div>
                        <div>
                            <span class="dias-preview-label">Total de dias</span>
                            <span class="dias-preview-value" id="dias-total">0</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Observacao</label>
                        <textarea name="observacao" class="form-input" rows="3" placeholder="Motivo ou observacoes sobre o periodo de ferias...">{{ old('observacao') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="5 12 12 5 19 12"/></svg>
                        Enviar Solicitacao
                    </button>
                </div>
            </div>
        </form>
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
                    total.textContent = dias + ' dia' + (dias > 1 ? 's' : '');
                    preview.style.display = 'flex';
                } else {
                    preview.style.display = 'none';
                }
            }
        }
    </script>
    <script src="/js/dark.js"></script>
</body>
</html>