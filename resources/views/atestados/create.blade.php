<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Novo Atestado — SMART RH</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    @include('layouts.header')
    <main class="pg pg-sm">
        <div class="page-header">
            <h1 class="page-title">Novo Atestado</h1>
            <p class="page-sub">Preencha os dados para enviar um novo atestado</p>
        </div>

        @if($errors->any())
        <div class="alert alert-error">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
        @endif

        <form method="POST" action="{{ route('atestados.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="card">
                <div class="card-header"><span class="card-title">Funcionario</span></div>
                <div class="card-body">
                    @if($atual->isGestor())
                    <div class="form-group">
                        <label class="form-label">Selecione o funcionario</label>
                        <select name="funcionario_id" class="form-select" required>
                            <option value="">Selecionar funcionario...</option>
                            @foreach($funcionarios as $func)
                            <option value="{{ $func->id }}" {{ old('funcionario_id', $preSelected) == $func->id ? 'selected' : '' }}>
                                {{ $func->nome }} — {{ $func->cargo }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @else
                    <input type="hidden" name="funcionario_id" value="{{ $atual->id }}">
                    <div class="info-row"><span class="info-label">Funcionario</span><span class="info-value">{{ $atual->nome }}</span></div>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header"><span class="card-title">Dados do Atestado</span></div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Tipo de Atestado</label>
                        <select name="tipo" class="form-select" required>
                            <option value="">Selecione o tipo...</option>
                            <option value="medico" {{ old('tipo')=='medico'?'selected':'' }}>Medico</option>
                            <option value="odontologico" {{ old('tipo')=='odontologico'?'selected':'' }}>Odontologico</option>
                            <option value="acompanhamento" {{ old('tipo')=='acompanhamento'?'selected':'' }}>Acompanhamento</option>
                            <option value="outros" {{ old('tipo')=='outros'?'selected':'' }}>Outros</option>
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="form-group"><label class="form-label">Data Inicio</label><input type="date" name="data_inicio" class="form-input" value="{{ old('data_inicio') }}" required></div>
                        <div class="form-group"><label class="form-label">Data Fim</label><input type="date" name="data_fim" class="form-input" value="{{ old('data_fim') }}" required></div>
                    </div>
                    <div class="form-group">
                        <label class="toggle-switch">
                            <input type="checkbox" name="cobre_horas" value="1" {{ old('cobre_horas') ? 'checked' : '' }}>
                            <span class="toggle-track"></span>
                            As horas deste periodo serao cobertas
                        </label>
                    </div>
                    <div class="form-group"><label class="form-label">Observacao</label><textarea name="observacao" class="form-input" rows="3" placeholder="Descreva o motivo ou detalhes do atestado...">{{ old('observacao') }}</textarea></div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><span class="card-title">Arquivo Anexo</span><span class="badge badge-danger">Obrigatorio</span></div>
                <div class="card-body">
                    <div class="file-upload-wrapper">
                        <input type="file" name="arquivo" id="arquivo-input" accept=".pdf,.jpg,.jpeg,.png" required>
                        <label for="arquivo-input" class="file-upload-trigger">
                            <div class="file-upload-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            </div>
                            <div class="file-upload-text">
                                <span>Clique para anexar</span> ou arraste o arquivo<br>PDF, JPG ou PNG (maximo 2MB)
                            </div>
                        </label>
                    </div>
                    <div class="file-name" id="file-name">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>
                        <span id="file-name-text"></span>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('atestados.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Enviar Atestado</button>
            </div>
        </form>
    </main>
    <script>
        document.getElementById('arquivo-input').addEventListener('change', function() {
            var fileName = this.files[0]?.name || '';
            var display = document.getElementById('file-name');
            if (fileName) {
                document.getElementById('file-name-text').textContent = fileName;
                display.classList.add('visible');
            } else {
                display.classList.remove('visible');
            }
        });
    </script>
    <script src="/js/dark.js"></script>
</body>
</html>