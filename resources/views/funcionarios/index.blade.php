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
                                <a href="{{ route('gestor.extrato', $f) }}" class="btn-sm">Extrato</a>
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