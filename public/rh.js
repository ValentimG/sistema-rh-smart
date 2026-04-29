// Inicializar dark mode antes de renderizar (evita flash)
(function () {
    if (localStorage.getItem('rhDark') === '1') {
        document.documentElement.classList.add('dark');
    }
})();

document.addEventListener('DOMContentLoaded', function () {
    // Criar botão flutuante de alternância de tema
    var btn = document.createElement('button');
    btn.id = 'rh-dark-btn';
    btn.title = 'Alternar modo escuro';
    btn.setAttribute('aria-label', 'Alternar modo escuro');
    atualizarIcone(btn);
    document.body.appendChild(btn);

    btn.addEventListener('click', function () {
        var isDark = document.documentElement.classList.toggle('dark');
        localStorage.setItem('rhDark', isDark ? '1' : '0');
        atualizarIcone(btn);
    });
});

function atualizarIcone(btn) {
    var isDark = document.documentElement.classList.contains('dark');

    // Ícone sol (modo claro ativo → clique vai para escuro)
    var sol = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#f59e0b"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>';

    // Ícone lua (modo escuro ativo → clique vai para claro)
    var lua = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#818cf8"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>';

    btn.innerHTML = isDark ? sol : lua;
}
