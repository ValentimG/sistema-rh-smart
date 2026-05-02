// Modo escuro
(function() {
    var dark = localStorage.getItem('darkMode') === 'true';
    if (dark) document.body.classList.add('dark');

    function toggleDark() {
        document.body.classList.toggle('dark');
        var isDark = document.body.classList.contains('dark');
        localStorage.setItem('darkMode', isDark);
        atualizarIcone();
    }

    function atualizarIcone() {
        var btn = document.querySelector('.theme-toggle');
        if (btn) {
            btn.textContent = document.body.classList.contains('dark') ? '☀' : '☾';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        var btn = document.querySelector('.theme-toggle');
        if (btn) {
            btn.addEventListener('click', toggleDark);
            atualizarIcone();
        }
    });
})();