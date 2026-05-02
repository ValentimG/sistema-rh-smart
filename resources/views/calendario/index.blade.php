<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Calendario — SMART RH</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <style>
        :root{--primary:#2563eb;--success:#10b981;--danger:#ef4444;--gray-50:#f8fafc;--gray-100:#f1f5f9;--gray-200:#e2e8f0;--gray-400:#94a3b8;--gray-600:#475569;--gray-800:#1e293b;--gray-900:#0f172a}
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Inter',sans-serif;background:linear-gradient(135deg,#eff6ff 0%,#f8fafc 50%,#fef3c7 100%);color:var(--gray-900);min-height:100vh}
        .hd{background:rgba(255,255,255,.9);backdrop-filter:blur(20px);border-bottom:1px solid rgba(0,0,0,.05);padding:0 40px;height:64px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:100}
        .logo{display:flex;align-items:center;gap:10px}
        .logo-ic{width:36px;height:36px;background:linear-gradient(135deg,var(--primary),#6366f1);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:900;font-size:.75rem;box-shadow:0 4px 12px rgba(37,99,235,.3)}
        .logo-n{font-size:.9rem;font-weight:800;color:var(--gray-900)}.logo-s{font-size:.55rem;color:var(--gray-400)}
        .hd-r{display:flex;align-items:center;gap:12px}.nav{display:flex;gap:3px}
        .nl{display:flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;color:var(--gray-600);text-decoration:none;font-size:.8rem;font-weight:500;transition:all .2s}
        .nl:hover,.nl.on{background:rgba(37,99,235,.08);color:var(--primary)}
        .av{width:34px;height:34px;background:linear-gradient(135deg,var(--primary),#6366f1);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.78rem}
        .lg-btn{display:flex;align-items:center;gap:5px;padding:7px 12px;border-radius:7px;color:var(--gray-400);font-size:.8rem;font-weight:500;background:none;border:none;cursor:pointer}.lg-btn:hover{background:var(--gray-100);color:var(--gray-800)}
        .pg{max-width:1000px;margin:0 auto;padding:40px 24px}
        .card{background:#fff;border:1px solid var(--gray-200);border-radius:16px;padding:24px;box-shadow:0 1px 3px rgba(0,0,0,.04)}
        .fc-theme-standard td,.fc-theme-standard th{border-color:var(--gray-100)}
        .fc .fc-toolbar-title{font-size:1rem;font-weight:700}
        .fc .fc-button{background:var(--primary);border:none;border-radius:8px;padding:6px 14px;font-size:.8rem;font-weight:600;text-transform:capitalize}
        .fc .fc-button:hover{background:#1d4ed8}
        .fc .fc-button-primary:not(:disabled).fc-button-active{background:#1d4ed8}
        .theme-toggle{width:38px;height:38px;border-radius:10px;border:1.5px solid var(--gray-200);background:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:1rem;transition:all .3s}
        .theme-toggle:hover{border-color:var(--primary)}
        body.dark{background:linear-gradient(135deg,#0f172a 0%,#1e293b 50%,#0f172a 100%);color:#e2e8f0}
        body.dark .hd{background:rgba(15,23,42,.9);border-bottom-color:rgba(255,255,255,.05)}
        body.dark .logo-n{color:#f1f5f9}
        body.dark .nl{color:#94a3b8}
        body.dark .nl:hover,body.dark .nl.on{background:rgba(37,99,235,.15);color:#60a5fa}
        body.dark .card{background:rgba(30,41,59,.8);border-color:rgba(255,255,255,.05)}
        body.dark .fc-theme-standard td,.fc-theme-standard th{border-color:rgba(255,255,255,.06)}
        body.dark .fc .fc-daygrid-day-number{color:#94a3b8}
        body.dark .fc .fc-col-header-cell-cushion{color:#64748b}
        body.dark .lg-btn{color:#64748b}
        body.dark .lg-btn:hover{background:rgba(255,255,255,.05);color:#94a3b8}
        body.dark .theme-toggle{background:#1e293b;border-color:#334155}
        .modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.4);z-index:200;align-items:center;justify-content:center}
        .modal-overlay.active{display:flex}
        .modal-box{background:#fff;border-radius:16px;padding:28px;width:400px;box-shadow:0 20px 60px rgba(0,0,0,.2)}
        body.dark .modal-box{background:#1e293b;color:#e2e8f0}
        .form-input{width:100%;padding:10px 14px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:.87rem;outline:none;margin-bottom:12px}
        .form-input:focus{border-color:var(--primary)}
        body.dark .form-input{background:#0f172a;border-color:#334155;color:#e2e8f0}
        .btn{padding:9px 18px;border-radius:10px;font-size:.82rem;font-weight:600;cursor:pointer;border:none;transition:all .2s}
        .btn-primary{background:var(--primary);color:#fff}.btn-primary:hover{background:#1d4ed8}
        .btn-secondary{background:var(--gray-100);color:var(--gray-600)}.btn-secondary:hover{background:var(--gray-200)}
        body.dark .btn-secondary{background:#334155;color:#94a3b8}
    </style>
</head>
<body>
    @include('layouts.header')
    <main class="pg">
        <div class="card"><div id="calendar"></div></div>
    </main>

    <div class="modal-overlay" id="modal-overlay">
        <div class="modal-box">
            <h3 style="font-size:1rem;font-weight:700;margin-bottom:16px" id="modal-title">Novo Evento</h3>
            <form id="form-evento">
                <input type="date" id="ev-data" class="form-input" required>
                <input type="text" id="ev-titulo" class="form-input" placeholder="Titulo" required>
                <textarea id="ev-descricao" class="form-input" placeholder="Descricao (opcional)" rows="2" style="resize:vertical"></textarea>
                <select id="ev-tipo" class="form-input">
                    <option value="pessoal">Pessoal</option>
                    @if($isGestor)
                    <option value="feriado">Feriado</option>
                    <option value="evento_empresa">Evento da Empresa</option>
                    @endif
                </select>
                <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:8px">
                    <button type="button" class="btn btn-secondary" onclick="fecharModal()">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        var isGestor = {{ $isGestor ? 'true' : 'false' }};
        var calendar;
        document.addEventListener('DOMContentLoaded', function() {
            calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                initialView: 'dayGridMonth',
                locale: 'pt-br',
                headerToolbar: { left: 'prev,next today', center: 'title', right: '' },
                events: '{{ route('calendario.eventos') }}',
                dateClick: function(info) {
                    document.getElementById('ev-data').value = info.dateStr;
                    document.getElementById('ev-titulo').value = '';
                    document.getElementById('ev-descricao').value = '';
                    document.getElementById('modal-overlay').classList.add('active');
                },
                eventClick: function(info) {
                    if (confirm('Excluir este evento?')) {
                        fetch('/calendario/' + info.event.id, {
                            method: 'DELETE',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                        }).then(function(r) { return r.json(); }).then(function(d) {
                            if (d.sucesso) info.event.remove();
                        });
                    }
                }
            });
            calendar.render();
        });

        document.getElementById('form-evento').addEventListener('submit', function(e) {
            e.preventDefault();
            var data = {
                data: document.getElementById('ev-data').value,
                titulo: document.getElementById('ev-titulo').value,
                descricao: document.getElementById('ev-descricao').value,
                tipo: document.getElementById('ev-tipo').value,
                _token: '{{ csrf_token() }}'
            };
            fetch('{{ route('calendario.store') }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify(data)
            }).then(function(r) { return r.json(); }).then(function(d) {
                if (d.sucesso) {
                    calendar.refetchEvents();
                    fecharModal();
                }
            });
        });

        function fecharModal() {
            document.getElementById('modal-overlay').classList.remove('active');
        }
    </script>
    <script src="/js/dark.js"></script>
</body>
</html>