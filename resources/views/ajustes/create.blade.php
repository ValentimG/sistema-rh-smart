<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Solicitar Ajuste — SMART RH</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <style>
        .registro-card { background: #fff; border: 1px solid var(--gray-200); border-radius: 12px; padding: 16px; margin-bottom: 10px; cursor: pointer; transition: all .2s; }
        .registro-card:hover { border-color: var(--primary); background: rgba(37,99,235,.02); }
        .registro-card.selected { border-color: var(--primary); background: rgba(37,99,235,.05); box-shadow: 0 0 0 3px rgba(37,99,235,.1); }
        .registro-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px; }
        .registro-data { font-weight: 700; color: var(--gray-900); }
        .registro-horarios { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; }
        .registro-horario { text-align: center; padding: 8px; background: var(--gray-50); border-radius: 8px; font-size: .75rem; cursor: pointer; transition: all .2s; border: 1.5px solid transparent; }
        .registro-horario:hover { border-color: var(--primary); }
        .registro-horario.highlight { border-color: var(--primary); background: rgba(37,99,235,.05); }
        .registro-horario-label { font-size: .6rem; text-transform: uppercase; color: var(--gray-400); margin-bottom: 3px; }
        .registro-horario-valor { font-weight: 600; color: var(--gray-800); }
        .selected-info { display: none; margin-top: 16px; padding: 14px; background: rgba(37,99,235,.05); border-radius: 12px; border: 1px solid rgba(37,99,235,.15); }
        .selected-info.visible { display: block; }
        body.dark .registro-card { background: rgba(30,41,59,.8); border-color: rgba(255,255,255,.05); }
        body.dark .registro-horario { background: rgba(15,23,42,.6); }
        body.dark .registro-horario-valor { color: #e2e8f0; }
        body.dark .registro-data { color: #f1f5f9; }
    </style>
</head>
<body>
    @include('layouts.header')
    <main class="pg" style="max-width:600px">
        <div class="section-title">Solicitar Ajuste de Ponto</div>
        <p class="text-muted text-sm" style="margin-bottom:20px">Selecione o dia e o horario que deseja ajustar</p>

        @if($errors->any())
        <div class="alert alert-error">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
        @endif

        @php
            $registros = \App\Models\RegistroPonto::where('funcionario_id', $funcionario->id)
                ->whereNotNull('saida')
                ->orderByDesc('data')
                ->limit(14)
                ->get();
        @endphp

        @forelse($registros as $r)
        <div class="registro-card" data-id="{{ $r->id }}" data-data="{{ $r->data->format('Y-m-d') }}" onclick="selecionarRegistro(this)">
            <div class="registro-header">
                <span class="registro-data">{{ $r->data->format('d/m/Y') }} — {{ ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'][$r->data->dayOfWeek] }}</span>
            </div>
            <div class="registro-horarios">
                <div class="registro-horario" data-tipo="entrada" data-horario="{{ $r->entrada?->format('H:i') }}" onclick="event.stopPropagation(); selecionarHorario(this, 'entrada')">
                    <div class="registro-horario-label">Entrada</div>
                    <div class="registro-horario-valor">{{ $r->entrada?->format('H:i') ?? '—' }}</div>
                </div>
                <div class="registro-horario" data-tipo="saida_almoco" data-horario="{{ $r->saida_almoco?->format('H:i') }}" onclick="event.stopPropagation(); selecionarHorario(this, 'saida_almoco')">
                    <div class="registro-horario-label">Saida Almoco</div>
                    <div class="registro-horario-valor">{{ $r->saida_almoco?->format('H:i') ?? '—' }}</div>
                </div>
                <div class="registro-horario" data-tipo="volta_almoco" data-horario="{{ $r->volta_almoco?->format('H:i') }}" onclick="event.stopPropagation(); selecionarHorario(this, 'volta_almoco')">
                    <div class="registro-horario-label">Volta Almoco</div>
                    <div class="registro-horario-valor">{{ $r->volta_almoco?->format('H:i') ?? '—' }}</div>
                </div>
                <div class="registro-horario" data-tipo="saida" data-horario="{{ $r->saida?->format('H:i') }}" onclick="event.stopPropagation(); selecionarHorario(this, 'saida')">
                    <div class="registro-horario-label">Saida</div>
                    <div class="registro-horario-valor">{{ $r->saida?->format('H:i') ?? '—' }}</div>
                </div>
            </div>
        </div>
        @empty
        <p class="text-center text-muted py-4">Nenhum registro de ponto encontrado.</p>
        @endforelse

        <div class="card" style="margin-top:20px;display:none" id="form-ajuste">
            <div class="card-body">
                <div class="selected-info" id="selected-info">
                    <strong id="info-data"></strong> — <span id="info-tipo"></span>
                </div>
                <form method="POST" action="{{ route('ajustes.store') }}">
                    @csrf
                    <input type="hidden" name="data" id="form-data">
                    <input type="hidden" name="tipo" id="form-tipo">
                    <div class="form-group">
                        <label class="form-label">Novo Horario</label>
                        <input type="time" name="horario_solicitado" class="form-input" required id="form-horario">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Motivo</label>
                        <textarea name="motivo" class="form-input" rows="3" placeholder="Explique o motivo do ajuste..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width:100%">Enviar Solicitacao</button>
                </form>
            </div>
        </div>
    </main>
    <script>
        function selecionarRegistro(card) {
            document.querySelectorAll('.registro-card').forEach(c => c.classList.remove('selected'));
            document.querySelectorAll('.registro-horario').forEach(h => h.classList.remove('highlight'));
            card.classList.add('selected');
            document.getElementById('form-ajuste').style.display = 'block';
            document.getElementById('selected-info').classList.remove('visible');
            document.getElementById('form-data').value = '';
            document.getElementById('form-tipo').value = '';
        }
        function selecionarHorario(el, tipo) {
            document.querySelectorAll('.registro-horario').forEach(h => h.classList.remove('highlight'));
            el.classList.add('highlight');
            var card = el.closest('.registro-card');
            var data = card.dataset.data;
            var horario = el.dataset.horario;
            document.getElementById('form-data').value = data;
            document.getElementById('form-tipo').value = tipo;
            document.getElementById('form-horario').value = horario || '';
            document.getElementById('form-ajuste').style.display = 'block';
            document.getElementById('selected-info').classList.add('visible');
            document.getElementById('info-data').textContent = card.querySelector('.registro-data').textContent;
            document.getElementById('info-tipo').textContent = el.querySelector('.registro-horario-label').textContent + ' atual: ' + (horario || '—');
            document.getElementById('form-ajuste').scrollIntoView({ behavior: 'smooth' });
        }
    </script>
    <script src="/js/dark.js"></script>
</body>
</html>