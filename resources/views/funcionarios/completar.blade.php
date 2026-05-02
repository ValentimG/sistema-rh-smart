<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8"><link rel="icon" href="/favicon.svg" type="image/svg+xml"><meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Completar Perfil — SMART RH</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0;font-family:'Inter',sans-serif}
body{min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px;background:linear-gradient(135deg,#eff6ff 0%,#f0f4ff 30%,#f8f9fa 60%,#fef3c7 100%)}
body::before{content:'';position:fixed;top:-50%;left:-50%;width:200%;height:200%;background:radial-gradient(circle at 30% 70%,rgba(37,99,235,.06) 0%,transparent 50%),radial-gradient(circle at 70% 30%,rgba(245,158,11,.05) 0%,transparent 50%);pointer-events:none;animation:bgFloat 20s ease-in-out infinite}
@keyframes bgFloat{0%,100%{transform:translate(0,0)}50%{transform:translate(-2%,-1%)}}
.card{background:rgba(255,255,255,.9);backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,.6);border-radius:16px;padding:36px;width:100%;max-width:540px;box-shadow:0 8px 40px rgba(0,0,0,.08),0 2px 8px rgba(37,99,235,.06);animation:slideUp .5s ease-out}
@keyframes slideUp{from{opacity:0;transform:translateY(30px)}to{opacity:1;transform:translateY(0)}}
.logo{text-align:center;margin-bottom:28px}
.logo-ic{width:48px;height:48px;background:linear-gradient(135deg,#2563eb,#4f46e5);border-radius:12px;display:inline-flex;align-items:center;justify-content:center;color:#fff;font-weight:900;font-size:1rem;margin-bottom:10px;box-shadow:0 4px 16px rgba(37,99,235,.3)}
.card-tt{font-size:1.3rem;font-weight:800;color:#111827;text-align:center;margin-bottom:4px}
.card-sb{font-size:.82rem;color:#6b7280;text-align:center;margin-bottom:28px}
.form-group{margin-bottom:16px}
.form-label{display:block;font-size:.78rem;font-weight:600;color:#374151;margin-bottom:5px}
.form-input,.form-select{width:100%;padding:11px 16px;border:1.5px solid #e5e7eb;border-radius:10px;font-size:.87rem;outline:none;transition:all .2s;background:#fafbfc}
.form-input:focus,.form-select:focus{border-color:#2563eb;box-shadow:0 0 0 4px rgba(37,99,235,.1);background:#fff}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.btn-p{width:100%;padding:13px;background:linear-gradient(135deg,#2563eb,#4f46e5);color:#fff;border:none;border-radius:10px;font-weight:700;font-size:.9rem;cursor:pointer;transition:all .3s;box-shadow:0 4px 16px rgba(37,99,235,.25)}
.btn-p:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(37,99,235,.4)}
.btn-p:active{transform:scale(.98)}
.alert-err{background:#fff5f5;color:#991b1b;padding:12px 16px;border-radius:10px;font-size:.8rem;margin-bottom:18px;border:1px solid #fecaca;animation:shake .4s}
@keyframes shake{0%,100%{transform:translateX(0)}25%{transform:translateX(-5px)}75%{transform:translateX(5px)}}
select.form-select{appearance:none;background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");background-position:right 12px center;background-repeat:no-repeat;background-size:18px;padding-right:40px}
</style>
</head>
<body>
<div class="card">
    <div class="logo">
        <div class="logo-ic">RH</div>
        <div class="card-tt">Complete seu Perfil</div>
        <div class="card-sb">Preencha suas informacoes para comecar a usar o sistema</div>
    </div>

    @if($errors->any())
    <div class="alert-err">
        @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
    </div>
    @endif

    <form method="POST" action="{{ route('perfil.salvar') }}">
        @csrf
        <div class="form-group">
            <label class="form-label">CPF</label>
            <input type="text" name="cpf" class="form-input" value="{{ old('cpf', $funcionario->cpf) }}" placeholder="000.000.000-00" required>
        </div>
        <div class="form-group">
            <label class="form-label">Endereco completo</label>
            <input type="text" name="endereco" class="form-input" value="{{ old('endereco', $funcionario->endereco) }}" placeholder="Rua, numero, bairro, cidade" required>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Nascimento</label>
                <input type="date" name="data_nascimento" class="form-input" value="{{ old('data_nascimento', $funcionario->data_nascimento?->format('Y-m-d')) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Telefone</label>
                <input type="text" name="telefone" class="form-input" value="{{ old('telefone', $funcionario->telefone) }}" placeholder="(11) 99999-9999">
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
</body>
</html>
