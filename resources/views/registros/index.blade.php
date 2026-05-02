<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Controle de Ponto — {{ config('app.name') }}</title>
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
.clk-sec{text-align:center;padding:36px 0 32px;border-bottom:1px solid #f3f4f6;margin-bottom:32px}
.clk-t{font-size:3.8rem;font-weight:700;color:#111827;letter-spacing:4px;line-height:1;margin-bottom:8px;font-variant-numeric:tabular-nums}
.clk-d{font-size:.9rem;color:#9ca3af;font-weight:400;text-transform:capitalize}
.strip{display:grid;grid-template-columns:repeat(4,1fr);gap:1px;background:#e5e7eb;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;margin-bottom:24px}
.sc{background:#fff;padding:16px;text-align:center}
.sc.ok{background:#f0fdf4}
.sc-lb{font-size:.6rem;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:#9ca3af;margin-bottom:6px}
.sc-t{font-size:1.35rem;font-weight:700;color:#d1d5db;font-variant-numeric:tabular-nums}
.sc-t.f{color:#111827}.sc-t.g{color:#059669}
.acts{display:grid;grid-template-columns:repeat(2,1fr);gap:12px;margin-bottom:32px}
.ac{background:#fff;border:1.5px solid #e5e7eb;border-radius:10px;padding:18px 20px;cursor:pointer;display:flex;align-items:center;gap:14px;transition:.15s;text-align:left;width:100%;font-family:inherit}
.ac:hover:not(:disabled):not(.off){border-color:#2563eb;background:#eff6ff}
.ac:disabled,.ac.off{opacity:.5;cursor:not-allowed;pointer-events:none}
.ac.dn{border-color:#bbf7d0;background:#f0fdf4}
.ac-ic{width:40px;height:40px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.ac-ic svg{width:18px;height:18px;stroke:currentColor;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}
.ie{background:#dcfce7;color:#16a34a}.ia{background:#ffedd5;color:#ea580c}
.iv{background:#dbeafe;color:#2563eb}.is{background:#fee2e2;color:#dc2626}
.iok{background:#dcfce7;color:#16a34a}.iof{background:#f3f4f6;color:#d1d5db}
.ac-tt{font-size:.87rem;font-weight:600;color:#111827;white-space:nowrap}
.ac.off .ac-tt,.ac:disabled .ac-tt{color:#9ca3af}
.ac.dn .ac-tt{color:#065f46}
.ac-st{font-size:.74rem;color:#6b7280;margin-top:2px}
.ac.dn .ac-st{color:#16a34a}
.dn-ban{background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:14px 20px;margin-bottom:28px;display:flex;align-items:center;gap:12px}
.dn-ban svg{width:18px;height:18px;stroke:#16a34a;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;flex-shrink:0}
.dn-t{font-size:.87rem;font-weight:600;color:#14532d}
.dn-s{font-size:.77rem;color:#166534;margin-top:2px}
.sec-t{font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:#9ca3af;margin-bottom:14px}
.ch-row{display:grid;grid-template-columns:1fr 170px;gap:14px;margin-bottom:32px}
.card{background:#fff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden}
.cb{padding:20px}
.ct{font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:#9ca3af;margin-bottom:14px}
.bnc{text-align:center}
.bnc-v{font-size:2.2rem;font-weight:700;font-variant-numeric:tabular-nums;line-height:1;margin-bottom:4px}
.bnc-v.pos{color:#059669}.bnc-v.neg{color:#dc2626}
.bnc-l{font-size:.72rem;color:#9ca3af;margin-bottom:10px}
.tb{width:100%;border-collapse:collapse}
.tb thead th{padding:10px 16px;text-align:left;font-size:.61rem;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:#9ca3af;background:#fafafa;border-bottom:1px solid #f3f4f6;white-space:nowrap}
.tb tbody tr:nth-child(even){background:#fafafa}
.tb tbody tr:hover{background:#f3f4f6}
.tb tbody td{padding:12px 16px;font-size:.82rem;color:#374151;border-bottom:1px solid #f3f4f6}
.tb tbody tr:last-child td{border-bottom:none}
.tc{text-align:center;font-variant-numeric:tabular-nums}
.tm{text-align:center;color:#d1d5db}
.bw{display:inline-flex;padding:2px 9px;border-radius:999px;font-size:.67rem;font-weight:700}
.bk{background:#dcfce7;color:#15803d}.bwn{background:#fef9c3;color:#a16207}
#toast-root{position:fixed;top:18px;right:18px;z-index:9999;display:flex;flex-direction:column;gap:8px}
.toast{padding:12px 18px;border-radius:8px;font-size:.82rem;font-weight:600;color:#fff;box-shadow:0 4px 14px rgba(0,0,0,.15);max-width:300px}
.tok{background:#059669}.terr{background:#dc2626}
</style>
</head>
<body>
@include('layouts.header')
<main class="pg">
  <div class="clk-sec">
    <div class="clk-t" id="clock">--:--:--</div>
    <div class="clk-d" id="clock-date"></div>
  </div>

  @if($hoje->saida)
  <div class="dn-ban">
    <svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
    <div>
      <div class="dn-t">Jornada encerrada</div>
      <div class="dn-s">TOTAL trabalhado: {{ $hoje->horasTrabalhadasFormatado() }}</div>
    </div>
  </div>
  @endif

  <div class="strip">
    <div class="sc {{ $hoje->entrada ? 'ok' : '' }}">
      <div class="sc-lb">entrada</div>
      <div id="hora-entrada" class="sc-t {{ $hoje->entrada ? 'g' : '' }}">{{ $hoje->entrada ? $hoje->entrada->format('H:i') : '--:--' }}</div>
    </div>
    <div class="sc {{ $hoje->saida_almoco ? 'ok' : '' }}">
      <div class="sc-lb">saida almoco</div>
      <div id="hora-saida-almoco" class="sc-t {{ $hoje->saida_almoco ? 'f' : '' }}">{{ $hoje->saida_almoco ? $hoje->saida_almoco->format('H:i') : '--:--' }}</div>
    </div>
    <div class="sc {{ $hoje->volta_almoco ? 'ok' : '' }}">
      <div class="sc-lb">VOLTA almoco</div>
      <div id="hora-volta-almoco" class="sc-t {{ $hoje->volta_almoco ? 'f' : '' }}">{{ $hoje->volta_almoco ? $hoje->volta_almoco->format('H:i') : '--:--' }}</div>
    </div>
    <div class="sc {{ $hoje->saida ? 'ok' : '' }}">
      <div class="sc-lb">saida</div>
      <div id="hora-saida" class="sc-t {{ $hoje->saida ? 'f' : '' }}">{{ $hoje->saida ? $hoje->saida->format('H:i') : '--:--' }}</div>
    </div>
  </div>

  @unless($hoje->saida)
  <div class="acts">
    @if(!$hoje->entrada)
    <button class="ac" data-url="{{ route('ponto.entrada') }}" data-span="hora-entrada" data-cls="g">
      <div class="ac-ic ie"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
      <div><div class="ac-tt">Registrar entrada</div><div class="ac-st">Iniciar jornada</div></div>
    </button>
    @else
    <div class="ac dn"><div class="ac-ic iok"><svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg></div><div><div class="ac-tt">entrada Registrada</div><div class="ac-st">{{ $hoje->entrada->format('H:i') }}</div></div></div>
    @endif

    @if($hoje->entrada && !$hoje->saida_almoco)
    <button class="ac" data-url="{{ route('ponto.saida-almoco') }}" data-span="hora-saida-almoco" data-cls="f">
      <div class="ac-ic ia"><svg viewBox="0 0 24 24"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/></svg></div>
      <div><div class="ac-tt">saida para almoco</div><div class="ac-st">Pausa para refeicao</div></div>
    </button>
    @elseif($hoje->saida_almoco)
    <div class="ac dn"><div class="ac-ic iok"><svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg></div><div><div class="ac-tt">saida Registrada</div><div class="ac-st">{{ $hoje->saida_almoco->format('H:i') }}</div></div></div>
    @else
    <div class="ac off"><div class="ac-ic iof"><svg viewBox="0 0 24 24"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/></svg></div><div><div class="ac-tt">saida para almoco</div><div class="ac-st">Aguardando entrada</div></div></div>
    @endif

    @if($hoje->saida_almoco && !$hoje->volta_almoco)
    <button class="ac" data-url="{{ route('ponto.volta-almoco') }}" data-span="hora-volta-almoco" data-cls="f">
      <div class="ac-ic iv"><svg viewBox="0 0 24 24"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg></div>
      <div><div class="ac-tt">Volta do almoco</div><div class="ac-st">Retornar ao trabalho</div></div>
    </button>
    @elseif($hoje->volta_almoco)
    <div class="ac dn"><div class="ac-ic iok"><svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg></div><div><div class="ac-tt">Volta Registrada</div><div class="ac-st">{{ $hoje->volta_almoco->format('H:i') }}</div></div></div>
    @else
    <div class="ac off"><div class="ac-ic iof"><svg viewBox="0 0 24 24"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg></div><div><div class="ac-tt">Volta do almoco</div><div class="ac-st">Aguardando saida almoco</div></div></div>
    @endif

    @if($hoje->entrada && !$hoje->saida && (!$hoje->saida_almoco || $hoje->volta_almoco))
    <button class="ac" data-url="{{ route('ponto.saida') }}" data-span="hora-saida" data-cls="f">
      <div class="ac-ic is"><svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg></div>
      <div><div class="ac-tt">Registrar saida</div><div class="ac-st">Encerrar jornada</div></div>
    </button>
    @else
    <div class="ac off"><div class="ac-ic iof"><svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg></div><div><div class="ac-tt">Registrar saida</div><div class="ac-st">Aguardando etapa anterior</div></div></div>
    @endif
  </div>
  @endunless

  <div class="sec-t">RESUMO DA SEMANA</div>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <div class="ch-row">
    <div class="card"><div class="cb">
      <div class="ct">HORAS TRABALHADAS - ÚLTIMOS 7 DIAS</div>
      <div style="position:relative;height:180px"><canvas id="chart-dias"></canvas></div>
    </div></div>
    <div class="card"><div class="cb bnc">
      <div class="ct">BANCO DE HORAS</div>
      <div class="bnc-v {{ $bancoHoras >= 0 ? 'pos' : 'neg' }}">{{ ($bancoHoras >= 0 ? '+' : '') . number_format($bancoHoras,1,',','.') }}h</div>
      <div class="bnc-l">{{ $bancoHoras >= 0 ? 'Banco em dia' : 'Banco negativo' }}</div>
      @if($hoje->saida)
      <div style="font-size:.78rem;color:#6b7280;margin-top:8px;border-top:1px solid #f3f4f6;padding-top:8px">
        <div style="color:#9ca3af;font-size:.62rem;text-transform:uppercase;letter-spacing:.6px;margin-bottom:3px">Hoje</div>
        {{ $hoje->horasTrabalhadasFormatado() }}
      </div>
      @elseif($hoje->entrada)
      <div style="font-size:.75rem;color:#9ca3af;margin-top:8px">Em andamento</div>
      @endif
    </div></div>
  </div>

  <div class="sec-t">HISTÓRICO - ÚLTIMOS 7 DIAS</div>
  <div class="card">
    <div style="overflow-x:auto">
      <table class="tb">
        <thead><tr>
          <th>DATA</th>
          <th style="text-align:center">entrada</th>
          <th style="text-align:center">saida almoco</th>
          <th style="text-align:center">VOLTA almoco</th>
          <th style="text-align:center">saida</th>
          <th style="text-align:right;padding-right:20px">TOTAL</th>
        </tr></thead>
        <tbody>
          @forelse($historico as $r)
          @php $ds=['Domingo','Segunda','Terca','Quarta','Quinta','Sexta','Sabado']; @endphp
          <tr>
            <td><span style="font-weight:600">{{ $r->data->format('d/m/Y') }}</span> <span style="color:#9ca3af;font-size:.72rem">{{ $ds[$r->data->dayOfWeek] }}</span></td>
            <td class="tc">{{ $r->entrada ? $r->entrada->format('H:i') : '&mdash;' }}</td>
            <td class="tc">{{ $r->saida_almoco ? $r->saida_almoco->format('H:i') : '&mdash;' }}</td>
            <td class="tc">{{ $r->volta_almoco ? $r->volta_almoco->format('H:i') : '&mdash;' }}</td>
            <td class="tc">{{ $r->saida ? $r->saida->format('H:i') : '&mdash;' }}</td>
            <td style="text-align:right;padding-right:20px">
              @if($r->horasTrabalhadas() > 0)
                @php $h=(int)$r->horasTrabalhadas(); $m=(int)round(($r->horasTrabalhadas()-$h)*60); @endphp
                <span class="bw {{ $r->horasTrabalhadas()>=8 ? 'bk' : 'bwn' }}">{{ $h }}h{{ $m>0 ? " {$m}min" : '' }}</span>
              @else
                <span style="color:#d1d5db">&mdash;</span>
              @endif
            </td>
          </tr>
          @empty
          <tr><td colspan="6" style="text-align:center;padding:28px;color:#9ca3af;font-size:.82rem">Nenhum registro nos ÚLTIMOS 7 DIAS.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</main>
<div id="toast-root"></div>
<script>
const DS=['Domingo','Segunda-feira','Terca-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado'];
const MS=['janeiro','fevereiro','marco','abril','maio','junho','julho','agosto','setembro','outubro','novembro','dezembro'];
(function tick(){
  const d=new Date(),p=function(n){return String(n).padStart(2,'0');};
  const el=document.getElementById('clock');
  if(el) el.textContent=p(d.getHours())+':'+p(d.getMinutes())+':'+p(d.getSeconds());
  const dd=document.getElementById('clock-date');
  if(dd) dd.textContent=DS[d.getDay()]+', '+d.getDate()+' de '+MS[d.getMonth()]+' de '+d.getFullYear();
  setTimeout(tick,1000);
})();
document.addEventListener('DOMContentLoaded',function(){
  document.querySelectorAll('button.ac[data-url]').forEach(function(btn){
    btn.addEventListener('click',function(){ baterPonto(btn.dataset.url,btn.dataset.span,btn.dataset.cls); });
  });
});
function toast(msg,tipo){
  const r=document.getElementById('toast-root');
  const t=document.createElement('div');
  t.className='toast '+(tipo==='ok'?'tok':'terr');
  t.textContent=msg;
  r.appendChild(t);
  setTimeout(function(){t.remove();},4000);
}
async function baterPonto(url,spanId,cls){
  const btns=document.querySelectorAll('button.ac');
  btns.forEach(function(b){b.disabled=true;});
  const csrf=document.querySelector('meta[name="csrf-token"]');
  if(!csrf){ toast('CSRF token nao encontrado.','err'); btns.forEach(function(b){b.disabled=false;}); return; }
  try{
    const res=await fetch(url,{method:'POST',headers:{'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':csrf.content}});
    const data=await res.json();
    if(data.sucesso){
      toast(data.mensagem,'ok');
      const el=document.getElementById(spanId);
      if(el&&data.horario){ el.textContent=data.horario; el.className='sc-t '+(cls||'f'); }
      setTimeout(function(){window.location.reload();},1500);
    } else {
      toast(data.mensagem||'Operacao nao permitida.','err');
      btns.forEach(function(b){b.disabled=false;});
    }
  } catch(e){
    toast('Erro de conexao. Tente novamente.','err');
    btns.forEach(function(b){b.disabled=false;});
  }
}
</script>
<script>
const labelsGrafico = {!! json_encode($chartDias) !!};
const dadosGrafico  = {!! json_encode($chartHoras) !!};
new Chart(document.getElementById('chart-dias'), {
  type: 'line',
  data: {
    labels: labelsGrafico,
    datasets: [{
      label: 'HORAS TRABALHADAS',
      data: dadosGrafico,
      borderColor: '#2563eb',
      backgroundColor: 'rgba(37,99,235,0.08)',
      fill: true,
      tension: 0.35,
      pointRadius: 4,
      pointBackgroundColor: '#2563eb',
      pointBorderColor: '#fff',
      pointBorderWidth: 2,
    }, {
      label: 'Meta diaria (8h)',
      data: Array(labelsGrafico.length).fill(8),
      borderColor: '#ef4444',
      borderWidth: 1.5,
      borderDash: [6,4],
      pointRadius: 0,
      fill: false,
      tension: 0,
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    interaction: { mode: 'index', intersect: false },
    plugins: {
      legend: { display: false },
      tooltip: {
        callbacks: {
          label: function(ctx){ return ctx.datasetIndex===0 ? (ctx.raw > 0 ? ctx.raw+'h trabalhadas' : 'Sem registro') : '8h (meta diaria)'; }
        }
      }
    },
    scales: {
      y: { beginAtZero: true, max: 11, ticks: { stepSize: 2, font: { size: 10 }, callback: function(v){return v+'h';} }, grid: { color: '#f3f4f6' } },
      x: { ticks: { font: { size: 10 } }, grid: { display: false } }
    }
  }
});
</script>
</body>
</html>