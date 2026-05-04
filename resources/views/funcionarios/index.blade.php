<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Funcionarios — SMART RH</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    @include('layouts.header')
    <main class="pg">
        <div class="page-header">
            <div>
                <h1 class="page-title">Funcionarios</h1>
                <p class="page-sub">Gerencie todos os colaboradores</p>
            </div>
            <a href="{{ route('funcionarios.create') }}" class="btn btn-primary btn-add">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Novo Funcionario
            </a>
        </div>

        <div class="stats-grid">
            <div class="stat-card stat-card-primary">
                <div class="stat-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                </div>
                <div class="stat-value">{{ $funcionarios->total() }}</div>
                <div class="stat-label">Total de Funcionarios</div>
            </div>
            <div class="stat-card stat-card-success">
                <div class="stat-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <div class="stat-value">R$ {{ number_format($totalFolha, 0, ',', '.') }}</div>
                <div class="stat-label">Folha Mensal</div>
            </div>
            <div class="stat-card stat-card-warning">
                <div class="stat-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                </div>
                <div class="stat-value">R$ {{ number_format($mediaSalario, 0, ',', '.') }}</div>
                <div class="stat-label">Media Salarial</div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <input type="text" class="search-box" placeholder="Buscar por nome ou cargo..." oninput="filtrar(this.value)">
                <span class="text-muted text-sm">{{ $funcionarios->total() }} funcionarios</span>
            </div>
            <div class="table-responsive">
                <table class="tb" id="tabela-func">
                    <thead><tr>
                        <th>Funcionario</th>
                        <th>Cargo</th>
                        <th>Tipo</th>
                        <th>Admissao</th>
                        <th>Salario</th>
                        <th class="text-center">Acoes</th>
                    </tr></thead>
                    <tbody>
                        @forelse($funcionarios as $f)
                        <tr data-nome="{{ strtolower($f->nome) }}" data-cargo="{{ strtolower($f->cargo) }}">
                            <td>
                                <div class="func-cell">
                                    <div class="func-avatar" style="background:{{ ['#2563eb','#059669','#d97706','#dc2626','#0891b2','#7c3aed'][$f->id % 6] }}">{{ strtoupper(substr($f->nome, 0, 1)) }}</div>
                                    <div>
                                        <span class="fw-600">{{ $f->nome }}</span>
                                        <span class="text-muted text-sm" style="display:block">{{ $f->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $f->cargo }}</td>
                            <td><span class="badge {{ $f->isGestor() ? 'badge-gestor' : 'badge-func' }}">{{ $f->isGestor() ? 'Gestor' : 'Funcionario' }}</span></td>
                            <td>{{ $f->data_admissao->format('d/m/Y') }}</td>
                            <td class="fw-600">{{ $f->salario_base ? 'R$ ' . number_format($f->salario_base, 0, ',', '.') : '—' }}</td>
                            <td class="text-center">
                                <div class="action-group">
                                    <a href="{{ route('funcionarios.show', $f) }}" class="btn-sm">Ver</a>
                                    <a href="{{ route('funcionarios.edit', $f) }}" class="btn-sm">Editar</a>
                                    <a href="{{ route('gestor.extrato', $f) }}" class="btn-sm">Extrato</a>
                                </div>
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
        function filtrar(valor) {
            var termo = valor.toLowerCase();
            document.querySelectorAll('#tabela-func tbody tr').forEach(function(tr) {
                tr.style.display = tr.dataset.nome.includes(termo) || tr.dataset.cargo.includes(termo) ? '' : 'none';
            });
        }
    </script>
    <script src="/js/dark.js"></script>
</body>
</html>