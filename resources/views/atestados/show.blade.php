<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 32 32%22><rect width=%2232%22 height=%2232%22 rx=%226%22 fill=%22%234f46e5%22/><text x=%224%22 y=%2223%22 fill=%22white%22 font-family=%22system-ui%22 font-weight=%22800%22 font-size=%2215%22>RH</text></svg>"><link rel="stylesheet" href="/rh-theme.css"><script>if(localStorage.getItem('rhDark')=='1')document.documentElement.classList.add('dark')</script><script src="/rh.js" defer></script>
<title>Atestado #{{ $atestado->id }} — {{ config('app.name') }}</title>
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
.card{background:#fff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;margin-bottom:14px;transition:.2s}
.card:hover{box-shadow:0 2px 8px rgba(0,0,0,.06)}
.ch{padding:14px 22px;border-bottom:1px solid #f3f4f6;background:#fafafa;display:flex;align-items:center;justify-content:space-between}
.ch-t{font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:#9ca3af}
.cb{padding:20px 22px}
.fd{padding:10px 0;border-bottom:1px solid #fafafa;display:flex;flex-direction:column;gap:3px}
.fd:last-child{border-bottom:none}
.fl{font-size:.63rem;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#9ca3af}
.fv{font-size:.87rem;font-weight:500;color:#111827}
.fv.obs{color:#374151;font-style:italic;font-size:.82rem}
.bg{display:inline-flex;align-items:center;padding:5px 16px;border-radius:999px;font-size:.8rem;font-weight:700}
.st-a{background:#dcfce7;color:#15803d}
.st-p{background:#fef9c3;color:#92400e}
.st-r{background:#fee2e2;color:#991b1b}
.btn{display:inline-flex;align-items:center;gap:6px;padding:8px 18px;border-radius:8px;font-size:.82rem;font-weight:600;text-decoration:none;transition:.15s;border:1px solid transparent;cursor:pointer}
.btn-s{background:#fff;color:#374151;border-color:#e5e7eb}.btn-s:hover{background:#f3f4f6}
.btn-apr{background:#dcfce7;color:#15803d;border-color:#bbf7d0}.btn-apr:hover{background:#bbf7d0}
.btn-rep{background:#fee2e2;color:#991b1b;border-color:#fecaca}.btn-rep:hover{background:#fca5a5}
.btn-del{background:#fff;color:#dc2626;border-color:#fecaca}.btn-del:hover{background:#fee2e2}
.btn svg{width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2}
.acts{display:flex;gap:8px;flex-wrap:wrap;margin-top:4px}
.alert{padding:12px 16px;border-radius:8px;font-size:.82rem;font-weight:500;margin-bottom:18px}
.alert-ok{background:#dcfce7;color:#15803d;border:1px solid #bbf7d0}
.img-preview{max-width:100%;max-height:360px;border-radius:8px;border:1px solid #e5e7eb;margin-top:8px;display:block}
.pdf-link{display:inline-flex;align-items:center;gap:6px;padding:8px 14px;background:#eff6ff;color:#2563eb;border:1px solid #bfdbfe;border-radius:8px;font-size:.82rem;font-weight:600;text-decoration:none;margin-top:8px}
.pdf-link:hover{background:#dbeafe}
.pdf-link svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2}
</style>
</head>
<body>
@php $stCls = match($atestado->status){ 'aprovado'=>'st-a','reprovado'=>'st-r',default=>'st-p' }; @endphp
<header class="hd">
  <div class="logo">
    <div class="logo-ic">RH</div>
    <div><div class="logo-n">SMART RH</div><div class="logo-s">DETALHE DO ATESTADO</div></div>
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

        @if(session('success'))
        <div class="alert alert-ok">{{ session('success') }}</div>
        @endif

        <!-- Status em destaque -->
        <div class="card" style="padding:20px 22px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px">
            <div>
                <div style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:#6b7280;margin-bottom:6px">Status do Atestado</div>
                <span class="bg {{ $stCls }}" style="font-size:.95rem;padding:7px 20px">{{ $atestado->statusLabel() }}</span>
            </div>
            <div class="acts">
                @if($atual->isGestor() && $atestado->status === 'pendente')
                <form method="POST" action="{{ route('atestados.aprovar', $atestado) }}">@csrf
                    <button type="submit" class="btn btn-apr"><svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>Aprovar</button>
                </form>
                <form method="POST" action="{{ route('atestados.reprovar', $atestado) }}">@csrf
                    <button type="submit" class="btn btn-rep"><svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>Reprovar</button>
                </form>
                @endif
                @if($atestado->status === 'pendente')
                <form method="POST" action="{{ route('atestados.destroy', $atestado) }}" onsubmit="return confirm('Remover este atestado?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-del"><svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>Remover</button>
                </form>
                @endif
                <a href="{{ route('atestados.index') }}" class="btn btn-s"><svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>Voltar</a>
            </div>
        </div>

        <!-- Detalhes -->
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
            <div class="card">
                <div class="ch"><span class="ch-t">Funcionário</span></div>
                <div class="cb">
                    <div class="fd"><span class="fl">Nome</span><span class="fv">{{ $atestado->funcionario->nome }}</span></div>
                    <div class="fd"><span class="fl">Cargo</span><span class="fv">{{ $atestado->funcionario->cargo }}</span></div>
                    <div class="fd"><span class="fl">E-mail</span><span class="fv">{{ $atestado->funcionario->email }}</span></div>
                </div>
            </div>
            <div class="card">
                <div class="ch"><span class="ch-t">Dados do Atestado</span></div>
                <div class="cb">
                    <div class="fd"><span class="fl">Tipo</span><span class="fv">{{ $atestado->tipoLabel() }}</span></div>
                    <div class="fd"><span class="fl">Período</span><span class="fv">{{ $atestado->data_inicio->format('d/m/Y') }} → {{ $atestado->data_fim->format('d/m/Y') }}</span></div>
                    <div class="fd"><span class="fl">Dias de Afastamento</span><span class="fv">{{ $atestado->dias_afastamento }} {{ $atestado->dias_afastamento === 1 ? 'dia' : 'dias' }}</span></div>
                    <div class="fd"><span class="fl">Cobre Horas</span><span class="fv">{{ $atestado->cobre_horas ? 'Sim' : 'Não' }}</span></div>
                    <div class="fd"><span class="fl">Enviado em</span><span class="fv">{{ $atestado->created_at->format('d/m/Y H:i') }}</span></div>
                </div>
            </div>
        </div>

        @if($atestado->observacao)
        <div class="card" style="margin-top:0">
            <div class="ch"><span class="ch-t">Observação</span></div>
            <div class="cb"><span class="fv obs">{{ $atestado->observacao }}</span></div>
        </div>
        @endif

        @if($atestado->arquivo_path)
        @php
            $ext = strtolower(pathinfo($atestado->arquivo_path, PATHINFO_EXTENSION));
            $url = Storage::disk('public')->url($atestado->arquivo_path);
        @endphp
        <div class="card">
            <div class="ch"><span class="ch-t">Arquivo Anexado</span></div>
            <div class="cb">
                @if(in_array($ext, ['jpg','jpeg','png']))
                    <img src="{{ $url }}" alt="Atestado" class="img-preview">
                @else
                    <a href="{{ $url }}" target="_blank" class="pdf-link">
                        <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Abrir PDF
                    </a>
                @endif
            </div>
        </div>
        @endif

    </div>
</body>
</html>


