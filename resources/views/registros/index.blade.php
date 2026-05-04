<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Meu Ponto — SMART RH</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    @include('layouts.header')
    <main class="pg pg-sm">
        <div class="clock-section">
            <div class="clock-time" id="clock">--:--:--</div>
            <div class="clock-date" id="clock-date"></div>
        </div>

        @if($hoje->saida)
        <div class="journey-done animate-in">
            <svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
            <div>
                <div class="journey-done-title">Jornada encerrada</div>
                <div class="journey-done-sub">{{ $hoje->horasTrabalhadasFormatado() }} trabalhadas hoje</div>
            </div>
        </div>
        @endif

        <div class="timeline">
            <div class="tl-item {{ $hoje->entrada ? 'tl-done' : '' }}">
                <div class="tl-dot"></div>
                <div class="tl-label">Entrada</div>
                <div class="tl-time">{{ $hoje->entrada?->format('H:i') ?? '--:--' }}</div>
            </div>
            <div class="tl-item {{ $hoje->saida_almoco ? 'tl-done' : '' }}">
                <div class="tl-dot"></div>
                <div class="tl-label">Saida Almoco</div>
                <div class="tl-time">{{ $hoje->saida_almoco?->format('H:i') ?? '--:--' }}</div>
            </div>
            <div class="tl-item {{ $hoje->volta_almoco ? 'tl-done' : '' }}">
                <div class="tl-dot"></div>
                <div class="tl-label">Volta Almoco</div>
                <div class="tl-time">{{ $hoje->volta_almoco?->format('H:i') ?? '--:--' }}</div>
            </div>
            <div class="tl-item {{ $hoje->saida ? 'tl-done' : '' }}">
                <div class="tl-dot"></div>
                <div class="tl-label">Saida</div>
                <div class="tl-time">{{ $hoje->saida?->format('H:i') ?? '--:--' }}</div>
            </div>
        </div>

        @unless($hoje->saida)
        <div class="actions-grid">
            @include('registros.partials.btn-entrada')
            @include('registros.partials.btn-saida-almoco')
            @include('registros.partials.btn-volta-almoco')
            @include('registros.partials.btn-saida')
        </div>
        @endunless

        <div class="section-title">Resumo da Semana</div>
        <div class="charts-row">
            <div class="card"><div class="card-body">
                <div class="card-title-sm">Horas Trabalhadas — Ultimos 7 Dias</div>
                <div class="chart-container"><canvas id="chart-dias"></canvas></div>
            </div></div>
            <div class="card card-center"><div class="card-body">
                <div class="card-title-sm">Banco de Horas</div>
                <div class="banco-valor {{ $bancoHoras >= 0 ? 'text-success' : 'text-danger' }}">{{ ($bancoHoras >= 0 ? '+' : '') . number_format($bancoHoras, 1, ',', '.') }}h</div>
                <div class="banco-status">{{ $bancoHoras >= 0 ? 'Saldo positivo' : 'Saldo negativo' }}</div>
                @if($hoje->saida)<div class="banco-hoje">{{ $hoje->horasTrabalhadasFormatado() }} hoje</div>@endif
            </div></div>
        </div>

        <div class="section-title">Historico — Ultimos 7 Dias</div>
        <div class="card"><div class="table-responsive">
            <table class="tb">
                <thead><tr><th>Data</th><th class="tc">Entrada</th><th class="tc">S. Almoco</th><th class="tc">V. Almoco</th><th class="tc">Saida</th><th class="tr">Total</th></tr></thead>
                <tbody>
                    @forelse($historico as $r)
                    <tr>
                        <td><span class="fw-600">{{ $r->data->format('d/m/Y') }}</span><span class="text-muted text-sm"> {{ ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'][$r->data->dayOfWeek] }}</span></td>
                        <td class="tc">{{ $r->entrada?->format('H:i') ?? '—' }}</td>
                        <td class="tc">{{ $r->saida_almoco?->format('H:i') ?? '—' }}</td>
                        <td class="tc">{{ $r->volta_almoco?->format('H:i') ?? '—' }}</td>
                        <td class="tc">{{ $r->saida?->format('H:i') ?? '—' }}</td>
                        <td class="tr">@if($r->horasTrabalhadas() > 0)@php $h=(int)$r->horasTrabalhadas();$m=(int)round(($r->horasTrabalhadas()-$h)*60);@endphp<span class="badge {{ $r->horasTrabalhadas() >= 8 ? 'badge-success' : 'badge-warning' }}">{{ $h }}h{{ $m ? " {$m}min" : '' }}</span>@else<span class="text-muted">—</span>@endif</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Nenhum registro nos ultimos 7 dias.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div></div>
    </main>

    <div id="toast-root"></div>
    <script src="/js/ponto.js"></script>
    <script>const chartData={labels:{!! json_encode($chartDias) !!},data:{!! json_encode($chartHoras) !!}};</script>
    <script src="/js/charts.js"></script>
    <script src="/js/dark.js"></script>
    <script>
        (function() {
            var meses = ['janeiro','fevereiro','marco','abril','maio','junho','julho','agosto','setembro','outubro','novembro','dezembro'];
            var dias = ['Domingo','Segunda-feira','Terca-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado'];
            function tick() {
                var d = new Date();
                var p = function(n) { return String(n).padStart(2, '0'); };
                document.getElementById('clock').textContent = p(d.getHours()) + ':' + p(d.getMinutes()) + ':' + p(d.getSeconds());
                document.getElementById('clock-date').textContent = dias[d.getDay()] + ', ' + d.getDate() + ' de ' + meses[d.getMonth()] + ' de ' + d.getFullYear();
                setTimeout(tick, 1000);
            }
            tick();
        })();
    </script>
</body>
</html>