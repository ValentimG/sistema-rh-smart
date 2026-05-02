var calendar;
var isGestor = false;

document.addEventListener('DOMContentLoaded', function() {
    isGestor = document.querySelector('#ev-tipo option[value="feriado"]') !== null;
    
    calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        initialView: 'dayGridMonth',
        locale: 'pt-br',
        headerToolbar: { left: 'prev,next today', center: 'title', right: '' },
        events: '/calendario/eventos',
        dateClick: function(info) {
            abrirModal(info.dateStr);
        },
        eventClick: function(info) {
            if (confirm('Excluir este evento?')) {
                excluirEvento(info.event.id, info.event);
            }
        },
        eventsSet: function(events) {
            atualizarListaEventos(events);
        }
    });
    
    calendar.render();
    
    document.getElementById('form-evento').addEventListener('submit', salvarEvento);
});

function abrirModal(data) {
    document.getElementById('ev-data').value = data || new Date().toISOString().split('T')[0];
    document.getElementById('ev-titulo').value = '';
    document.getElementById('ev-descricao').value = '';
    document.getElementById('modal-overlay').classList.add('active');
}

function abrirModalHoje() {
    abrirModal(new Date().toISOString().split('T')[0]);
}

function fecharModal() {
    document.getElementById('modal-overlay').classList.remove('active');
}

async function salvarEvento(e) {
    e.preventDefault();
    
    var dados = {
        data: document.getElementById('ev-data').value,
        titulo: document.getElementById('ev-titulo').value,
        descricao: document.getElementById('ev-descricao').value,
        tipo: document.getElementById('ev-tipo').value,
        _token: document.querySelector('meta[name="csrf-token"]').content
    };
    
    try {
        var resposta = await fetch('/calendario', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': dados._token },
            body: JSON.stringify(dados)
        });
        
        var resultado = await resposta.json();
        
        if (resultado.sucesso) {
            calendar.refetchEvents();
            fecharModal();
        }
    } catch (erro) {
        alert('Erro ao salvar evento.');
    }
}

async function excluirEvento(id, eventObj) {
    try {
        var resposta = await fetch('/calendario/' + id, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        });
        
        var resultado = await resposta.json();
        
        if (resultado.sucesso && eventObj) {
            eventObj.remove();
            calendar.refetchEvents();
        }
    } catch (erro) {
        alert('Erro ao excluir evento.');
    }
}

function atualizarListaEventos(events) {
    var container = document.getElementById('lista-eventos');
    var agora = new Date();
    var proximos = events.filter(function(e) {
        return new Date(e.start) >= new Date(agora.toDateString());
    }).slice(0, 5);
    
    if (proximos.length === 0) {
        container.innerHTML = '<p style="color:var(--gray-400);font-size:.78rem">Nenhum evento proximo.</p>';
        return;
    }
    
    var html = '';
    var cores = { feriado: 'var(--danger)', evento_empresa: 'var(--primary)', pessoal: 'var(--success)' };
    
    proximos.forEach(function(e) {
        var cor = cores[e.extendedProps.tipo] || 'var(--gray-400)';
        var data = new Date(e.start).toLocaleDateString('pt-BR');
        
        html += '<div class="evento-mini">';
        html += '<span class="evento-mini-dot" style="background:' + cor + '"></span>';
        html += '<span class="evento-mini-titulo">' + e.title + '</span>';
        html += '<span class="evento-mini-data">' + data + '</span>';
        html += '</div>';
    });
    
    container.innerHTML = html;
}