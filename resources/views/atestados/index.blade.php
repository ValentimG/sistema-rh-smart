<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Atestados — SMART RH</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0;font-family:'Inter',sans-serif}
body{background:#fff;color:#111827;min-height:100vh}
.hd{background:#fff;border-bottom:1px solid #e5e7eb;padding:0 40px;height:60px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:100}
.logo{display:flex;align-items:center;gap:10px}
.logo-ic{width:32px;height:32px;background:#2563eb;border-radius:7px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:900;font-size:.72rem}
.logo-n{font-size:.9rem;font-weight:700;color:#111827}
.logo-s{font-size:.58rem;color:#9ca3af;font-weight:500}
.hd-r{display:flex;align-items:center;gap:12px}
.nav{display:flex;gap:2px}
.nl{display:flex;align-items:center;gap:6px;padding:7px 13px;border-radius:7px;color:#6b7280;text-decoration:none;font-size:.8rem;font-weight:500;transition:.15s}
.nl:hover,.nl.on{background:#eff6ff;color:#2563eb}
.nl svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
.av{width:34px;height:34px;background:#2563eb;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.78rem;flex-shrink:0}
.lg-btn{display:flex;align-items:center;gap:6px;padding:7px 13px;border-radius:7px;color:#9ca3af;font-size:.8rem;font-weight:500;background:none;border:none;cursor:pointer;transition:.15s}
.lg-btn:hover{background:#f3f4f6;color:#374151}
.lg-btn svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
.pg{max-width:880px;margin:0 auto;padding:40px 24px}
.sec-t{font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:#9ca3af;margin-bottom:14px}
.card{background:#fff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;margin-bottom:20px}
.card-h{padding:16px 20px;border-bottom:1px solid #f3f4f6;display:flex;align-items:center;justify-content:space-between}
.card-tt{font-size:.87rem;font-weight:600;color:#111827}
.btn{display:inline-flex;align-items:center;gap:5px;padding:8px 14px;border-radius:7px;font-size:.78rem;font-weight:600;text-decoration:none;cursor:pointer;transition:.15s;border:none}
.btn-p{background:#2563eb;color:#fff}
.btn-p:hover{background:#1d4ed8}
.btn-p svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2.5}
.filter-row{display:flex;gap:8px;flex-wrap:wrap}
.filter-btn{padding:6px 14px;border-radius:999px;font-size:.75rem;font-weight:600;text-decoration:none;border:1px solid #e5e7eb;background:#fff;color:#374151;cursor:pointer;transition:.15s}
.filter-btn:hover,.filter-btn.on{background:#2563eb;color:#fff;border-color:#2563eb}
table{width:100%;border-collapse:collapse}
thead th{padding:10px 16px;text-align:left;font-size:.61rem;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:#9ca3af;background:#fafafa;border-bottom:1px solid #f3f4f6;white-space:nowrap}
tbody tr:hover{background:#f9fafb}
tbody td{padding:12px 16px;font-size:.82rem;color:#374151;border-bottom:1px solid #f3f4f6}
tbody tr:last-child td{border-bottom:none}
.bg{display:inline-flex;padding:3px 10px;border-radius:999px;font-size:.7rem;font-weight:700}
.st-a{background:#dcfce7;color:#15803d}
.st-p{background:#fef9c3;color:#a16207}
.st-r{background:#fee2e2;color:#dc2626}
.act-btns{display:flex;gap:5px;flex-wrap:wrap}
.btn-sm{display:inline-flex;align-items:center;gap:3px;padding:4px 9px;border-radius:6px;font-size:.7rem;font-weight:600;text-decoration:none;border:1px solid;cursor:pointer;transition:.15s}
.btn-see{color:#2563eb;border-color:#bfdbfe;background:#eff6ff}
.btn-see:hover{background:#dbeafe}
.btn-apr{color:#065f46;border-color:#a7f3d0;background:#d1fae5}
.btn-apr:hover{background:#a7f3d0}
.btn-rep{color:#991b1b;border-color:#fecaca;background:#fee2e2}
.btn-rep:hover{background:#fecaca}
.btn-del{color:#6b7280;border-color:#e5e7eb;background:#fff}
.btn-del:hover{background:#f3f4f6;color:#dc2626}
.btn-sm svg{width:11px;height:11px;stroke:currentColor;fill:none;stroke-width:2}
.fn{font-weight:600;color:#111827;font-size:.82rem}
.fc{color:#9ca3af;font-size:.7rem;margin-top:1px}
.empty{text-align:center;padding:32px;color:#9ca3af;font-size:.82rem}
.alert{padding:12px 16px;border-radius:8px;font-size:.82rem;font-weight:500;margin-bottom:18px}
.alert-ok{background:#dcfce7;color:#065f46;border:1px solid:#a7f3d0}
.alert-err{background:#fee2e2;color:#991b1b;border:1px solid:#fecaca}
</style>
</head>
<body>
@include('layouts.header')
<main class="pg">
  @if(session('success'))
  <div class="alert alert-ok">{{ session('success') }}</div>
  @endif
  @if(session('error'))
  <div class="alert alert-err">{{ session('error') }}</div>
  @endif

  <div class="sec-t">ATESTADOS</div>
  <div class="card">
    <div class="card-h">
      <div class="filter-row">
        <a href="{{ route('atestados.index') }}" class="filter-btn {{ !request('status') ? 'on' : '' }}">Todos</a>
        <a href="?status=pendente" class="filter-btn {{ request('status')=='pendente' ? 'on' : '' }}">Pendentes</a>
        <a href="?status=aprovado" class="filter-btn {{ request('status')=='aprovado' ? 'on' : '' }}">Aprovados</a>
        <a href="?status=reprovado" class="filter-btn {{ request('status')=='reprovado' ? 'on' : '' }}">Reprovados</a>
      </div>
      <a href="{{ route('atestados.create') }}" class="btn btn-p">
        <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Novo Atestado
      </a>
    </div>
    <div style="overflow-x:auto">
      <table>
        <thead><tr>
          @if($atual->isGestor())<th>FUNCIONÁRIO</th>@endif
          <th>TIPO</th>
          <th>PERÍODO</th>
          <th style="text-align:center">DIAS</th>
          <th style="text-align:center">COBRE HORAS</th>
          <th style="text-align:center">STATUS</th>
          <th>AÇÕES</th>
        </tr></thead>
        <tbody>
          @forelse($atestados as $a)
          <tr>
            @if($atual->isGestor())
            <td><div class="fn">{{ $a->funcionario->nome }}</div><div class="fc">{{ $a->funcionario->cargo }}</div></td>
            @endif
            <td>{{ $a->tipoLabel() }}</td>
            <td style="font-family:monospace;font-size:.8rem">{{ $a->data_inicio->format('d/m/Y') }}{{ !$a->data_inicio->equalTo($a->data_fim) ? ' → '.$a->data_fim->format('d/m/Y') : '' }}</td>
            <td style="text-align:center">{{ $a->dias_afastamento }}d</td>
            <td style="text-align:center"><span class="bg" style="{{ $a->cobre_horas ? 'background:#dbeafe;color:#1e40af' : 'background:#f3f4f6;color:#6b7280' }}">{{ $a->cobre_horas ? 'Sim' : 'Não' }}</span></td>
            <td style="text-align:center"><span class="bg {{ $a->status=='aprovado' ? 'st-a' : ($a->status=='reprovado' ? 'st-r' : 'st-p') }}">{{ $a->statusLabel() }}</span></td>
            <td>
              <div class="act-btns">
                <a href="{{ route('atestados.show', $a) }}" class="btn-sm btn-see">
                  <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>Ver
                </a>
                @if($atual->isGestor() && $a->status=='pendente')
                <form method="POST" action="{{ route('atestados.aprovar', $a) }}" style="display:inline">@csrf
                  <button class="btn-sm btn-apr"><svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>Aprovar</button>
                </form>
                <form method="POST" action="{{ route('atestados.reprovar', $a) }}" style="display:inline">@csrf
                  <button class="btn-sm btn-rep"><svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>Reprovar</button>
                </form>
                @endif
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="{{ $atual->isGestor() ? 7 : 6 }}" class="empty">Nenhum atestado encontrado.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</main>
</body>
</html>