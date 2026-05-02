<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Painel do Gestor — {{ config('app.name') }}</title>
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
.csv-btn{display:flex;align-items:center;gap:5px;padding:7px 13px;border:1px solid #e5e7eb;border-radius:7px;font-size:.8rem;font-weight:600;color:#374151;text-decoration:none;background:#fff;transition:.15s}
.csv-btn:hover{border-color:#2563eb;color:#2563eb}
.csv-btn svg{width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
.pg{max-width:1100px;margin:0 auto;padding:32px 24px}
.sec-t{font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:#9ca3af;margin-bottom:14px}
/* Stats */
.stats{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:20px}
.stat{background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:20px 22px;transition:.2s}
.stat:hover{box-shadow:0 2px 8px rgba(0,0,0,.06)}
.stat-lb{font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:#9ca3af;margin-bottom:8px}
.stat-v{font-size:2.2rem;font-weight:700;line-height:1;margin-bottom:4px}
.stat-s{font-size:.75rem;color:#9ca3af}
.v-blue{color:#2563eb}.v-green{color:#059669}.v-red{color:#dc2626}.v-ind{color:#0891b2}
.stat-bar{height:3px;border-radius:2px;background:#f3f4f6;margin-top:12px}
.stat-bar-f{height:100%;border-radius:2px}
.bf-g{background:#059669}.bf-r{background:#dc2626}
/* Metrics grid */
.metrics{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:24px}
.metric{background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:16px 18px;transition:.2s}
.metric:hover{box-shadow:0 2px 8px rgba(0,0,0,.06)}
/* Cards */
.card{background:#fff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;margin-bottom:20px;transition:.2s}
.card:hover{box-shadow:0 2px 8px rgba(0,0,0,.06)}
.ch{padding:14px 20px;border-bottom:1px solid #f3f4f6;display:flex;align-items:center;justify-content:space-between}
.ch h3{font-size:.85rem;font-weight:700;color:#111827}
.badge{display:inline-flex;align-items:center;padding:3px 10px;border-radius:999px;font-size:.7rem;font-weight:700}
.badge-g{background:#dcfce7;color:#15803d}.badge-r{background:#fee2e2;color:#991b1b}
/* Table */
.tb{width:100%;border-collapse:collapse}
.tb thead th{padding:10px 14px;text-align:left;font-size:.61rem;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:#9ca3af;background:#fafafa;border-bottom:1px solid #f3f4f6;white-space:nowrap}
.tb tbody tr:nth-child(even){background:#fafafa}
.tb tbody tr:hover{background:#f0f4ff}
.tb tbody td{padding:11px 14px;font-size:.82rem;color:#374151;border-bottom:1px solid #f3f4f6}
.tb tbody tr:last-child td{border-bottom:none}
.tc{text-align:center;font-variant-numeric:tabular-nums}
.fn{font-weight:600;color:#111827;font-size:.82rem}.fc{color:#9ca3af;font-size:.7rem;margin-top:1px}
.st{display:inline-flex;padding:2px 9px;border-radius:999px;font-size:.68rem;font-weight:700}
.st-ok{background:#dcfce7;color:#15803d}.st-an{background:#dbeafe;color:#1e40af}.st-pd{background:#f3f4f6;color:#6b7280}
.bw{display:inline-flex;padding:2px 9px;border-radius:999px;font-size:.68rem;font-weight:700}
.bk{background:#dcfce7;color:#15803d}.bwn{background:#fef9c3;color:#a16207}
.btn-ver{display:inline-flex;align-items:center;gap:4px;font-size:.72rem;font-weight:600;color:#2563eb;text-decoration:none;padding:4px 10px;border:1px solid #bfdbfe;border-radius:6px;transition:.15s}
.btn-ver:hover{background:#eff6ff}
.btn-ver svg{width:11px;height:11px;stroke:currentColor;fill:none;stroke-width:2.5}
/* Ausentes */
.aus-list{list-style:none}
.aus-item{display:flex;align-items:center;justify-content:space-between;padding:12px 20px;border-bottom:1px solid #fef2f2}
.aus-item:last-child{border-bottom:none}
.aus-item:hover{background:#fff5f5}
/* Charts */
.ch-row{display:grid;grid-template-columns:1fr 190px;gap:14px;margin-bottom:20px}
</style>
</head>
<body>
@include('layouts.header')
@php
    $presentes   = $registrosHoje->count();
    $ausentes    = $semPontoHoje->count();
    $totalFunc   = $totalFuncionarios;
    $pctP        = $totalFunc > 0 ? round($presentes / $totalFunc * 100) : 0;
    $thFmt       = sprintf('%02d:%02d', (int)$totalHorasHoje, (int)round(($totalHorasHoje - (int)$totalHorasHoje) * 60));
    $mediaFmt    = sprintf('%02d:%02d', (int)$mediaHorasSemana, (int)round(($mediaHorasSemana - (int)$mediaHorasSemana) * 60));
@endphp

<main class="pg">
  <!-- Cards principais -->
  <div class="sec-t">Visao geral — hoje</div>
  <div class="stats">
    <div class="stat">
      <div class="stat-lb">Total de Funcionarios</div>
      <div class="stat-v v-blue">{{ $totalFunc }}</div>
      <div class="stat-s">cadastrados no sistema</div>
    </div>
    <div class="stat">
      <div class="stat-lb">Presentes Hoje</div>
      <div class="stat-v v-green">{{ $presentes }}</div>
      <div class="stat-s">{{ $pctP }}% do quadro</div>
      <div class="stat-bar"><div class="stat-bar-f bf-g" style="width:{{ $pctP }}%"></div></div>
    </div>
    <div class="stat">
      <div class="stat-lb">Sem Registro Hoje</div>
      <div class="stat-v v-red">{{ $ausentes }}</div>
      <div class="stat-s">{{ 100 - $pctP }}% do quadro</div>
      <div class="stat-bar"><div class="stat-bar-f bf-r" style="width:{{ 100 - $pctP }}%"></div></div>
    </div>
  </div>

  <!-- Metricas secundarias -->
  <div class="metrics">
    <div class="metric">
      <div class="stat-lb">Total de Horas Hoje</div>
      <div class="stat-v v-blue" style="font-size:1.6rem">{{ $thFmt }}</div>
      <div class="stat-s">soma de todos os registros</div>
    </div>
    <div class="metric">
      <div class="stat-lb">Media Diaria (7 dias)</div>
      <div class="stat-v v-ind" style="font-size:1.6rem">{{ $mediaFmt }}</div>
      <div class="stat-s">por funcionario/dia</div>
    </div>
    <div class="metric">
      <div class="stat-lb">Maior Banco de Horas</div>
      <div class="stat-v v-green" style="font-size:1.2rem;white-space:nowrap">{{ $maiorBanco ? explode(' ', $maiorBanco->nome)[0] : '—' }}</div>
      <div class="stat-s">{{ $maiorBanco ? '+' . number_format($maiorBanco->banco_horas, 1, ',', '.') . 'h' : '' }}</div>
    </div>
    <div class="metric">
      <div class="stat-lb">Mais Afastamentos</div>
      <div class="stat-v" style="font-size:1.2rem;color:#d97706;white-space:nowrap">{{ $maisFaltas ? explode(' ', $maisFaltas->nome)[0] : '—' }}</div>
      <div class="stat-s">{{ $maisFaltas ? $maisFaltas->diasTotaisAfastamento() . 'd de afastamento' : 'Nenhum registrado' }}</div>
    </div>
  </div>

  <!-- Graficos -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <div class="ch-row">
    <div class="card">
      <div style="padding:18px 20px">
        <div class="sec-t">Banco de horas por funcionario</div>
        <div style="position:relative;height:180px"><canvas id="chart-banco-func"></canvas></div>
        <div style="display:flex;gap:14px;margin-top:10px;font-size:.68rem;color:#6b7280">
          <span style="display:flex;align-items:center;gap:4px"><span style="width:9px;height:9px;background:#2563eb;border-radius:2px;display:inline-block"></span>Banco positivo</span>
          <span style="display:flex;align-items:center;gap:4px"><span style="width:9px;height:9px;background:#ef4444;border-radius:2px;display:inline-block"></span>Banco negativo</span>
        </div>
      </div>
    </div>
    <div class="card">
      <div style="padding:18px 20px;text-align:center">
        <div class="sec-t">Presenca Hoje</div>
        <div style="position:relative;width:130px;height:130px;margin:0 auto">
          <canvas id="chart-presenca" width="130" height="130"></canvas>
          <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center">
            <span style="font-size:1.6rem;font-weight:700;color:#059669">{{ $pctP }}%</span>
            <span style="font-size:.62rem;color:#9ca3af">presentes</span>
          </div>
        </div>
        <div style="margin-top:10px;font-size:.72rem;color:#6b7280">
          <div style="display:flex;align-items:center;justify-content:center;gap:5px;margin-bottom:3px">
            <span style="width:8px;height:8px;background:#059669;border-radius:50%;display:inline-block"></span>{{ $presentes }} presentes
          </div>
          <div style="display:flex;align-items:center;justify-content:center;gap:5px">
            <span style="width:8px;height:8px;background:#ef4444;border-radius:50%;display:inline-block"></span>{{ $ausentes }} ausentes
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Registros de hoje -->
  <div class="card">
    <div class="ch">
      <h3>Registros de Hoje</h3>
      <span class="badge badge-g">{{ $presentes }} {{ $presentes === 1 ? 'funcionario' : 'funcionarios' }}</span>
    </div>
    <div style="overflow-x:auto">
      <table class="tb">
        <thead><tr>
          <th>Funcionario</th>
          <th style="text-align:center">Entrada</th>
          <th style="text-align:center">Saida Almoco</th>
          <th style="text-align:center">Volta Almoco</th>
          <th style="text-align:center">Saida</th>
          <th style="text-align:center">Total</th>
          <th style="text-align:center">Status</th>
          <th></th>
        </tr></thead>
        <tbody>
          @forelse($registrosHoje as $r)
          <tr>
            <td><div class="fn">{{ $r->funcionario->nome }}</div><div class="fc">{{ $r->funcionario->cargo }}</div></td>
            <td class="tc">{{ $r->entrada?->format('H:i') ?? '—' }}</td>
            <td class="tc">{{ $r->saida_almoco?->format('H:i') ?? '—' }}</td>
            <td class="tc">{{ $r->volta_almoco?->format('H:i') ?? '—' }}</td>
            <td class="tc">{{ $r->saida?->format('H:i') ?? '—' }}</td>
            <td style="text-align:center">
              @if($r->horasTrabalhadas() > 0)
                @php $h=(int)$r->horasTrabalhadas(); $m=(int)round(($r->horasTrabalhadas()-$h)*60); @endphp
                <span class="bw {{ $r->horasTrabalhadas()>=8?'bk':'bwn' }}">{{ sprintf('%02d:%02d',$h,$m) }}</span>
              @else
                <span style="color:#d1d5db">—</span>
              @endif
            </td>
            <td style="text-align:center">
              @if($r->saida)<span class="st st-ok">Concluido</span>
              @elseif($r->entrada)<span class="st st-an">Em andamento</span>
              @else<span class="st st-pd">Pendente</span>
              @endif
            </td>
            <td style="text-align:right;padding-right:14px">
              <a href="{{ route('funcionarios.show', $r->funcionario) }}" class="btn-ver">Ver<svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
            </td>
          </tr>
          @empty
          <tr><td colspan="8" style="text-align:center;padding:28px;color:#9ca3af;font-size:.82rem">Nenhum registro hoje ainda.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Funcionarios sem ponto -->
  @if($semPontoHoje->count())
  <div class="card" style="border-color:#fecaca">
    <div class="ch" style="background:#fff5f5;border-bottom-color:#fecaca">
      <h3 style="color:#991b1b">Sem Registro Hoje</h3>
      <span class="badge badge-r">{{ $ausentes }} {{ $ausentes===1?'funcionario':'funcionarios' }}</span>
    </div>
    <ul class="aus-list">
      @foreach($semPontoHoje as $f)
      <li class="aus-item">
        <div><div class="fn">{{ $f->nome }}</div><div class="fc">{{ $f->cargo }}</div></div>
        <a href="{{ route('funcionarios.show', $f) }}" class="btn-ver">Ver<svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
      </li>
      @endforeach
    </ul>
  </div>
  @endif
</main>
<script>
// Grafico de barras: banco de horas por funcionario
new Chart(document.getElementById('chart-banco-func'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($chartBancoLabels) !!},
        datasets: [{
            data: {!! json_encode($chartBancoData) !!},
            backgroundColor: {!! json_encode(array_map(fn($v) => $v >= 0 ? 'rgba(37,99,235,0.75)' : 'rgba(239,68,68,0.75)', $chartBancoData)) !!},
            borderRadius: 5,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: ctx => (ctx.raw>=0?'+':'')+ctx.raw+'h de banco' } }
        },
        scales: {
            y: { ticks: { font:{size:10}, callback: v=>v+'h' }, grid: { color:'#f3f4f6' } },
            x: { ticks: { font:{size:10} }, grid: { display:false } }
        }
    }
});

// Grafico de pizza: presenca
new Chart(document.getElementById('chart-presenca'), {
    type: 'doughnut',
    data: {
        datasets: [{
            data: [{{ $presentes }}, {{ $ausentes }}],
            backgroundColor: ['rgba(5,150,105,.85)','rgba(239,68,68,.8)'],
            borderWidth: 0,
        }]
    },
    options: { responsive:false, cutout:'68%', plugins:{ legend:{display:false}, tooltip:{enabled:false} } }
});

// Relogio topbar
const DS=['Domingo','Segunda-feira','Terca-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado'];
const MS=['janeiro','fevereiro','marco','abril','maio','junho','julho','agosto','setembro','outubro','novembro','dezembro'];
(function tick(){
    const d=new Date();
    const el=document.getElementById('topbar-date');
    if(el) el.textContent=`${DS[d.getDay()]}, ${d.getDate()} de ${MS[d.getMonth()]} de ${d.getFullYear()}`;
    setTimeout(tick,60000);
})();
</script>
</body>
</html>
