<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Completar Perfil — SMART RH</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body style="display:flex;align-items:center;justify-content:center;min-height:100vh;padding:24px">
    <div class="card" style="max-width:520px;width:100%">
        <div class="card-body">
            <div style="text-align:center;margin-bottom:24px">
                <div style="font-size:1.2rem;font-weight:800;color:var(--gray-900)">Complete seu Perfil</div>
                <div style="font-size:.82rem;color:var(--gray-400);margin-top:4px">Preencha suas informacoes para comecar a usar o sistema</div>
            </div>

            @if($errors->any())
            <div class="alert alert-error">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
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
                <button type="submit" class="btn btn-primary" style="width:100%">Salvar e Acessar o Sistema</button>
            </form>
        </div>
    </div>

    <button class="theme-toggle" style="position:fixed;bottom:24px;right:24px;z-index:999;width:44px;height:44px;border-radius:12px;font-size:1.2rem;box-shadow:0 4px 16px rgba(0,0,0,.15)" onclick="toggleDark()">☾</button>

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
        function toggleDark() {
            document.body.classList.toggle('dark');
            var btn = document.querySelector('.theme-toggle');
            btn.textContent = document.body.classList.contains('dark') ? '☀' : '☾';
            localStorage.setItem('darkMode', document.body.classList.contains('dark'));
        }
        if (localStorage.getItem('darkMode') === 'true') {
            document.body.classList.add('dark');
            document.querySelector('.theme-toggle').textContent = '☀';
        }
    </script>
</body>
</html>