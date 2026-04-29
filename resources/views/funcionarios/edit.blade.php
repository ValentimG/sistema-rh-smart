<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 32 32%22><rect width=%2232%22 height=%2232%22 rx=%226%22 fill=%22%234f46e5%22/><text x=%224%22 y=%2223%22 fill=%22white%22 font-family=%22system-ui%22 font-weight=%22800%22 font-size=%2215%22>RH</text></svg>"><link rel="stylesheet" href="/rh-theme.css"><script>if(localStorage.getItem('rhDark')=='1')document.documentElement.classList.add('dark')</script><script src="/rh.js" defer></script>
<title>Editar — {{ $funcionario->nome }} — {{ config('app.name') }}</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/build/assets/app-Wr1hRCJF.css">
<style>
*{box-sizing:border-box;margin:0;padding:0;font-family:'Inter',sans-serif}
body{background:#f8f9fa;color:#111827;min-height:100vh}
.hd{background:#fff;border-bottom:1px solid #e5e7eb;padding:0 40px;height:60px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:100}
.logo{display:flex;align-items:center;gap:10px}
.logo-ic{width:32px;height:32px;background:#2563eb;border-radius:7px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:900;font-size:.72rem}
.logo-n{font-size:.9rem;font-weight:700;color:#111827}.logo-s{font-size:.58rem;color:#9ca3af;font-weight:500}
.hd-r{display:flex;align-items:center;gap:10px}
.nav{display:flex;gap:2px}
.nl{display:flex;align-items:center;gap:6px;padding:7px 13px;border-radius:7px;color:#6b7280;text-decoration:none;font-size:.8rem;font-weight:500;transition:.15s;white-space:nowrap}
.nl:hover,.nl.on{background:#eff6ff;color:#2563eb}
.nl svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
.av{width:34px;height:34px;background:#2563eb;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.78rem;flex-shrink:0}
.lg-btn{display:flex;align-items:center;gap:5px;padding:7px 12px;border-radius:7px;color:#9ca3af;font-size:.8rem;font-weight:500;background:none;border:none;cursor:pointer;transition:.15s}
.lg-btn:hover{background:#f3f4f6;color:#374151}
.lg-btn svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
.pg{max-width:960px;margin:0 auto;padding:32px 24px}
.fc{background:#fff;border:1px solid #e5e7eb;border-radius:10px;margin-bottom:16px;overflow:hidden}
.fh{padding:13px 24px;border-bottom:1px solid #f3f4f6;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:#9ca3af;background:#fafafa}
.fb{padding:22px 24px}
.g2{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.g3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px}
.f{display:flex;flex-direction:column;gap:5px;margin-bottom:14px}
.f:last-child{margin-bottom:0}
label{font-size:.75rem;font-weight:600;color:#374151}
.inp{padding:9px 12px;border:1px solid #e5e7eb;border-radius:8px;font-size:.85rem;color:#111827;background:#fff;outline:none;transition:.15s;width:100%}
.inp:focus{border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.08)}
.inp.err{border-color:#dc2626;background:#fff5f5}
.inp-ro{background:#fafafa;color:#9ca3af;cursor:not-allowed}
.em{font-size:.72rem;color:#dc2626;font-weight:500}
.hint{font-size:.7rem;color:#9ca3af;margin-top:1px}
.chk-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-top:4px}
.chk-item{display:flex;align-items:center;gap:7px;padding:8px 10px;border:1px solid #e5e7eb;border-radius:7px;cursor:pointer;transition:.15s}
.chk-item:hover{border-color:#bfdbfe;background:#eff6ff}
.chk-item input[type=checkbox]{accent-color:#2563eb;width:14px;height:14px}
.chk-item span{font-size:.78rem;color:#374151}
.vh-box{background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:11px 14px;margin-top:8px}
.vh-lbl{font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:#059669}
.vh-val{font-size:1.05rem;font-weight:700;color:#065f46;font-variant-numeric:tabular-nums;margin-top:2px}
.fa{display:flex;align-items:center;justify-content:flex-end;gap:10px;margin-top:4px}
.btn{display:inline-flex;align-items:center;gap:6px;padding:9px 20px;border-radius:8px;font-size:.85rem;font-weight:600;text-decoration:none;transition:.15s;border:1px solid transparent;cursor:pointer}
.btn-p{background:#2563eb;color:#fff}.btn-p:hover{background:#1d4ed8}
.btn-s{background:#fff;color:#374151;border-color:#e5e7eb}.btn-s:hover{background:#f3f4f6}
.btn svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
</style>
</head>
<body>
<header class="hd">
  <div class="logo">
    <div class="logo-ic">RH</div>
    <div><div class="logo-n">SMART RH</div><div class="logo-s">EDITAR FUNCIONARIO</div></div>
  </div>
  <div class="hd-r">
    <nav class="nav">
      <a href="{{ route('gestor.dashboard') }}" class="nl"><svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>Dashboard</a>
      <a href="{{ route('funcionarios.index') }}" class="nl on"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>Funcionarios</a>
    </nav>
    <div class="av">{{ strtoupper(substr(Auth::user()->name,0,1)) }}</div>
    <form method="POST" action="{{ route('logout') }}">@csrf
      <button type="submit" class="lg-btn"><svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>Sair</button>
    </form>
  </div>
</header>

<div class="pg">
    <form method="POST" action="{{ route('funcionarios.update', $funcionario) }}">
            @csrf @method('PUT')

            {{-- SEÇÃO 1: Dados Pessoais --}}
            <div class="fc">
                <div class="fh">Dados Pessoais</div>
                <div class="fb">
                    <div class="f">
                        <label for="nome">Nome completo</label>
                        <input id="nome" name="nome" type="text" class="inp {{ $errors->has('nome') ? 'err' : '' }}" value="{{ old('nome', $funcionario->nome) }}">
                        @error('nome')<span class="em">{{ $message }}</span>@enderror
                    </div>
                    <div class="g3">
                        <div class="f">
                            <label for="data_nascimento">Data de Nascimento</label>
                            <input id="data_nascimento" name="data_nascimento" type="date" class="inp" value="{{ old('data_nascimento', $funcionario->data_nascimento?->format('Y-m-d')) }}">
                        </div>
                        <div class="f">
                            <label for="sexo">Sexo</label>
                            <select id="sexo" name="sexo" class="inp">
                                <option value="">Selecione...</option>
                                <option value="masculino"            {{ old('sexo', $funcionario->sexo) === 'masculino'            ? 'selected' : '' }}>Masculino</option>
                                <option value="feminino"             {{ old('sexo', $funcionario->sexo) === 'feminino'             ? 'selected' : '' }}>Feminino</option>
                                <option value="outro"                {{ old('sexo', $funcionario->sexo) === 'outro'                ? 'selected' : '' }}>Outro</option>
                                <option value="prefiro_nao_informar" {{ old('sexo', $funcionario->sexo) === 'prefiro_nao_informar' ? 'selected' : '' }}>Prefiro não informar</option>
                            </select>
                        </div>
                        <div class="f">
                            <label for="estado_civil">Estado Civil</label>
                            <select id="estado_civil" name="estado_civil" class="inp">
                                <option value="">Selecione...</option>
                                <option value="solteiro"      {{ old('estado_civil', $funcionario->estado_civil) === 'solteiro'      ? 'selected' : '' }}>Solteiro(a)</option>
                                <option value="casado"        {{ old('estado_civil', $funcionario->estado_civil) === 'casado'        ? 'selected' : '' }}>Casado(a)</option>
                                <option value="divorciado"    {{ old('estado_civil', $funcionario->estado_civil) === 'divorciado'    ? 'selected' : '' }}>Divorciado(a)</option>
                                <option value="viuvo"         {{ old('estado_civil', $funcionario->estado_civil) === 'viuvo'         ? 'selected' : '' }}>Viúvo(a)</option>
                                <option value="uniao_estavel" {{ old('estado_civil', $funcionario->estado_civil) === 'uniao_estavel' ? 'selected' : '' }}>União Estável</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SEÇÃO 2: Contato --}}
            <div class="fc">
                <div class="fh">Contato</div>
                <div class="fb">
                    <div class="g2">
                        <div class="f">
                            <label for="email">E-mail</label>
                            <input id="email" name="email" type="email" class="inp {{ $errors->has('email') ? 'err' : '' }}" value="{{ old('email', $funcionario->email) }}">
                            @error('email')<span class="em">{{ $message }}</span>@enderror
                        </div>
                        <div class="f">
                            <label for="telefone">Telefone</label>
                            <input id="telefone" name="telefone" type="text" class="inp" value="{{ old('telefone', $funcionario->telefone) }}" maxlength="20">
                        </div>
                    </div>
                    <div class="g2">
                        <div class="f">
                            <label for="cpf">CPF</label>
                            <input id="cpf" name="cpf" type="text" class="inp {{ $errors->has('cpf') ? 'err' : '' }}" value="{{ old('cpf', $funcionario->cpf) }}" maxlength="14">
                            @error('cpf')<span class="em">{{ $message }}</span>@enderror
                        </div>
                        <div class="f">
                            <label for="endereco">Endereço</label>
                            <input id="endereco" name="endereco" type="text" class="inp {{ $errors->has('endereco') ? 'err' : '' }}" value="{{ old('endereco', $funcionario->endereco) }}">
                            @error('endereco')<span class="em">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- SEÇÃO 3: Dados Profissionais --}}
            <div class="fc">
                <div class="fh">Dados Profissionais</div>
                <div class="fb">
                    <div class="g3">
                        <div class="f">
                            <label for="cargo">Cargo</label>
                            <input id="cargo" name="cargo" type="text" class="inp {{ $errors->has('cargo') ? 'err' : '' }}" value="{{ old('cargo', $funcionario->cargo) }}">
                            @error('cargo')<span class="em">{{ $message }}</span>@enderror
                        </div>
                        <div class="f">
                            <label for="tipo_contrato">Tipo de Contrato</label>
                            <select id="tipo_contrato" name="tipo_contrato" class="inp">
                                <option value="clt"          {{ old('tipo_contrato', $funcionario->tipo_contrato) === 'clt'          ? 'selected' : '' }}>CLT</option>
                                <option value="pj"           {{ old('tipo_contrato', $funcionario->tipo_contrato) === 'pj'           ? 'selected' : '' }}>Pessoa Jurídica</option>
                                <option value="estagio"      {{ old('tipo_contrato', $funcionario->tipo_contrato) === 'estagio'      ? 'selected' : '' }}>Estágio</option>
                                <option value="temporario"   {{ old('tipo_contrato', $funcionario->tipo_contrato) === 'temporario'   ? 'selected' : '' }}>Temporário</option>
                                <option value="terceirizado" {{ old('tipo_contrato', $funcionario->tipo_contrato) === 'terceirizado' ? 'selected' : '' }}>Terceirizado</option>
                            </select>
                        </div>
                        <div class="f">
                            <label for="tipo">Perfil de Acesso</label>
                            <select id="tipo" name="tipo" class="inp {{ $errors->has('tipo') ? 'err' : '' }}">
                                <option value="funcionario" {{ old('tipo', $funcionario->tipo) === 'funcionario' ? 'selected' : '' }}>Funcionário</option>
                                <option value="gestor"      {{ old('tipo', $funcionario->tipo) === 'gestor'      ? 'selected' : '' }}>Gestor</option>
                            </select>
                            @error('tipo')<span class="em">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="f" style="max-width:220px">
                        <label for="data_admissao">Data de Admissão</label>
                        <input id="data_admissao" name="data_admissao" type="date" class="inp {{ $errors->has('data_admissao') ? 'err' : '' }}" value="{{ old('data_admissao', $funcionario->data_admissao->format('Y-m-d')) }}">
                        @error('data_admissao')<span class="em">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            {{-- SEÇÃO 4: Remuneração --}}
            <div class="fc">
                <div class="fh">Remuneração</div>
                <div class="fb">
                    <div class="g2">
                        <div class="f">
                            <label for="salario_base">Salário Base (R$)</label>
                            <input id="salario_base" name="salario_base" type="number" step="0.01" min="0" class="inp {{ $errors->has('salario_base') ? 'err' : '' }}" value="{{ old('salario_base', $funcionario->salario_base) }}">
                            @error('salario_base')<span class="em">{{ $message }}</span>@enderror
                            <div class="vh-box" id="vh-box">
                                <div class="vh-lbl">Valor por hora</div>
                                <div class="vh-val" id="vh-val">R$ {{ number_format($funcionario->valorHora(), 2, ',', '.') }}</div>
                            </div>
                        </div>
                        <div class="f">
                            <label for="carga_horaria_mensal">Carga Horária Mensal (h)</label>
                            <input id="carga_horaria_mensal" name="carga_horaria_mensal" type="number" min="1" class="inp" value="{{ old('carga_horaria_mensal', $funcionario->carga_horaria_mensal) }}">
                            <span class="hint">Padrão CLT: 220h/mês</span>
                        </div>
                    </div>
                    <div class="f">
                        <label>Benefícios</label>
                        <div class="chk-grid">
                            @php $bAtivos = old('beneficios', $funcionario->beneficios ?? []); @endphp
                            @foreach(['Vale Refeição','Vale Alimentação','Vale Transporte','Plano de Saúde','Plano Odontológico','Seguro de Vida','Gympass','PLR'] as $b)
                            <label class="chk-item">
                                <input type="checkbox" name="beneficios[]" value="{{ $b }}"
                                    {{ in_array($b, $bAtivos) ? 'checked' : '' }}>
                                <span>{{ $b }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="f" style="max-width:220px;margin-top:14px">
                        <label>Banco de Horas (somente leitura)</label>
                        <input type="text" class="inp inp-ro" value="{{ number_format($funcionario->banco_horas, 2, ',', '.') }}h" readonly>
                        <span class="hint">Atualizado pelo sistema de ponto.</span>
                    </div>
                </div>
            </div>

            {{-- SEÇÃO 5: Saúde e Segurança --}}
            <div class="fc">
                <div class="fh">Saúde e Segurança</div>
                <div class="fb">
                    <div class="g2">
                        <div class="f">
                            <label for="exame_admissional_data">Exame Admissional — Data</label>
                            <input id="exame_admissional_data" name="exame_admissional_data" type="date" class="inp" value="{{ old('exame_admissional_data', $funcionario->exame_admissional_data?->format('Y-m-d')) }}">
                        </div>
                        <div class="f">
                            <label for="exame_admissional_resultado">Resultado Admissional</label>
                            <select id="exame_admissional_resultado" name="exame_admissional_resultado" class="inp">
                                <option value="">Selecione...</option>
                                <option value="Apto"               {{ old('exame_admissional_resultado', $funcionario->exame_admissional_resultado) === 'Apto'               ? 'selected' : '' }}>Apto</option>
                                <option value="Apto com restrição" {{ old('exame_admissional_resultado', $funcionario->exame_admissional_resultado) === 'Apto com restrição' ? 'selected' : '' }}>Apto com restrição</option>
                                <option value="Inapto"             {{ old('exame_admissional_resultado', $funcionario->exame_admissional_resultado) === 'Inapto'             ? 'selected' : '' }}>Inapto</option>
                            </select>
                        </div>
                    </div>
                    <div class="g2">
                        <div class="f">
                            <label for="exame_demissional_data">Exame Demissional — Data</label>
                            <input id="exame_demissional_data" name="exame_demissional_data" type="date" class="inp" value="{{ old('exame_demissional_data', $funcionario->exame_demissional_data?->format('Y-m-d')) }}">
                        </div>
                        <div class="f">
                            <label for="exame_demissional_resultado">Resultado Demissional</label>
                            <select id="exame_demissional_resultado" name="exame_demissional_resultado" class="inp">
                                <option value="">Selecione...</option>
                                <option value="Apto"               {{ old('exame_demissional_resultado', $funcionario->exame_demissional_resultado) === 'Apto'               ? 'selected' : '' }}>Apto</option>
                                <option value="Apto com restrição" {{ old('exame_demissional_resultado', $funcionario->exame_demissional_resultado) === 'Apto com restrição' ? 'selected' : '' }}>Apto com restrição</option>
                                <option value="Inapto"             {{ old('exame_demissional_resultado', $funcionario->exame_demissional_resultado) === 'Inapto'             ? 'selected' : '' }}>Inapto</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="fa">
                <a href="{{ route('funcionarios.show', $funcionario) }}" class="btn btn-s">Cancelar</a>
                <button type="submit" class="btn btn-p">
                    <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Salvar Alterações
                </button>
            </div>
    </form>
</div>

<script>
function calcVH() {
    const s   = parseFloat(document.getElementById('salario_base').value) || 0;
    const c   = parseInt(document.getElementById('carga_horaria_mensal').value) || 220;
    const box = document.getElementById('vh-box');
    document.getElementById('vh-val').textContent = 'R$ ' + (c > 0 ? (s/c).toFixed(2) : '0.00').replace('.',',');
    box.style.display = s > 0 ? 'block' : 'none';
}
document.getElementById('salario_base').addEventListener('input', calcVH);
document.getElementById('carga_horaria_mensal').addEventListener('input', calcVH);
calcVH();
</script>
</body>
</html>


