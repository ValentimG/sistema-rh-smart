<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>{{ $funcionario->nome }} — {{ config('app.name') }}</title>
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
.pg{max-width:1100px;margin:0 auto;padding:32px 24px}
.profile-card{background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:22px 26px;margin-bottom:20px;display:flex;align-items:center;gap:18px}
.pav{width:60px;height:60px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:1.3rem;color:#fff;flex-shrink:0}
.pname{font-size:1.15rem;font-weight:700;color:#111827}
.pcargo{font-size:.82rem;color:#6b7280;margin-top:2px}
.pbadge{display:flex;gap:6px;margin-top:6px}
.badge{display:inline-flex;align-items:center;padding:3px 10px;border-radius:999px;font-size:.7rem;font-weight:700}
.bg-g{background:#ede9fe;color:#5b21b6}.bg-f{background:#f3f4f6;color:#374151}.bg-clt{background:#dbeafe;color:#1e40af}
.pacts{margin-left:auto;display:flex;gap:8px}
.btn{display:inline-flex;align-items:center;gap:5px;padding:8px 15px;border-radius:8px;font-size:.82rem;font-weight:600;text-decoration:none;transition:.15s;border:1px solid transparent;cursor:pointer}
.btn-p{background:#2563eb;color:#fff;border-color:#2563eb}.btn-p:hover{background:#1d4ed8}
.btn-s{background:#fff;color:#374151;border-color:#e5e7eb}.btn-s:hover{background:#f3f4f6}
.btn svg{width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
.grid3{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:20px}
.sec{background:#fff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden}
.sec-h{padding:12px 18px;border-bottom:1px solid #f3f4f6;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:#9ca3af;background:#fafafa}
.fd{padding:11px 18px;border-bottom:1px solid #fafafa;display:flex;flex-direction:column;gap:2px}
.fd:last-child{border-bottom:none}
.fl{font-size:.63rem;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#9ca3af}
.fv{font-size:.83rem;font-weight:500;color:#111827}
.fv-hi{color:#059669;font-weight:700}.fv-em{color:#9ca3af;font-style:italic}.fv-mono{font-variant-numeric:tabular-nums}
.tags{display:flex;flex-wrap:wrap;gap:5px;margin-top:2px}
.tag{background:#eff6ff;color:#2563eb;padding:2px 8px;border-radius:999px;font-size:.68rem;font-weight:600}
/* Tabs */
.tabs-wrap{display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:0}
.tabs{display:flex;gap:2px}
.tab-btn{padding:9px 16px;border:1px solid #e5e7eb;border-bottom:none;border-radius:8px 8px 0 0;font-size:.8rem;font-weight:600;color:#6b7280;background:#f9fafb;cursor:pointer;transition:.15s}
.tab-btn.act{background:#fff;color:#2563eb;border-color:#2563eb;border-bottom-color:#fff;position:relative;z-index:1}
.tab-panel{display:none;background:#fff;border:1px solid #e5e7eb;border-radius:0 8px 8px 8px;overflow:hidden}
.tab-panel.act{display:block}
.tb{width:100%;border-collapse:collapse}
.tb thead th{padding:9px 14px;text-align:left;font-size:.61rem;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:#9ca3af;background:#fafafa;border-bottom:1px solid #f3f4f6;white-space:nowrap}
.tb tbody tr:nth-child(even){background:#fafafa}
.tb tbody tr:hover{background:#f0f4ff}
.tb tbody td{padding:11px 14px;font-size:.82rem;color:#374151;border-bottom:1px solid #f3f4f6}
.tb tbody tr:last-child td{border-bottom:none}
.st-a{background:#dcfce7;color:#15803d}.st-p{background:#fef9c3;color:#a16207}.st-r{background:#fee2e2;color:#991b1b}
.bge{display:inline-flex;padding:2px 9px;border-radius:999px;font-size:.68rem;font-weight:700}
.emp{text-align:center;padding:28px;color:#9ca3af;font-size:.82rem}
.alert{padding:12px 16px;border-radius:8px;font-size:.82rem;font-weight:500;margin-bottom:16px}
.a-ok{background:#dcfce7;color:#15803d;border:1px solid #bbf7d0}
</style>
</head>
<body>
@php
    $ini  = collect(explode(' ',$funcionario->nome))->map(fn($p)=>strtoupper($p[0]))->take(2)->implode('');
    $cores=['#2563eb','#059669','#d97706','#dc2626','#0891b2','#7c3aed'];
    $cor  = $cores[$funcionario->id % count($cores)];
    $mesesTrabalhados ??= $funcionario->data_admissao->diffInMonths(now());
@endphp
<header class="hd">
  <div class="logo">
    <div class="logo-ic">RH</div>
    <div><div class="logo-n">SMART RH</div><div class="logo-s">PERFIL DO FUNCIONARIO</div></div>
  </div>
  <div class="hd-r">
    <nav class="nav">
      <a href="{{ route('gestor.dashboard') }}" class="nl">
        <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>Dashboard
      </a>
      <a href="{{ route('funcionarios.index') }}" class="nl on">
        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>Funcionarios
      </a>
      <a href="{{ route('atestados.index') }}" class="nl">
        <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>Atestados
      </a>
    </nav>
    <div class="av">{{ strtoupper(substr(Auth::user()->name,0,1)) }}</div>
    <form method="POST" action="{{ route('logout') }}">@csrf
      <button type="submit" class="lg-btn">
        <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>Sair
      </button>
    </form>
  </div>
</header>

<main class="pg">
  @if(session('success'))
  <div class="alert a-ok">{{ session('success') }}</div>
  @endif

  <div class="profile-card">
    <div class="pav" style="background:{{ $cor }}">{{ $ini }}</div>
    <div>
      <div class="pname">{{ $funcionario->nome }}</div>
      <div class="pcargo">{{ $funcionario->cargo }}</div>
      <div class="pbadge">
        <span class="badge {{ $funcionario->isGestor()?'bg-g':'bg-f' }}">{{ $funcionario->isGestor()?'Gestor':'Funcionario' }}</span>
        <span class="badge bg-clt">{{ strtoupper($funcionario->tipo_contrato ?? 'CLT') }}</span>
      </div>
    </div>
    <div class="pacts">
      <a href="{{ route('funcionarios.edit',$funcionario) }}" class="btn btn-p">
        <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>Editar
      </a>
      <a href="{{ route('funcionarios.index') }}" class="btn btn-s">
        <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>Voltar
      </a>
    </div>
  </div>

  <div class="grid3">
    <div class="sec">
      <div class="sec-h">Dados Pessoais</div>
      <div class="fd"><span class="fl">E-mail</span><span class="fv">{{ $funcionario->email }}</span></div>
      <div class="fd"><span class="fl">CPF</span><span class="fv fv-mono">{{ $funcionario->cpfFormatado }}</span></div>
      <div class="fd"><span class="fl">Telefone</span><span class="fv">{{ $funcionario->telefone ?? '—' }}</span></div>
      <div class="fd"><span class="fl">Nascimento</span><span class="fv">{{ $funcionario->data_nascimento?->format('d/m/Y') ?? '—' }}</span></div>
      <div class="fd"><span class="fl">Sexo</span><span class="fv">{{ ucfirst(str_replace('_',' ',$funcionario->sexo ?? '—')) }}</span></div>
      <div class="fd"><span class="fl">Estado Civil</span><span class="fv">{{ ucfirst(str_replace('_',' ',$funcionario->estado_civil ?? '—')) }}</span></div>
      <div class="fd"><span class="fl">Endereco</span><span class="fv">{{ $funcionario->endereco }}</span></div>
    </div>
    <div class="sec">
      <div class="sec-h">Contrato</div>
      <div class="fd"><span class="fl">Tipo de Contrato</span><span class="fv">{{ $funcionario->tipoContratoLabel() }}</span></div>
      <div class="fd"><span class="fl">Admissao</span><span class="fv">{{ $funcionario->data_admissao->format('d/m/Y') }}</span></div>
      <div class="fd"><span class="fl">Tempo de Casa</span><span class="fv">{{ $funcionario->data_admissao->diffForHumans(null,true) }}</span></div>
      <div class="fd">
        <span class="fl">Beneficios</span>
        @if($funcionario->beneficios)
          <div class="tags">@foreach($funcionario->beneficios as $b)<span class="tag">{{ $b }}</span>@endforeach</div>
        @else<span class="fv fv-em">Nao informado</span>@endif
      </div>
      <div class="fd">
        <span class="fl">Exame Admissional</span>
        <span class="fv">{{ $funcionario->exame_admissional_data?->format('d/m/Y') ?? '—' }}{{ $funcionario->exame_admissional_resultado ? ' — '.$funcionario->exame_admissional_resultado : '' }}</span>
      </div>
    </div>
    <div class="sec">
      <div class="sec-h">Remuneracao</div>
      <div class="fd"><span class="fl">Salario Base</span><span class="fv fv-hi">{{ $funcionario->salario_base ? 'R$ '.number_format($funcionario->salario_base,2,',','.') : '—' }}</span></div>
      <div class="fd"><span class="fl">Valor por Hora</span><span class="fv fv-mono">{{ $funcionario->salario_base ? 'R$ '.number_format($funcionario->valorHora(),2,',','.') : '—' }}</span></div>
      <div class="fd"><span class="fl">Carga Horaria Mensal</span><span class="fv">{{ $funcionario->carga_horaria_mensal }}h</span></div>
      <div class="fd"><span class="fl">Banco de Horas</span><span class="fv fv-mono">{{ number_format($funcionario->banco_horas,2,',','.') }}h</span></div>
      <div class="fd"><span class="fl">13 Proporcional</span><span class="fv fv-hi">{{ $funcionario->salario_base ? 'R$ '.number_format($funcionario->estimativaDecimoTerceiro($mesesTrabalhados),2,',','.') : '—' }}</span></div>
      <div class="fd"><span class="fl">Dias de Afastamento</span><span class="fv">{{ $funcionario->diasTotaisAfastamento() }}d no total</span></div>
    </div>
  </div>

  <!-- Abas -->
  <div class="tabs-wrap">
    <div class="tabs">
      <button class="tab-btn act" onclick="showTab('atestados',this)">
        Atestados@if($funcionario->atestadosPendentes()->count() > 0)<span style="background:#f59e0b;color:#fff;border-radius:999px;padding:1px 7px;font-size:.63rem;margin-left:5px">{{ $funcionario->atestadosPendentes()->count() }}</span>@endif
      </button>
      <button class="tab-btn" onclick="showTab('cargos',this)">Historico de Cargos</button>
      <button class="tab-btn" onclick="showTab('afastamentos',this)">Afastamentos</button>
    </div>
    <a href="{{ route('atestados.create',['funcionario_id'=>$funcionario->id]) }}" class="btn btn-p" style="margin-bottom:1px">
      <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>Novo Atestado
    </a>
  </div>

  <div id="tab-atestados" class="tab-panel act">
    <table class="tb"><thead><tr>
      <th>Tipo</th><th>Periodo</th><th style="text-align:center">Dias</th><th style="text-align:center">Cobre Horas</th><th style="text-align:center">Status</th><th></th>
    </tr></thead><tbody>
      @forelse($funcionario->atestados as $a)
      <tr>
        <td>{{ $a->tipoLabel() }}</td>
        <td style="font-variant-numeric:tabular-nums;font-size:.78rem">{{ $a->data_inicio->format('d/m/Y') }}@if(!$a->data_inicio->equalTo($a->data_fim)) → {{ $a->data_fim->format('d/m/Y') }}@endif</td>
        <td style="text-align:center">{{ $a->dias_afastamento }}d</td>
        <td style="text-align:center"><span class="bge" style="{{ $a->cobre_horas?'background:#dbeafe;color:#1e40af':'background:#f3f4f6;color:#6b7280' }}">{{ $a->cobre_horas?'Sim':'Nao' }}</span></td>
        <td style="text-align:center"><span class="bge {{ match($a->status){'aprovado'=>'st-a','reprovado'=>'st-r',default=>'st-p'} }}">{{ $a->statusLabel() }}</span></td>
        <td style="text-align:right;padding-right:14px"><a href="{{ route('atestados.show',$a) }}" style="color:#2563eb;font-size:.75rem;font-weight:600;text-decoration:none">Ver</a></td>
      </tr>
      @empty<tr><td colspan="6" class="emp">Nenhum atestado registrado.</td></tr>
      @endforelse
    </tbody></table>
  </div>

  <div id="tab-cargos" class="tab-panel">
    <table class="tb"><thead><tr>
      <th>Cargo</th><th>Inicio</th><th>Fim</th><th>Motivo</th><th style="text-align:center">Situacao</th>
    </tr></thead><tbody>
      @forelse($funcionario->historicoCargos as $hc)
      <tr>
        <td style="font-weight:600">{{ $hc->cargo }}</td>
        <td>{{ $hc->data_inicio->format('d/m/Y') }}</td>
        <td>{{ $hc->data_fim?->format('d/m/Y') ?? '—' }}</td>
        <td>{{ $hc->motivo ?? '—' }}</td>
        <td style="text-align:center"><span class="bge {{ $hc->isAtual()?'st-a':'st-p' }}">{{ $hc->isAtual()?'Atual':'Encerrado' }}</span></td>
      </tr>
      @empty<tr><td colspan="5" class="emp">Nenhum historico de cargo.</td></tr>
      @endforelse
    </tbody></table>
  </div>

  <div id="tab-afastamentos" class="tab-panel">
    <table class="tb"><thead><tr>
      <th>Tipo</th><th>Inicio</th><th>Fim</th><th style="text-align:center">Dias</th><th>Observacao</th>
    </tr></thead><tbody>
      @forelse($funcionario->historicoAfastamentos as $af)
      <tr>
        <td>{{ $af->tipoLabel() }}</td>
        <td>{{ $af->data_inicio->format('d/m/Y') }}</td>
        <td>{{ $af->data_fim->format('d/m/Y') }}</td>
        <td style="text-align:center">{{ $af->dias }}d</td>
        <td>{{ $af->observacao ?? '—' }}</td>
      </tr>
      @empty<tr><td colspan="5" class="emp">Nenhum afastamento registrado.</td></tr>
      @endforelse
    </tbody></table>
  </div>
</main>

<script>
function showTab(id,btn){
    document.querySelectorAll('.tab-panel').forEach(p=>p.classList.remove('act'));
    document.querySelectorAll('.tab-btn').forEach(b=>b.classList.remove('act'));
    document.getElementById('tab-'+id).classList.add('act');
    btn.classList.add('act');
}
</script>
</body>
</html>
