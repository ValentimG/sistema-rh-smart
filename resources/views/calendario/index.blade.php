<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Calendario — SMART RH</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/calendario.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
</head>
<body>
    @include('layouts.header')
    <main class="pg">
        <div class="cal-layout">
            <aside class="cal-sidebar">
                <div class="card">
                    <button class="btn-add" onclick="abrirModalHoje()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Novo Evento
                    </button>
                </div>
                <div class="card">
                    <div class="card-title">Legenda</div>
                    <div class="legend-item"><span class="legend-dot ld-feriado"></span> Feriados</div>
                    <div class="legend-item"><span class="legend-dot ld-empresa"></span> Eventos da Empresa</div>
                    <div class="legend-item"><span class="legend-dot ld-pessoal"></span> Pessoal</div>
                </div>
                <div class="card">
                    <div class="card-title">Proximos Eventos</div>
                    <div id="lista-eventos"></div>
                </div>
            </aside>
            <div class="cal-main">
                <div class="card"><div id="calendar"></div></div>
            </div>
        </div>
    </main>

    <div class="modal-overlay" id="modal-overlay">
        <div class="modal-box">
            <h3 id="modal-title">Novo Evento</h3>
            <form id="form-evento">
                <input type="date" id="ev-data" class="form-input" required>
                <input type="text" id="ev-titulo" class="form-input" placeholder="Titulo" required>
                <textarea id="ev-descricao" class="form-input" placeholder="Descricao" rows="2" style="resize:vertical"></textarea>
                <select id="ev-tipo" class="form-input">
                    <option value="pessoal">Pessoal</option>
                    @if($isGestor)
                    <option value="feriado">Feriado</option>
                    <option value="evento_empresa">Evento da Empresa</option>
                    @endif
                </select>
                <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:8px">
                    <button type="button" class="btn btn-ghost" onclick="fecharModal()">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    <script src="/js/calendario.js"></script>
    <script src="/js/dark.js"></script>
</body>
</html>