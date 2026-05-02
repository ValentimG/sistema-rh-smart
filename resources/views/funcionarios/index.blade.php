<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Funcionarios — SMART RH</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
        .pg{max-width:1100px;margin:0 auto;padding:40px 24px}
        .section-title{font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--gray-400);margin-bottom:16px}
        .stats-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:24px}
        .stat-card{background:#fff;border:1px solid var(--gray-200);border-radius:16px;padding:22px 24px;transition:all .3s;box-shadow:0 1px 3px rgba(0,0,0,.04)}
        .stat-card:hover{transform:translateY(-2px);box-shadow:0 8px 25px rgba(37,99,235,.08)}
        .stat-label{font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--gray-400);margin-bottom:8px}
        .stat-value{font-size:2.2rem;font-weight:800;line-height:1;margin-bottom:4px}
        .stat-sub{font-size:.72rem;color:var(--gray-400)}
        .card{background:#fff;border:1px solid var(--gray-200);border-radius:16px;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.04)}
        .card-header{padding:16px 24px;border-bottom:1px solid var(--gray-100);display:flex;align-items:center;justify-content:space-between}
        .card-title{font-size:.85rem;font-weight:700;color:var(--gray-900)}
        .tb{width:100%;border-collapse:collapse}
        .tb thead th{padding:12px 16px;text-align:left;font-size:.6rem;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:var(--gray-400);background:var(--gray-50);border-bottom:1px solid var(--gray-100);white-space:nowrap}
        .tb tbody tr{transition:all .2s}.tb tbody tr:nth-child(even){background:var(--gray-50)}
        .tb tbody tr:hover{background:rgba(37,99,235,.03)}
        .tb tbody td{padding:14px 16px;font-size:.82rem;color:var(--gray-800);border-bottom:1px solid var(--gray-100)}
        .badge{display:inline-flex;padding:4px 10px;border-radius:999px;font-size:.68rem;font-weight:700}
        .badge-gestor{background:#ede9fe;color:#5b21b6}.badge-func{background:var(--gray-100);color:var(--gray-600)}
        .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:10px;font-size:.8rem;font-weight:600;text-decoration:none;transition:all .2s;border:none;cursor:pointer}
        .btn-primary{background:linear-gradient(135deg,var(--primary),#6366f1);color:#fff;box-shadow:0 4px 12px rgba(37,99,235,.25)}
        .btn-primary:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(37,99,235,.35)}
        .btn-sm{padding:5px 12px;font-size:.72rem;border-radius:8px;border:1px solid var(--gray-200);background:#fff;color:var(--gray-600);cursor:pointer;transition:all .2s;text-decoration:none;display:inline-flex;align-items:center}
        .btn-sm:hover{border-color:var(--primary);color:var(--primary)}.btn-sm-danger:hover{border-color:var(--danger);color:var(--danger)}
        .search-box{width:280px;padding:9px 16px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:.82rem;outline:none;transition:all .2s;background:#fff}
        .search-box:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(37,99,235,.1)}
        .text-muted{color:var(--gray-400)}.text-center{text-align:center}.text-sm{font-size:.72rem}.fw-600{font-weight:600}.ml-2{margin-left:8px}
        .theme-toggle{width:38px;height:38px;border-radius:10px;border:1.5px solid var(--gray-200);background:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:1rem;transition:all .3s}
        .theme-toggle:hover{border-color:var(--primary)}
        body.dark{background:linear-gradient(135deg,#0f172a 0%,#1e293b 50%,#0f172a 100%);color:#e2e8f0}
        body.dark .hd{background:rgba(15,23,42,.9);border-bottom-color:rgba(255,255,255,.05)}
        body.dark .logo-n{color:#f1f5f9}
        body.dark .nl{color:#94a3b8}
        body.dark .nl:hover,body.dark .nl.on{background:rgba(37,99,235,.15);color:#60a5fa}
        body.dark .stat-card,body.dark .card{background:rgba(30,41,59,.8);border-color:rgba(255,255,255,.05)}
        body.dark .tb thead th{background:rgba(15,23,42,.6);color:#64748b;border-bottom-color:rgba(255,255,255,.04)}
        body.dark .tb tbody tr:nth-child(even){background:rgba(30,41,59,.3)}
        body.dark .tb tbody td{color:#cbd5e1;border-bottom-color:rgba(255,255,255,.04)}
        body.dark .search-box{background:#1e293b;border-color:#334155;color:#e2e8f0}
        body.dark .btn-sm{background:#1e293b;border-color:#334155;color:#94a3b8}
        body.dark .lg-btn{color:#64748b}
        body.dark .lg-btn:hover{background:rgba(255,255,255,.05);color:#94a3b8}
        body.dark .theme-toggle{background:#1e293b;border-color:#334155}
        body.dark .card-header{border-bottom-color:rgba(255,255,255,.04)}
        body.dark .stat-label{color:#64748b}
    </style>
</head>
<body>
    @include('layouts.header')
    <main class="pg">
        <div class="section-title">Funcionarios</div>
        <div class="stats-grid">
            <div class="stat-card"><div class="stat-label">Total</div><div class="stat-value" style="color:var(--primary)">{{ $funcionarios->total() }}</div><div class="stat-sub">funcionarios cadastrados</div></div>
            <div class="stat-card"><div class="stat-label">Folha Mensal</div><div class="stat-value" style="color:var(--success)">R$ {{ number_format($totalFolha,0,',','.') }}</div><div class="stat-sub">custo total</div></div>
            <div class="stat-card"><div class="stat-label">Media Salarial</div><div class="stat-value" style="color:#f59e0b">R$ {{ number_format($mediaSalario,0,',','.') }}</div><div class="stat-sub">por funcionario</div></div>
        </div>
        <div class="card">
            <div class="card-header">
                <input type="text" class="search-box" placeholder="Buscar funcionario..." oninput="filtrar(this.value)">
                <a href="{{ route('funcionarios.create') }}" class="btn btn-primary">+ Novo Funcionario</a>
            </div>
            <div class="table-responsive">
                <table class="tb" id="tabela-func">
                    <thead><tr><th>Funcionario</th><th>Cargo</th><th>Tipo</th><th>Admissao</th><th>Salario</th><th class="text-center">Acoes</th></tr></thead>
                    <tbody>
                        @forelse($funcionarios as $f)
                        <tr data-nome="{{ strtolower($f->nome) }}">
                            <td><span class="fw-600">{{ $f->nome }}</span><br><span class="text-muted text-sm">{{ $f->email }}</span></td>
                            <td>{{ $f->cargo }}</td>
                            <td><span class="badge {{ $f->isGestor()?'badge-gestor':'badge-func' }}">{{ $f->isGestor()?'Gestor':'Funcionario' }}</span></td>
                            <td>{{ $f->data_admissao->format('d/m/Y') }}</td>
                            <td class="fw-600">{{ $f->salario_base?'R$ '.number_format($f->salario_base,0,',','.'):'—' }}</td>
                            <td class="text-center">
                                <a href="{{ route('funcionarios.show',$f) }}" class="btn-sm">Ver</a>
                                <a href="{{ route('funcionarios.edit',$f) }}" class="btn-sm">Editar</a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Nenhum funcionario cadastrado.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <script>
        function filtrar(valor){document.querySelectorAll('#tabela-func tbody tr').forEach(function(tr){tr.style.display=tr.dataset.nome.includes(valor.toLowerCase())?'':'none';});}
    </script>
    <script src="/js/dark.js"></script>
</body>
</html>