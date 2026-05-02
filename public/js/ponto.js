// Relogio digital
(function() {
    const dias = ['Domingo', 'Segunda-feira', 'Terca-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sabado'];
    const meses = ['janeiro', 'fevereiro', 'marco', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro'];

    function atualizarRelogio() {
        const agora = new Date();
        const h = String(agora.getHours()).padStart(2, '0');
        const m = String(agora.getMinutes()).padStart(2, '0');
        const s = String(agora.getSeconds()).padStart(2, '0');

        const clockEl = document.getElementById('clock');
        const dateEl = document.getElementById('clock-date');

        if (clockEl) clockEl.textContent = h + ':' + m + ':' + s;
        if (dateEl) dateEl.textContent = dias[agora.getDay()] + ', ' + agora.getDate() + ' de ' + meses[agora.getMonth()] + ' de ' + agora.getFullYear();
    }

    setInterval(atualizarRelogio, 1000);
    atualizarRelogio();
})();

// Toast de feedback
function toast(mensagem, tipo) {
    const container = document.getElementById('toast-root');
    const el = document.createElement('div');
    el.className = 'toast ' + (tipo === 'ok' ? 'toast-success' : 'toast-error');
    el.textContent = mensagem;
    container.appendChild(el);
    setTimeout(function() { el.remove(); }, 4000);
}

// Bater ponto via AJAX
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-action[data-url]').forEach(function(btn) {
        btn.addEventListener('click', function() {
            if (btn.disabled) return;
            baterPonto(btn.dataset.url);
        });
    });
});

async function baterPonto(url) {
    var botoes = document.querySelectorAll('.btn-action[data-url]');
    botoes.forEach(function(b) { b.disabled = true; });

    var csrf = document.querySelector('meta[name="csrf-token"]');
    if (!csrf) {
        toast('Erro de seguranca. Recarregue a pagina.', 'err');
        botoes.forEach(function(b) { b.disabled = false; });
        return;
    }

    try {
        var resposta = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrf.content
            }
        });

        var dados = await resposta.json();

        if (dados.sucesso) {
            toast(dados.mensagem, 'ok');
            setTimeout(function() { window.location.reload(); }, 1500);
        } else {
            toast(dados.mensagem || 'Operacao nao permitida.', 'err');
            botoes.forEach(function(b) { b.disabled = false; });
        }
    } catch (e) {
        toast('Erro de conexao. Tente novamente.', 'err');
        botoes.forEach(function(b) { b.disabled = false; });
    }
}