<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 32 32%22><rect width=%2232%22 height=%2232%22 rx=%226%22 fill=%22%234f46e5%22/><text x=%224%22 y=%2223%22 fill=%22white%22 font-family=%22system-ui%22 font-weight=%22800%22 font-size=%2215%22>RH</text></svg>"><link rel="stylesheet" href="/rh-theme.css"><script>if(localStorage.getItem('rhDark')=='1')document.documentElement.classList.add('dark')</script><script src="/rh.js" defer></script>
<title>Novo Atestado — {{ config('app.name') }}</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
.pg{max-width:860px;margin:0 auto;padding:32px 24px}
.fc{background:#fff;border:1px solid #e5e7eb;border-radius:10px;margin-bottom:16px;overflow:hidden}
.fh{padding:13px 24px;border-bottom:1px solid #f3f4f6;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:#9ca3af;background:#fafafa}
.fb{padding:22px 24px}
.g2{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.f{display:flex;flex-direction:column;gap:5px;margin-bottom:14px}
.f:last-child{margin-bottom:0}
label{font-size:.75rem;font-weight:600;color:#374151}
.inp{padding:9px 12px;border:1px solid #e5e7eb;border-radius:8px;font-size:.85rem;color:#111827;background:#fff;outline:none;transition:.15s;width:100%}
.inp:focus{border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.08)}
.inp.err{border-color:#dc2626}
.em{font-size:.72rem;color:#dc2626;font-weight:500}
.hint{font-size:.7rem;color:#9ca3af}
.dias-box{background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:9px 14px;margin-top:6px;font-size:.82rem;color:#065f46;font-weight:600;display:none}
.toggle-row{display:flex;align-items:center;gap:10px;padding:8px 0}
.toggle{width:40px;height:22px;border-radius:999px;background:#d1d5db;cursor:pointer;transition:.2s;position:relative;border:none;flex-shrink:0}
.toggle.on{background:#2563eb}
.toggle::after{content:'';position:absolute;width:16px;height:16px;background:#fff;border-radius:50%;top:3px;left:3px;transition:.2s;box-shadow:0 1px 2px rgba(0,0,0,.2)}
.toggle.on::after{left:21px}
.toggle-lbl{font-size:.82rem;font-weight:500;color:#374151}
.upload-area{border:2px dashed #e5e7eb;border-radius:8px;padding:22px;text-align:center;cursor:pointer;transition:.15s;position:relative}
.upload-area:hover{border-color:#2563eb;background:#eff6ff}
.upload-area input{position:absolute;inset:0;opacity:0;cursor:pointer}
.upload-area svg{width:26px;height:26px;stroke:#9ca3af;fill:none;stroke-width:1.5}
.upload-lbl{font-size:.82rem;color:#374151;font-weight:500;margin-top:6px}
.upload-sub{font-size:.7rem;color:#9ca3af;margin-top:2px}
.file-prev{margin-top:8px;padding:9px 12px;background:#fafafa;border:1px solid #e5e7eb;border-radius:7px;display:none;align-items:center;gap:8px;font-size:.78rem;color:#374151}
.file-prev svg{width:14px;height:14px;stroke:#2563eb;fill:none;stroke-width:2}
.fa{display:flex;align-items:center;justify-content:flex-end;gap:10px;margin-top:4px}
.btn{display:inline-flex;align-items:center;gap:6px;padding:9px 20px;border-radius:8px;font-size:.85rem;font-weight:600;text-decoration:none;transition:.15s;border:1px solid transparent;cursor:pointer}
.btn-p{background:#2563eb;color:#fff}.btn-p:hover{background:#1d4ed8}
.btn-s{background:#fff;color:#374151;border-color:#e5e7eb}.btn-s:hover{background:#f3f4f6}
.btn svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2}
</style>
</head>
<body>
<header class="hd">
  <div class="logo">
    <div class="logo-ic">RH</div>
    <div><div class="logo-n">SMART RH</div><div class="logo-s">NOVO ATESTADO</div></div>
  </div>
  <div class="hd-r">
    <nav class="nav">
      @if($atual->isGestor())
      <a href="{{ route('gestor.dashboard') }}" class="nl"><svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>Dashboard</a>
      <a href="{{ route('funcionarios.index') }}" class="nl"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>Funcionarios</a>
      @else
      <a href="{{ route('ponto.index') }}" class="nl"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>Controle de Ponto</a>
      @endif
      <a href="{{ route('atestados.index') }}" class="nl on"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>{{ $atual->isGestor() ? 'Atestados' : 'Meus Atestados' }}</a>
    </nav>
    <div class="av">{{ strtoupper(substr(Auth::user()->name,0,1)) }}</div>
    <form method="POST" action="{{ route('logout') }}">@csrf
      <button type="submit" class="lg-btn"><svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>Sair</button>
    </form>
  </div>
</header>

<div class="pg">
    <form method="POST" action="{{ route('atestados.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="fc">
                <div class="fh">Funcionário</div>
                <div class="fb">
                    @if($atual->isGestor())
                    <div class="f">
                        <label for="funcionario_id">Selecionar Funcionário</label>
                        <select id="funcionario_id" name="funcionario_id" class="inp {{ $errors->has('funcionario_id') ? 'err' : '' }}">
                            <option value="">Selecione...</option>
                            @foreach($funcionarios as $fn)
                            <option value="{{ $fn->id }}" {{ old('funcionario_id', $preSelected) == $fn->id ? 'selected' : '' }}>{{ $fn->nome }} — {{ $fn->cargo }}</option>
                            @endforeach
                        </select>
                        @error('funcionario_id')<span class="em">{{ $message }}</span>@enderror
                    </div>
                    @else
                    <input type="hidden" name="funcionario_id" value="{{ $atual->id }}">
                    <div style="padding:10px 14px;background:#f9fafb;border:1px solid #e5e7eb;border-radius:8px;font-size:.85rem;font-weight:500;color:#374151">{{ $atual->nome }} — {{ $atual->cargo }}</div>
                    @endif
                </div>
            </div>

            <div class="fc">
                <div class="fh">Dados do Atestado</div>
                <div class="fb">
                    <div class="g2">
                        <div class="f">
                            <label for="tipo">Tipo</label>
                            <select id="tipo" name="tipo" class="inp {{ $errors->has('tipo') ? 'err' : '' }}">
                                <option value="">Selecione...</option>
                                <option value="medico"         {{ old('tipo') === 'medico'         ? 'selected' : '' }}>Médico</option>
                                <option value="odontologico"   {{ old('tipo') === 'odontologico'   ? 'selected' : '' }}>Odontológico</option>
                                <option value="acompanhamento" {{ old('tipo') === 'acompanhamento' ? 'selected' : '' }}>Acompanhamento</option>
                                <option value="outros"         {{ old('tipo') === 'outros'         ? 'selected' : '' }}>Outros</option>
                            </select>
                            @error('tipo')<span class="em">{{ $message }}</span>@enderror
                        </div>
                        <div class="f">
                            <label>Cobre Horas de Trabalho</label>
                            <div class="toggle-row">
                                <button type="button" class="toggle on" id="tog" onclick="toggleCobre(this)"></button>
                                <input type="hidden" name="cobre_horas" id="cobre-val" value="{{ old('cobre_horas', '1') }}">
                                <span class="toggle-lbl" id="cobre-lbl">Sim — horas cobertas</span>
                            </div>
                            <span class="hint">Indica se o afastamento justifica horas não trabalhadas.</span>
                        </div>
                    </div>
                    <div class="g2">
                        <div class="f">
                            <label for="data_inicio">Data de Início</label>
                            <input id="data_inicio" name="data_inicio" type="date" class="inp {{ $errors->has('data_inicio') ? 'err' : '' }}" value="{{ old('data_inicio') }}">
                            @error('data_inicio')<span class="em">{{ $message }}</span>@enderror
                        </div>
                        <div class="f">
                            <label for="data_fim">Data de Fim</label>
                            <input id="data_fim" name="data_fim" type="date" class="inp {{ $errors->has('data_fim') ? 'err' : '' }}" value="{{ old('data_fim') }}">
                            @error('data_fim')<span class="em">{{ $message }}</span>@enderror
                            <div class="dias-box" id="dias-box"></div>
                        </div>
                    </div>
                    <div class="f">
                        <label for="observacao">Observação</label>
                        <textarea id="observacao" name="observacao" class="inp" rows="3" style="resize:vertical">{{ old('observacao') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="fc">
                <div class="fh">Arquivo (opcional)</div>
                <div class="fb">
                    <div class="upload-area">
                        <input type="file" name="arquivo" accept=".pdf,.jpg,.jpeg,.png" onchange="previewFile(this)">
                        <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                        <div class="upload-lbl">Clique para selecionar ou arraste</div>
                        <div class="upload-sub">PDF, JPG ou PNG — máximo 2MB</div>
                    </div>
                    @error('arquivo')<span class="em" style="display:block;margin-top:6px">{{ $message }}</span>@enderror
                    <div class="file-prev" id="file-prev">
                        <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        <span id="file-name"></span>
                    </div>
                </div>
            </div>

            <div class="fa">
                <a href="{{ route('atestados.index') }}" class="btn btn-s">Cancelar</a>
                <button type="submit" class="btn btn-p">
                    <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/></svg>
                    Enviar Atestado
                </button>
            </div>
    </form>
</div>
<script>
function toggleCobre(btn){const on=btn.classList.toggle('on');document.getElementById('cobre-val').value=on?'1':'0';document.getElementById('cobre-lbl').textContent=on?'Sim — horas cobertas':'Não';}
function calcDias(){const i=document.getElementById('data_inicio').value,f=document.getElementById('data_fim').value,b=document.getElementById('dias-box');if(i&&f&&f>=i){const d=Math.round((new Date(f)-new Date(i))/86400000)+1;b.textContent=d+(d===1?' dia':' dias')+' de afastamento';b.style.display='block';}else{b.style.display='none';}}
document.getElementById('data_inicio').addEventListener('change',calcDias);
document.getElementById('data_fim').addEventListener('change',calcDias);
function previewFile(inp){const p=document.getElementById('file-prev');if(inp.files.length){document.getElementById('file-name').textContent=inp.files[0].name;p.style.display='flex';}else{p.style.display='none';}}
</script>
</body>
</html>


