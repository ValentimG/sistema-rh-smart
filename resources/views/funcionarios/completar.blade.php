<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Completar Perfil — SMART RH</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <style>
        .card { padding: 32px; max-width: 520px; margin: 0 auto; }
        .card-tt { font-size: 1.2rem; font-weight: 800; color: var(--gray-900); text-align: center; margin-bottom: 4px; }
        .card-sb { font-size: .82rem; color: var(--gray-400); text-align: center; margin-bottom: 28px; }
        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: .78rem; font-weight: 600; color: var(--gray-800); margin-bottom: 5px; }
        .form-input, .form-select { width: 100%; padding: 12px 16px; border: 1.5px solid var(--gray-200); border-radius: 10px; font-size: .87rem; outline: none; transition: all .2s; background: #fff; }
        .form-input:focus, .form-select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37,99,235,.08); }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .btn-p { width: 100%; padding: 13px; background: linear-gradient(135deg, var(--primary), #6366f1); color: #fff; border: none; border-radius: 10px; font-weight: 700; font-size: .9rem; cursor: pointer; transition: all .3s; box-shadow: 0 4px 12px rgba(37,99,235,.25); }
        .btn-p:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(37,99,235,.35); }
        .alert-err { background: #fee2e2; color: #991b1b; padding: 12px 16px; border-radius: 10px; font-size: .8rem; margin-bottom: 18px; }
        body.dark .card-tt { color: #f1f5f9; }
        body.dark .form-label { color: #cbd5e1; }
        body.dark .form-input, body.dark .form-select { background: #1e293b; border-color: #334155; color: #e2e8f0; }
    </style>
</head>
<body style="display:flex;align-items:center;justify-content:center;min-height:100vh;padding:24px">
    <div class="card">
        <div class="card-tt">Complete seu Perfil</div>
        <div class="card-sb">Preencha suas informacoes para comecar a usar o sistema</div>

        @if($errors->any())
        <div class="alert-err">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
        @endif

        <form method="POST" action="{{ route('perfil.salvar') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">CPF</label>
                <input type="text" name="cpf" class="form-input" value="{{ old('cpf', $funcionario->cpf) }}" oninput="mascaraCPF(this)" maxlength="14" placeholder="000.000.000-00" required>
            </div>
            <div class="form-group">
                <label class="form-label">Endereco completo</label>
                <input type="text" name="endereco" class="form-input" value="{{ old('endereco', $funcionario->endereco) }}" placeholder="Rua, numero, bairro, cidade" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Nascimento</label>
                    <input type="date" name="data_nascimento" class="form-input" value="{{ old('data_nascimento', $funcionario->data_nascimento?->format('Y-m-d')) }}" max="{{ now()->subYears(14)->format('Y-m-d') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Telefone</label>
                    <input type="text" name="telefone" class="form-input" value="{{ old('telefone', $funcionario->telefone) }}" oninput="mascaraTelefone(this)" maxlength="15" placeholder="(11) 99999-9999">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Sexo</label>
                    <select name="sexo" class="form-select">
                        <option value="">Selecionar...</option>
                        <option value="masculino" {{ old('sexo', $funcionario->sexo)=='masculino'?'selected':'' }}>Masculino</option>
                        <option value="feminino" {{ old('sexo', $funcionario->sexo)=='feminino'?'selected':'' }}>Feminino</option>
                        <option value="outro" {{ old('sexo', $funcionario->sexo)=='outro'?'selected':'' }}>Outro</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Estado Civil</label>
                    <select name="estado_civil" class="form-select">
                        <option value="">Selecionar...</option>
                        <option value="solteiro" {{ old('estado_civil', $funcionario->estado_civil)=='solteiro'?'selected':'' }}>Solteiro</option>
                        <option value="casado" {{ old('estado_civil', $funcionario->estado_civil)=='casado'?'selected':'' }}>Casado</option>
                        <option value="divorciado" {{ old('estado_civil', $funcionario->estado_civil)=='divorciado'?'selected':'' }}>Divorciado</option>
                        <option value="viuvo" {{ old('estado_civil', $funcionario->estado_civil)=='viuvo'?'selected':'' }}>Viuvo</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Cargo</label>
                <input type="text" name="cargo" class="form-input" value="{{ old('cargo', $funcionario->cargo) }}" placeholder="Ex: Analista de RH" required>
            </div>
            <button type="submit" class="btn-p">Salvar e Acessar o Sistema</button>
        </form>
    </div>
    <script>
        function mascaraCPF(input) {
            var v = input.value.replace(/\D/g, '');
            v = v.replace(/(\d{3})(\d)/, '$1.$2');
            v = v.replace(/(\d{3})(\d)/, '$1.$2');
            v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            input.value = v;
        }
        function mascaraTelefone(input) {
            var v = input.value.replace(/\D/g, '');
            v = v.replace(/^(\d{2})(\d)/, '($1) $2');
            v = v.replace(/(\d{5})(\d)/, '$1-$2');
            input.value = v;
        }
    </script>
</body>
</html>