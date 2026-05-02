<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"><link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SMART RH') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *{box-sizing:border-box;margin:0;padding:0;font-family:'Inter',sans-serif}
        body{background:#f8f9fa;color:#111827;min-height:100vh}
        .hd{background:#fff;border-bottom:1px solid #e5e7eb;padding:0 40px;height:60px;display:flex;align-items:center;justify-content:space-between}
        .logo{display:flex;align-items:center;gap:10px}
        .logo-ic{width:32px;height:32px;background:#2563eb;border-radius:7px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:900;font-size:.72rem}
        .logo-n{font-size:.9rem;font-weight:700;color:#111827}
        .logo-s{font-size:.58rem;color:#9ca3af;font-weight:500}
        .hd-r{display:flex;align-items:center;gap:12px}
        .nav{display:flex;gap:2px}
        .nl{display:flex;align-items:center;gap:6px;padding:7px 13px;border-radius:7px;color:#6b7280;text-decoration:none;font-size:.8rem;font-weight:500;transition:.15s}
        .nl:hover,.nl.on{background:#eff6ff;color:#2563eb}
        .av{width:34px;height:34px;background:#2563eb;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.78rem;flex-shrink:0}
        .lg-btn{display:flex;align-items:center;gap:5px;padding:7px 12px;border-radius:7px;color:#9ca3af;font-size:.8rem;font-weight:500;background:none;border:none;cursor:pointer;transition:.15s}
        .lg-btn:hover{background:#f3f4f6;color:#374151}
        .pg{max-width:600px;margin:0 auto;padding:40px 24px}
        .card{background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:24px;margin-bottom:20px}
        .card-tt{font-size:1rem;font-weight:600;color:#111827;margin-bottom:16px}
        .btn-p{background:#2563eb;color:#fff;border:none;padding:10px 24px;border-radius:7px;font-weight:600;font-size:.87rem;cursor:pointer;transition:.2s}
        .btn-p:hover{background:#1d4ed8}
        .form-group{margin-bottom:16px}
        .form-label{display:block;font-size:.8rem;font-weight:600;color:#374151;margin-bottom:5px}
        .form-input{width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:7px;font-size:.9rem;outline:none}
        .form-input:focus{border-color:#2563eb}
        .alert{padding:12px 16px;border-radius:8px;font-size:.82rem;font-weight:500;margin-bottom:18px}
        .alert-ok{background:#dcfce7;color:#065f46;border:1px solid #a7f3d0}
    </style>
</head>
<body>
    @php
        $navFunc = Auth::user()->funcionario ?? null;
    @endphp
    <header class="hd">
        <div class="logo">
            <div class="logo-ic">RH</div>
            <div><div class="logo-n">SMART RH</div><div class="logo-s">SISTEMA DE RH</div></div>
        </div>
        <div class="hd-r">
            <nav class="nav">
                @if($navFunc && $navFunc->isGestor())
                <a href="{{ route('gestor.dashboard') }}" class="nl">Dashboard</a>
                <a href="{{ route('funcionarios.index') }}" class="nl">Funcionarios</a>
                <a href="{{ route('atestados.index') }}" class="nl">Atestados</a>
                @else
                <a href="{{ route('ponto.index') }}" class="nl">Meu Ponto</a>
                <a href="{{ route('atestados.index') }}" class="nl">Atestados</a>
                @endif
            </nav>
            <div class="av">{{ strtoupper(substr(Auth::user()->name,0,1)) }}</div>
            <form method="POST" action="{{ route('logout') }}">@csrf
                <button type="submit" class="lg-btn">Sair</button>
            </form>
        </div>
    </header>
    <main class="pg">
        @if(session('success'))
        <div class="alert alert-ok">{{ session('success') }}</div>
        @endif
        {{ $slot }}
    </main>
</body>
</html>
