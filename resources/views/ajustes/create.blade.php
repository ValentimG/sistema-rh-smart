<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Solicitar Ajuste — SMART RH</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <style>
        .page-header { margin-bottom: 24px; }
        .page-title { font-size: 1.3rem; font-weight: 800; color: var(--gray-900); }
        .page-sub { font-size: .8rem; color: var(--gray-400); margin-top: 4px; }
        .registro-card { background: #fff; border: 1px solid var(--gray-200); border-radius: 14px; padding: 18px 20px; margin-bottom: 10px; cursor: pointer; transition: all .2s; }
        .registro-card:hover { border-color: var(--primary); box-shadow: 0 4px 16px rgba(37,99,235,.06); }
        .registro-card.selected { border-color: var(--primary); background: rgba(37,99,235,.04); box-shadow: 0 0 0 4px rgba(37,99,235,.08); }
        .registro-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
        .registro-data { font-weight: 700; color: var(--gray-900); font-size: .9rem; }
        .registro-dia { font-size: .72rem; color: var(--gray-400); }
        .registro-horarios { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; }
        .registro-horario { text-align: center; padding: 10px 6px; background: var(--gray-50); border-radius: 10px; font-size: .75rem; cursor: pointer; transition: all .2s; border: 1.5px solid transparent; }
        .registro-horario:hover { border-color: var(--primary); background: #fff; }
        .registro-horario.highlight { border-color: var(--primary); background: rgba(37,99,235,.06); }
        .registro-horario-label { font-size: .6rem; text-transform: uppercase; color: var(--gray-400); margin-bottom: 3px; font-weight: 600; }
        .registro-horario-valor { font-weight: 600; color: var(--gray-800); }
        .registro-horario.highlight .registro-horario-valor { color: var(--primary); }
        .form-card { display: none; margin-top: 20px; animation: fadeInUp .3s ease-out; }
        .form-card.visible { display: block; }
        .selected-info { padding: 14px; background: rgba(37,99,235,.05); border-radius: 12px; margin-bottom: 16px; font-size: .85rem; color: var(--gray-800); }
        .selected-info strong { color: var(--primary); }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        body.dark .registro-card { background: rgba(30,41,59,.8); border-color: rgba(255,255,255,.05); }
        body.dark .registro-data { color: #f1f5f9; }
        body.dark .registro-horario { background: rgba(15,23,42,.6); }
        body.dark .registro-horario-valor { color: #e2e8f0; }
        body.dark .page-title { color: #f1f5f9; }
        body.dark .selected-info { background: rgba(37,99,235,.1); color: #cbd5e1; }
    </style>
</head>
<body>
    @include('layouts.header')
    <main class="pg" style="max-width:640px">
        <div class="page-header">
            <div>
                <h1 class="page-title">Solicitar Ajuste de Ponto</h1>
                <p class="page-sub">Selecione o dia e o horario que deseja ajustar</p>
            </div>
        </div>

        @if($errors->any())
        <div class="alert alert-error">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
        @endif

        @php
            $registros = \App\Models\RegistroPonto::where('funcionario_id', $funcionario->id)
                ->orderByDesc('data')
                ->limit(14)
                ->get();
        @endphp

        @forelse($registros as $r)
        <div class="registro-card" data-id="{{ $r->id }}" data-data="{{ $r->data->format('Y-m-d') }}" onclick="selecionarRegistro(this)">
            <div class="registro-header">
                <span class="registro-data">{{ $r->data->format('d/m/Y') }}</span>
                <span class="registro-dia">{{ ['Domingo','Segunda','Terca','Quarta','Quinta','Sexta','Sabado'][$r->data->dayOfWeek] }}</span>
            </div>
            <div class="registro-horarios">
                <div class="registro-horario" data-tipo="entrada" data-horario="{{ $r->entrada?->format('H:i') }}" onclick="event.stopPropagation(); selecionarHorario(this, 'entrada')">
                    <div class="registro-horario-label">Entrada</div>
                    <div class="registro-horario-valor">{{ $r->entrada?->format('H:i') ?? '—' }}</div>
                </div>
                <div class="registro-horario" data-tipo="saida_almoco" data-horario="{{ $r->saida_almoco?->format('H:i') }}" onclick="event.stopPropagation(); selecionarHorario(this, 'saida_almoco')">
                    <div class="registro-horario-label">S. Almoco</div>
                    <div class="registro-horario-valor">{{ $r->saida_almoco?->format('H:i') ?? '—' }}</div>
                </div>
                <div class="registro-horario" data-tipo="volta_almoco" data-horario="{{ $r->volta_almoco?->format('H:i') }}" onclick="event.stopPropagation(); selecionarHorario(this, 'volta_almoco')">
                    <div class="registro-horario-label">V. Almoco</div>
                    <div class="registro-horario-valor">{{ $r->volta_almoco?->format('H:i') ?? '—' }}</div>
                </div>
                <div class="registro-horario" data-tipo="saida" data-horario="{{ $r->saida?->format('H:i') }}" onclick="event.stopPropagation(); selecionarHorario(this, 'saida')">
                    <div class="registro-horario-label">Saida</div>
                    <div class="registro-horario-valor">{{ $r->saida?->format('H:i') ?? '—' }}</div>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            <p>Nenhum registro de ponto encontrado.</p>
        </div>
        @endforelse

        <div class="card form-card" id="form-card">
            <div class="card-body">
                <div class="selected-info" id="selected-info" style="display:none">
                    Ajustando <strong id="info-tipo"></strong> do dia <strong id="info-data"></strong>
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
            card.classList.add('selected');
            document.getElementById('form-card').classList.add('visible');
            document.getElementById('selected-info').style.display = 'none';
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
            document.getElementById('form-card').classList.add('visible');
            document.getElementById('selected-info').style.display = 'block';
            document.getElementById('info-tipo').textContent = el.querySelector('.registro-horario-label').textContent;
            document.getElementById('info-data').textContent = card.querySelector('.registro-data').textContent;
            document.getElementById('form-card').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    </script>
    <script src="/js/dark.js"></script>
</body>
</html>