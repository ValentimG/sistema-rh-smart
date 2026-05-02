<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Editar Funcionario — SMART RH</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    @include('layouts.header')
    <main class="pg">
        <div class="section-title">Editar Funcionario</div>

        @if($errors->any())
        <div class="alert alert-error">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
        @endif

        <form method="POST" action="{{ route('funcionarios.update', $funcionario) }}" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="form-section">
                <div class="form-section-title">Dados Pessoais</div>
                <div class="form-group"><label class="form-label">Nome completo</label><input type="text" name="nome" class="form-input" value="{{ old('nome', $funcionario->nome) }}" required></div>
                <div class="form-row">
                    <div class="form-group"><label class="form-label">Data de Nascimento</label><input type="date" name="data_nascimento" class="form-input" value="{{ old('data_nascimento', $funcionario->data_nascimento?->format('Y-m-d')) }}"></div>
                    <div class="form-group"><label class="form-label">Sexo</label><select name="sexo" class="form-select"><option value="">Selecionar...</option><option value="masculino" {{ old('sexo',$funcionario->sexo)=='masculino'?'selected':'' }}>Masculino</option><option value="feminino" {{ old('sexo',$funcionario->sexo)=='feminino'?'selected':'' }}>Feminino</option><option value="outro" {{ old('sexo',$funcionario->sexo)=='outro'?'selected':'' }}>Outro</option></select></div>
                </div>
                <div class="form-row">
                    <div class="form-group"><label class="form-label">Estado Civil</label><select name="estado_civil" class="form-select"><option value="">Selecionar...</option><option value="solteiro" {{ old('estado_civil',$funcionario->estado_civil)=='solteiro'?'selected':'' }}>Solteiro</option><option value="casado" {{ old('estado_civil',$funcionario->estado_civil)=='casado'?'selected':'' }}>Casado</option><option value="divorciado" {{ old('estado_civil',$funcionario->estado_civil)=='divorciado'?'selected':'' }}>Divorciado</option><option value="viuvo" {{ old('estado_civil',$funcionario->estado_civil)=='viuvo'?'selected':'' }}>Viuvo</option></select></div>
                    <div class="form-group"><label class="form-label">Telefone</label><input type="text" name="telefone" class="form-input" value="{{ old('telefone', $funcionario->telefone) }}"></div>
                </div>
                <div class="form-group">
                    <label class="form-label">Foto de Perfil</label>
                    <input type="file" name="foto" class="form-input" accept="image/*" onchange="previewFoto(this)" style="padding:10px">
                    <img id="foto-preview" class="foto-preview {{ $funcionario->foto_url ? 'visible' : '' }}" src="{{ $funcionario->foto_url }}">
                </div>
            </div>

            <div class="form-section">
                <div class="form-section-title">Contato</div>
                <div class="form-row">
                    <div class="form-group"><label class="form-label">E-mail</label><input type="email" name="email" class="form-input" value="{{ old('email', $funcionario->email) }}" required></div>
                    <div class="form-group"><label class="form-label">CPF</label><input type="text" name="cpf" class="form-input" value="{{ old('cpf', $funcionario->cpf) }}" required></div>
                </div>
                <div class="form-group"><label class="form-label">Endereco</label><input type="text" name="endereco" class="form-input" value="{{ old('endereco', $funcionario->endereco) }}" required></div>
            </div>

            <div class="form-section">
                <div class="form-section-title">Dados Profissionais</div>
                <div class="form-row">
                    <div class="form-group"><label class="form-label">Cargo</label><input type="text" name="cargo" class="form-input" value="{{ old('cargo', $funcionario->cargo) }}" required></div>
                    <div class="form-group"><label class="form-label">Tipo de Contrato</label><select name="tipo_contrato" class="form-select"><option value="clt" {{ old('tipo_contrato',$funcionario->tipo_contrato)=='clt'?'selected':'' }}>CLT</option><option value="pj" {{ old('tipo_contrato',$funcionario->tipo_contrato)=='pj'?'selected':'' }}>PJ</option><option value="estagio" {{ old('tipo_contrato',$funcionario->tipo_contrato)=='estagio'?'selected':'' }}>Estagio</option></select></div>
                </div>
                <div class="form-row">
                    <div class="form-group"><label class="form-label">Data de Admissao</label><input type="date" name="data_admissao" class="form-input" value="{{ old('data_admissao', $funcionario->data_admissao->format('Y-m-d')) }}" required></div>
                    <div class="form-group"><label class="form-label">Tipo</label><select name="tipo" class="form-select"><option value="funcionario" {{ old('tipo',$funcionario->tipo)=='funcionario'?'selected':'' }}>Funcionario</option><option value="gestor" {{ old('tipo',$funcionario->tipo)=='gestor'?'selected':'' }}>Gestor</option></select></div>
                </div>
            </div>

            <div class="form-section">
                <div class="form-section-title">Remuneracao</div>
                <div class="form-row">
                    <div class="form-group"><label class="form-label">Salario Base (R$)</label><input type="number" step="0.01" name="salario_base" class="form-input" value="{{ old('salario_base', $funcionario->salario_base) }}"></div>
                    <div class="form-group"><label class="form-label">Carga Horaria Mensal (h)</label><input type="number" name="carga_horaria_mensal" class="form-input" value="{{ old('carga_horaria_mensal', $funcionario->carga_horaria_mensal) }}"></div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('funcionarios.show', $funcionario) }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Salvar Alteracoes</button>
            </div>
        </form>
    </main>
    <script>
        function previewFoto(input) {
            var preview = document.getElementById('foto-preview');
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.add('visible');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <script src="/js/dark.js"></script>
</body>
</html>