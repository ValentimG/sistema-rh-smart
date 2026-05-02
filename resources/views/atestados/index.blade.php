<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Atestados — SMART RH</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <style>
        :root{--primary:#2563eb;--success:#10b981;--danger:#ef4444;--gray-50:#f8fafc;--gray-100:#f1f5f9;--gray-200:#e2e8f0;--gray-400:#94a3b8;--gray-600:#475569;--gray-800:#1e293b;--gray-900:#0f172a}
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Inter',sans-serif;background:linear-gradient(135deg,#eff6ff 0%,#f8fafc 50%,#fef3c7 100%);color:var(--gray-900);min-height:100vh}
        .hd{background:rgba(255,255,255,.9);backdrop-filter:blur(20px);border-bottom:1px solid rgba(0,0,0,.05);padding:0 40px;height:64px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:100}
        .logo{display:flex;align-items:center;gap:10px}
        .logo-ic{width:36px;height:36px;background:linear-gradient(135deg,var(--primary),#6366f1);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:900;font-size:.75rem;box-shadow:0 4px 12px rgba(37,99,235,.3)}
        .logo-n{font-size:.9rem;font-weight:800;color:var(--gray-900)}.logo-s{font-size:.55rem;color:var(--gray-400);font-weight:500}
        .hd-r{display:flex;align-items:center;gap:12px}.nav{display:flex;gap:3px}
        .nl{display:flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;color:var(--gray-600);text-decoration:none;font-size:.8rem;font-weight:500;transition:all .2s}
        .nl:hover,.nl.on{background:rgba(37,99,235,.08);color:var(--primary)}
        .av{width:34px;height:34px;background:linear-gradient(135deg,var(--primary),#6366f1);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.78rem}
        .lg-btn{display:flex;align-items:center;gap:5px;padding:7px 12px;border-radius:7px;color:var(--gray-400);font-size:.8rem;font-weight:500;background:none;border:none;cursor:pointer}.lg-btn:hover{background:var(--gray-100);color:var(--gray-800)}
        .pg{max-width:900px;margin:0 auto;padding:40px 24px}
        .card{background:#fff;border:1px solid var(--gray-200);border-radius:16px;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.04);margin-bottom:20px}
        .card-header{padding:16px 24px;border-bottom:1px solid var(--gray-100);display:flex;align-items:center;justify-content:space-between}
        .card-title{font-size:.9rem;font-weight:700;color:var(--gray-900)}
        .tb{width:100%;border-collapse:collapse}
        .tb thead th{padding:12px 16px;text-align:left;font-size:.6rem;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:var(--gray-400);background:var(--gray-50);border-bottom:1px solid var(--gray-100);white-space:nowrap}
        .tb tbody tr{transition:all .2s}.tb tbody tr:nth-child(even){background:var(--gray-50)}
        .tb tbody tr:hover{background:rgba(37,99,235,.03)}
        .tb tbody td{padding:14px 16px;font-size:.82rem;color:var(--gray-800);border-bottom:1px solid var(--gray-100)}
        .tb tbody tr:last-child td{border-bottom:none}
        .badge{display:inline-flex;padding:4px 10px;border-radius:999px;font-size:.68rem;font-weight:700}
        .badge-success{background:#d1fae5;color:#065f46}.badge-warning{background:#fef3c7;color:#92400e}.badge-danger{background:#fee2e2;color:#991b1b}
        .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:10px;font-size:.8rem;font-weight:600;text-decoration:none;transition:all .2s;cursor:pointer;border:none}
        .btn-primary{background:linear-gradient(135deg,var(--primary),#6366f1);color:#fff;box-shadow:0 4px 12px rgba(37,99,235,.25)}
        .btn-primary:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(37,99,235,.35)}
        .btn-sm{padding:5px 12px;font-size:.72rem;border-radius:8px;border:1px solid var(--gray-200);background:#fff;color:var(--gray-600);cursor:pointer;transition:all .2s;text-decoration:none;display:inline-flex;align-items:center;gap:4px}
        .btn-sm:hover{border-color:var(--primary);color:var(--primary)}
        .btn-sm-danger:hover{border-color:var(--danger);color:var(--danger)}
        .filter-row{display:flex;gap:6px}
        .filter-btn{padding:6px 14px;border-radius:999px;font-size:.74rem;font-weight:600;text-decoration:none;border:1px solid var(--gray-200);background:#fff;color:var(--gray-600);transition:all .2s}
        .filter-btn:hover,.filter-btn.on{background:var(--primary);color:#fff;border-color:var(--primary)}
        .text-muted{color:var(--gray-400)}.text-center{text-align:center}.text-sm{font-size:.72rem}.fw-600{font-weight:600}
        .section-title{font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--gray-400);margin-bottom:16px}
        .theme-toggle{width:38px;height:38px;border-radius:10px;border:1.5px solid var(--gray-200);background:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:1rem;transition:all .3s}
        .theme-toggle:hover{border-color:var(--primary)}
        body.dark{background:linear-gradient(135deg,#0f172a 0%,#1e293b 50%,#0f172a 100%);color:#e2e8f0}
        body.dark .hd{background:rgba(15,23,42,.9);border-bottom-color:rgba(255,255,255,.05)}
        body.dark .logo-n{color:#f1f5f9}
        body.dark .nl{color:#94a3b8}
        body.dark .nl:hover,body.dark .nl.on{background:rgba(37,99,235,.15);color:#60a5fa}
        body.dark .card{background:rgba(30,41,59,.8);border-color:rgba(255,255,255,.05)}
        body.dark .tb thead th{background:rgba(15,23,42,.6);color:#64748b;border-bottom-color:rgba(255,255,255,.04)}
        body.dark .tb tbody tr:nth-child(even){background:rgba(30,41,59,.3)}
        body.dark .tb tbody tr:hover{background:rgba(37,99,235,.08)}
        body.dark .tb tbody td{color:#cbd5e1;border-bottom-color:rgba(255,255,255,.04)}
        body.dark .filter-btn{background:#1e293b;border-color:#334155;color:#94a3b8}
        body.dark .btn-sm{background:#1e293b;border-color:#334155;color:#94a3b8}
        body.dark .lg-btn{color:#64748b}
        body.dark .lg-btn:hover{background:rgba(255,255,255,.05);color:#94a3b8}
        body.dark .theme-toggle{background:#1e293b;border-color:#334155}
        body.dark .card-header{border-bottom-color:rgba(255,255,255,.04)}
    </style>
</head>
<body>
    @include('layouts.header')
    <main class="pg">
        <div class="section-title">Atestados</div>
        <div class="card">
            <div class="card-header">
                <div class="filter-row">
                    <a href="{{ route('atestados.index') }}" class="filter-btn {{ !request('status')?'on':'' }}">Todos</a>
                    <a href="?status=pendente" class="filter-btn {{ request('status')=='pendente'?'on':'' }}">Pendentes</a>
                    <a href="?status=aprovado" class="filter-btn {{ request('status')=='aprovado'?'on':'' }}">Aprovados</a>
                    <a href="?status=reprovado" class="filter-btn {{ request('status')=='reprovado'?'on':'' }}">Reprovados</a>
                </div>
                <a href="{{ route('atestados.create') }}" class="btn btn-primary">+ Novo Atestado</a>
            </div>
            <div class="table-responsive">
                <table class="tb">
                    <thead><tr>
                        @if($atual->isGestor())<th>Funcionario</th>@endif
                        <th>Tipo</th><th>Periodo</th><th class="text-center">Dias</th><th class="text-center">Cobre Horas</th><th class="text-center">Status</th><th>Acoes</th>
                    </tr></thead>
                    <tbody>
                        @forelse($atestados as $a)
                        <tr>
                            @if($atual->isGestor())<td><span class="fw-600">{{ $a->funcionario->nome }}</span><br><span class="text-muted text-sm">{{ $a->funcionario->cargo }}</span></td>@endif
                            <td>{{ $a->tipoLabel() }}</td>
                            <td>{{ $a->data_inicio->format('d/m/Y') }}{{ !$a->data_inicio->equalTo($a->data_fim)?' → '.$a->data_fim->format('d/m/Y'):'' }}</td>
                            <td class="text-center">{{ $a->dias_afastamento }}d</td>
                            <td class="text-center"><span class="badge {{ $a->cobre_horas?'badge-success':'badge-warning' }}">{{ $a->cobre_horas?'Sim':'Nao' }}</span></td>
                            <td class="text-center"><span class="badge {{ $a->status=='aprovado'?'badge-success':($a->status=='reprovado'?'badge-danger':'badge-warning') }}">{{ $a->statusLabel() }}</span></td>
                            <td>
                                <a href="{{ route('atestados.show',$a) }}" class="btn-sm">Ver</a>
                                @if($atual->isGestor()&&$a->status=='pendente')
                                <form method="POST" action="{{ route('atestados.aprovar',$a) }}" style="display:inline">@csrf<button class="btn-sm" style="color:#059669">Aprovar</button></form>
                                <form method="POST" action="{{ route('atestados.reprovar',$a) }}" style="display:inline">@csrf<button class="btn-sm btn-sm-danger">Reprovar</button></form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="{{ $atual->isGestor()?7:6 }}" class="text-center text-muted py-4">Nenhum atestado encontrado.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <script src="/js/dark.js"></script>
</body>
</html>