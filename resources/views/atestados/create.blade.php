<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8"><link rel="icon" href="/favicon.svg" type="image/svg+xml"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Novo Atestado — SMART RH</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <style>
        .form-section { background: #fff; border: 1px solid var(--gray-200); border-radius: 16px; padding: 28px; margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,.04); }
        .form-section-title { font-size: .85rem; font-weight: 700; color: var(--gray-900); margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid var(--gray-100); }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: .76rem; font-weight: 600; color: var(--gray-800); margin-bottom: 5px; }
        .form-input, .form-select { width: 100%; padding: 11px 16px; border: 1.5px solid var(--gray-200); border-radius: 10px; font-size: .87rem; outline: none; transition: all .2s; background: #fff; }
        .form-input:focus, .form-select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37,99,235,.08); }
        .form-actions { display: flex; gap: 8px; justify-content: flex-end; margin-top: 8px; }
        .toggle-switch { display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: .85rem; color: var(--gray-800); }
        .toggle-switch input { display: none; }
        .toggle-track { width: 44px; height: 24px; background: var(--gray-200); border-radius: 12px; position: relative; transition: all .3s; }
        .toggle-track::after { content: ''; width: 20px; height: 20px; background: #fff; border-radius: 50%; position: absolute; top: 2px; left: 2px; transition: all .3s; }
        .toggle-switch input:checked + .toggle-track { background: var(--success); }
        .toggle-switch input:checked + .toggle-track::after { left: 22px; }
        .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; padding: 12px 16px; border-radius: 10px; margin-bottom: 18px; font-size: .8rem; }
        body.dark .form-section { background: rgba(30,41,59,.8); border-color: rgba(255,255,255,.05); }
        body.dark .form-section-title { color: #f1f5f9; border-bottom-color: rgba(255,255,255,.04); }
        body.dark .form-label { color: #cbd5e1; }
        body.dark .form-input, body.dark .form-select { background: #1e293b; border-color: #334155; color: #e2e8f0; }
        body.dark .toggle-switch { color: #cbd5e1; }
        body.dark .toggle-track { background: #475569; }
    </style>
</head>
<body>
    @include('layouts.header')
    <main class="pg" style="max-width:600px">
        <div class="section-title">Novo Atestado</div>

        @if($errors->any())
        <div class="alert-error">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
        @endif

        <form method="POST" action="{{ route('atestados.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-section">
                <div class="form-section-title">Funcionario</div>
                <div class="form-group">
                    <label class="form-label">Funcionario</label>
                    @if($atual->isGestor())
                    <select name="funcionario_id" class="form-select" required>
                        <option value="">Selecionar funcionario...</option>
                        @foreach($funcionarios as $func)
                        <option value="{{ $func->id }}" {{ old('funcionario_id', $preSelected) == $func->id ? 'selected' : '' }}>{{ $func->nome }} — {{ $func->cargo }}</option>
                        @endforeach
                    </select>
                    @else
                    <input type="hidden" name="funcionario_id" value="{{ $atual->id }}">
                    <p style="padding:11px 0;color:var(--gray-600)">{{ $atual->nome }}</p>
                    @endif
                </div>
            </div>

            <div class="form-section">
                <div class="form-section-title">Dados do Atestado</div>
                <div class="form-group">
                    <label class="form-label">Tipo</label>
                    <select name="tipo" class="form-select" required>
                        <option value="">Selecione...</option>
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
                        Sim — horas cobertas
                    </label>
                </div>
                <div class="form-group"><label class="form-label">Observacao</label><textarea name="observacao" class="form-input" rows="3">{{ old('observacao') }}</textarea></div>
            </div>

            <div class="form-section">
                <div class="form-section-title">Arquivo (opcional)</div>
                <div class="form-group">
                    <div class="file-upload-wrapper">
                        <input type="file" name="arquivo" id="arquivo-input" accept=".pdf,.jpg,.jpeg,.png">
                        <label for="arquivo-input" class="file-upload-trigger">
                            <div class="file-upload-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            </div>
                            <div class="file-upload-text">
                                <span>Clique para anexar</span> ou arraste o arquivo<br>PDF, JPG ou PNG (max 2MB)
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
