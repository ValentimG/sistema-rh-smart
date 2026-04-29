<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SMART RH') }} — Login</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><rect width='32' height='32' rx='6' fill='%234f46e5'/><text x='4' y='23' fill='white' font-family='system-ui' font-weight='800' font-size='15'>RH</text></svg>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/rh-theme.css">
    <script>if(localStorage.getItem('rhDark')==='1')document.documentElement.classList.add('dark')</script>
    <script src="/rh.js" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
    *{font-family:'Inter',sans-serif;box-sizing:border-box;margin:0;padding:0}
    body{min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px;position:relative;overflow-y:auto;background:#0f172a}
    body::before{content:'';position:fixed;inset:0;background:radial-gradient(ellipse 80% 60% at 20% 40%,rgba(79,70,229,.35) 0%,transparent 60%),radial-gradient(ellipse 60% 80% at 80% 60%,rgba(6,182,212,.2) 0%,transparent 60%);pointer-events:none}
    html:not(.dark) body{background:#f0f4ff}
    html:not(.dark) body::before{background:radial-gradient(ellipse 80% 60% at 20% 40%,rgba(79,70,229,.15) 0%,transparent 60%),radial-gradient(ellipse 60% 80% at 80% 60%,rgba(6,182,212,.1) 0%,transparent 60%)}
    .login-wrap{width:100%;max-width:420px;z-index:1}
    .login-logo{text-align:center;margin-bottom:28px}
    .login-logo-mark{width:60px;height:60px;background:#4f46e5;border-radius:14px;display:inline-flex;align-items:center;justify-content:center;font-weight:900;color:#fff;font-size:1.1rem;letter-spacing:-.5px;margin-bottom:12px;box-shadow:0 8px 24px rgba(79,70,229,.4)}
    .login-name{font-size:1.4rem;font-weight:800;color:#fff;letter-spacing:1px}
    html:not(.dark) .login-name{color:#1e293b}
    .login-sub{font-size:.72rem;color:#64748b;font-weight:500;margin-top:3px;letter-spacing:.5px}
    .login-card{background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.12);border-radius:16px;padding:32px 36px;backdrop-filter:blur(16px);box-shadow:0 20px 60px rgba(0,0,0,.3)}
    html:not(.dark) .login-card{background:rgba(255,255,255,.95);border-color:rgba(0,0,0,.08);box-shadow:0 8px 40px rgba(79,70,229,.12)}
    .login-card .mt-1{margin-top:4px}
    .login-card .block{width:100%}
    .login-card .mt-4{margin-top:16px}
    .login-card .mt-6{margin-top:20px}
    .login-card .mb-4{margin-bottom:16px}
    </style>
</head>
<body>
<div class="login-wrap">
    <div class="login-logo">
        <div class="login-logo-mark">RH</div>
        <div class="login-name">SMART RH</div>
        <div class="login-sub">SISTEMA DE GESTÃO DE RECURSOS HUMANOS</div>
    </div>
    <div class="login-card">
        {{ $slot }}
    </div>
</div>
</body>
</html>