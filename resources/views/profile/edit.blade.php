<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Meu Perfil — SMART RH</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    @include('layouts.header')
    <main class="pg" style="max-width:720px">
        @php $f = Auth::user()->funcionario; @endphp

        @if(session('status') === 'profile-updated')
        <div class="alert alert-success">Perfil atualizado com sucesso.</div>
        @endif

        <div class="profile-hero">
            <div class="profile-avatar" style="background:{{ ['#2563eb','#059669','#d97706','#dc2626','#0891b2','#7c3aed'][$f->id % 6] }}">
                {{ strtoupper(substr($f->nome, 0, 1)) }}
            </div>
            <div>
                <h2 class="profile-name">{{ $f->nome }}</h2>
                <p class="profile-cargo">{{ $f->cargo }}</p>
                <div style="margin-top:6px">
                    <span class="badge {{ $f->isGestor() ? 'badge-gestor' : 'badge-func' }}">{{ $f->isGestor() ? 'Gestor' : 'Funcionario' }}</span>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><span class="card-title">Informacoes Pessoais</span><span class="badge badge-info">Editavel</span></div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf @method('patch')
                    <div class="form-row">
                        <div class="form-group"><label class="form-label">Nome</label><input type="text" name="name" class="form-input" value="{{ old('name', auth()->user()->name) }}"></div>
                        <div class="form-group"><label class="form-label">E-mail</label><input type="email" name="email" class="form-input" value="{{ old('email', auth()->user()->email) }}"></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group"><label class="form-label">CPF</label><input type="text" class="form-input" value="{{ $f->cpfFormatado }}" readonly style="background:var(--gray-50);cursor:not-allowed"></div>
                        <div class="form-group"><label class="form-label">Telefone</label><input type="text" class="form-input" value="{{ $f->telefone ?? '—' }}" readonly style="background:var(--gray-50);cursor:not-allowed"></div>
                    </div>
                    <div class="form-group"><label class="form-label">Endereco</label><input type="text" class="form-input" value="{{ $f->endereco }}" readonly style="background:var(--gray-50);cursor:not-allowed"></div>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><span class="card-title">Dados Profissionais</span><span class="badge badge-warning">Somente leitura</span></div>
            <div class="card-body">
                <div class="info-grid-2">
                    <div class="info-card">
                        <div class="info-card-icon bg-blue-light"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg></div>
                        <div class="info-card-label">Cargo</div>
                        <div class="info-card-value">{{ $f->cargo }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-card-icon bg-green-light"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg></div>
                        <div class="info-card-label">Admissao</div>
                        <div class="info-card-value">{{ $f->data_admissao->format('d/m/Y') }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-card-icon bg-purple-light"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div>
                        <div class="info-card-label">Salario</div>
                        <div class="info-card-value text-success fw-700">{{ $f->salario_base ? 'R$ '.number_format($f->salario_base, 2, ',', '.') : '—' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-card-icon bg-orange-light"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                        <div class="info-card-label">Banco de Horas</div>
                        <div class="info-card-value {{ $f->banco_horas >= 0 ? 'text-success' : 'text-danger' }} fw-700">{{ number_format($f->banco_horas, 1, ',', '.') }}h</div>
                    </div>
                    <div class="info-card">
                        <div class="info-card-icon" style="background:rgba(37,99,235,.1);color:var(--primary)"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                        <div class="info-card-label">Carga Horaria</div>
                        <div class="info-card-value">{{ $f->carga_horaria_mensal }}h/mes</div>
                    </div>
                    <div class="info-card">
                        <div class="info-card-icon" style="background:rgba(245,158,11,.1);color:var(--warning)"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg></div>
                        <div class="info-card-label">Valor por Hora</div>
                        <div class="info-card-value text-success fw-700">{{ $f->salario_base ? 'R$ '.number_format($f->valorHora(), 2, ',', '.') : '—' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><span class="card-title">Alterar Senha</span></div>
            <div class="card-body">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf @method('put')
                    <div class="form-group"><label class="form-label">Senha Atual</label><input type="password" name="current_password" class="form-input"></div>
                    <div class="form-group"><label class="form-label">Nova Senha</label><input type="password" name="password" class="form-input"></div>
                    <div class="form-group"><label class="form-label">Confirmar</label><input type="password" name="password_confirmation" class="form-input"></div>
                    <button type="submit" class="btn btn-primary">Alterar Senha</button>
                </form>
            </div>
        </div>
    </main>
    <script src="/js/dark.js"></script>
</body>
</html>