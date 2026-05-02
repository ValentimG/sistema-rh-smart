<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8"><link rel="icon" href="/favicon.svg" type="image/svg+xml"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Meu Perfil — SMART RH</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <style>
        .profile-section { background: #fff; border: 1px solid var(--gray-200); border-radius: 16px; padding: 28px; margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,.04); }
        .profile-section-title { font-size: 1rem; font-weight: 700; color: var(--gray-900); margin-bottom: 4px; }
        .profile-section-desc { font-size: .82rem; color: var(--gray-400); margin-bottom: 24px; }
        .profile-section-danger { border-color: #fecaca; }
        .profile-section-danger .profile-section-title { color: var(--danger); }
        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: .78rem; font-weight: 600; color: var(--gray-800); margin-bottom: 5px; }
        .form-input { width: 100%; padding: 11px 16px; border: 1.5px solid var(--gray-200); border-radius: 10px; font-size: .87rem; outline: none; background: #fff; }
        .form-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37,99,235,.08); }
        .alert-success { background: #dcfce7; color: #065f46; border: 1px solid #a7f3d0; padding: 12px 16px; border-radius: 10px; margin-bottom: 18px; font-size: .82rem; }
        .btn-danger { background: var(--danger); color: #fff; }
        .btn-danger:hover { background: #dc2626; }
        body.dark .profile-section { background: rgba(30,41,59,.8); border-color: rgba(255,255,255,.05); }
        body.dark .profile-section-title { color: #f1f5f9; }
        body.dark .profile-section-desc { color: #64748b; }
        body.dark .form-label { color: #cbd5e1; }
        body.dark .form-input { background: #1e293b; border-color: #334155; color: #e2e8f0; }
        body.dark .profile-section-danger { border-color: rgba(239,68,68,.3); }
    </style>
</head>
<body>
    @include('layouts.header')
    <main class="pg" style="max-width:560px">
        @if(session('status') === 'profile-updated')
        <div class="alert-success">Perfil atualizado com sucesso.</div>
        @endif

        <div class="profile-section">
            <div class="profile-section-title">Informacoes do Perfil</div>
            <div class="profile-section-desc">Atualize seu nome e e-mail.</div>
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="profile-section">
            <div class="profile-section-title">Alterar Senha</div>
            <div class="profile-section-desc">Use uma senha longa e segura.</div>
            @include('profile.partials.update-password-form')
        </div>

        <div class="profile-section profile-section-danger">
            <div class="profile-section-title">Excluir Conta</div>
            <div class="profile-section-desc">Ao excluir sua conta, todos os dados serao permanentemente removidos.</div>
            @include('profile.partials.delete-user-form')
        </div>
    </main>
    <script src="/js/dark.js"></script>
</body>
</html>
