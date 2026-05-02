<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Funcionarios — {{ config('app.name') }}</title>
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
.stats{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:24px}
.stat{background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:20px 22px;transition:.2s}
.stat:hover{box-shadow:0 2px 8px rgba(0,0,0,.06)}
.stat-lb{font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:#9ca3af;margin-bottom:6px}
.stat-v{font-size:1.9rem;font-weight:700;line-height:1;margin-bottom:4px}
.stat-s{font-size:.72rem;color:#9ca3af}
.v-blue{color:#2563eb}.v-green{color:#059669}.v-amber{color:#d97706}
.toolbar{display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;gap:12px}
.sw{position:relative;flex:1;max-width:320px}
.sw svg{position:absolute;left:10px;top:50%;transform:translateY(-50%);width:14px;height:14px;stroke:#9ca3af;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
.si{width:100%;padding:8px 12px 8px 34px;border:1px solid #e5e7eb;border-radius:8px;font-size:.82rem;color:#111827;outline:none;transition:.15s}
.si:focus{border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.08)}
.btn-p{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:#2563eb;color:#fff;border:none;border-radius:8px;font-size:.82rem;font-weight:600;cursor:pointer;text-decoration:none;transition:.2s}
.btn-p:hover{background:#1d4ed8}
.btn-p svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2.5;stroke-linecap:round;stroke-linejoin:round}
.card{background:#fff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;transition:.2s}
.card:hover{box-shadow:0 2px 8px rgba(0,0,0,.06)}
.tb{width:100%;border-collapse:collapse}
.tb thead th{padding:10px 14px;text-align:left;font-size:.61rem;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:#9ca3af;background:#fafafa;border-bottom:1px solid #f3f4f6;white-space:nowrap}
.tb tbody tr:nth-child(even){background:#fafafa}
.tb tbody tr:hover{background:#f0f4ff}
.tb tbody td{padding:13px 14px;font-size:.82rem;color:#374151;border-bottom:1px solid #f3f4f6}
.tb tbody tr:last-child td{border-bottom:none}
.fav{width:34px;height:34px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.75rem;color:#fff;flex-shrink:0}
.fn{font-weight:600;color:#111827;font-size:.82rem}.fc{color:#9ca3af;font-size:.7rem;margin-top:1px}
.badge{display:inline-flex;align-items:center;padding:2px 9px;border-radius:999px;font-size:.68rem;font-weight:700}
.bg-g{background:#ede9fe;color:#5b21b6}.bg-f{background:#f3f4f6;color:#374151}
.mono{font-variant-numeric:tabular-nums;font-size:.82rem}
.acts{display:flex;align-items:center;gap:6px}
.ba{display:inline-flex;align-items:center;gap:4px;padding:5px 10px;border-radius:6px;font-size:.72rem;font-weight:600;text-decoration:none;transition:.15s;border:1px solid transparent;background:none;cursor:pointer}
.ba-s{color:#2563eb;border-color:#bfdbfe;background:#eff6ff}.ba-s:hover{background:#dbeafe}
.ba-e{color:#374151;border-color:#e5e7eb;background:#fff}.ba-e:hover{background:#f3f4f6}
.ba-d{color:#dc2626;border-color:#fecaca;background:#fff}.ba-d:hover{background:#fee2e2}
.ba svg{width:12px;height:12px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
.alert{padding:12px 16px;border-radius:8px;font-size:.82rem;font-weight:500;margin-bottom:18px}
.a-ok{background:#dcfce7;color:#15803d;border:1px solid #bbf7d0}
</style>
</head>
<body>
@include('layouts.header')

<main class="pg">
  @if(session('success'))
  <div class="alert a-ok">{{ session('success') }}</div>
  @endif

  <div class="stats">
    <div class="stat"><div class="stat-lb">Total de Funcionarios</div><div class="stat-v v-blue">{{ $funcionarios->total() }}</div><div class="stat-s">cadastrados no sistema</div></div>
    <div class="stat"><div class="stat-lb">Folha Mensal</div><div class="stat-v v-green" style="font-size:1.4rem">R$&nbsp;{{ number_format($totalFolha,2,',','.') }}</div><div class="stat-s">soma dos salarios base</div></div>
    <div class="stat"><div class="stat-lb">Media Salarial</div><div class="stat-v v-amber" style="font-size:1.4rem">R$&nbsp;{{ number_format($mediaSalario,2,',','.') }}</div><div class="stat-s">por funcionario</div></div>
  </div>

  <div class="toolbar">
    <div class="sw">
      <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      <input type="text" id="busca" class="si" placeholder="Buscar por nome ou cargo...">
    </div>
    <a href="{{ route('funcionarios.create') }}" class="btn-p">
      <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>Novo Funcionario
    </a>
  </div>

  <div class="card">
    <div style="overflow-x:auto">
      <table class="tb" id="tabela">
        <thead><tr>
          <th>Funcionario</th>
          <th>Tipo</th>
          <th>Salario Base</th>
          <th>Admissao</th>
          <th>Acoes</th>
        </tr></thead>
        <tbody>
          @forelse($funcionarios as $f)
          @php
            $ini = collect(explode(' ',$f->nome))->map(fn($p)=>strtoupper($p[0]))->take(2)->implode('');
            $cores=['#2563eb','#059669','#d97706','#dc2626','#0891b2','#7c3aed'];
            $cor=$cores[$f->id % count($cores)];
          @endphp
          <tr class="func-row">
            <td>
              <div style="display:flex;align-items:center;gap:10px">
                <div class="fav" style="background:{{ $cor }}">{{ $ini }}</div>
                <div><div class="fn">{{ $f->nome }}</div><div class="fc">{{ $f->cargo }}</div></div>
              </div>
            </td>
            <td><span class="badge {{ $f->isGestor()?'bg-g':'bg-f' }}">{{ $f->isGestor()?'Gestor':'Funcionario' }}</span></td>
            <td class="mono">{{ $f->salario_base ? 'R$ '.number_format($f->salario_base,2,',','.') : '—' }}</td>
            <td style="font-size:.82rem">{{ $f->data_admissao->format('d/m/Y') }}</td>
            <td>
              <div class="acts">
                <a href="{{ route('funcionarios.show',$f) }}" class="ba ba-s">
                  <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>Ver
                </a>
                <a href="{{ route('funcionarios.edit',$f) }}" class="ba ba-e">
                  <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>Editar
                </a>
                <form method="POST" action="{{ route('funcionarios.destroy',$f) }}" onsubmit="return confirm('Remover {{ $f->nome }}?')" style="display:inline">
                  @csrf @method('DELETE')
                  <button type="submit" class="ba ba-d">
                    <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>Remover
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="5" style="text-align:center;padding:32px;color:#9ca3af">Nenhum funcionario cadastrado.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if($funcionarios->hasPages())
    <div style="padding:14px 16px;border-top:1px solid #f3f4f6">{{ $funcionarios->links() }}</div>
    @endif
  </div>
</main>

<script>
document.getElementById('busca').addEventListener('input',function(){
    const t=this.value.toLowerCase();
    document.querySelectorAll('.func-row').forEach(tr=>{
        tr.style.display=tr.textContent.toLowerCase().includes(t)?'':'none';
    });
});
</script>
</body>
</html>
