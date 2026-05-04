<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $funcionario->nome }} — SMART RH</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    @php
        $ini = collect(explode(' ',$funcionario->nome))->map(fn($p)=>strtoupper($p[0]))->take(2)->implode('');
        $cores=['#2563eb','#059669','#d97706','#dc2626','#0891b2','#7c3aed'];
        $cor = $cores[$funcionario->id % count($cores)];
    @endphp
    @include('layouts.header')

    <main class="pg">
        <a href="{{ route('funcionarios.index') }}" class="back-link">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            Voltar para Funcionarios
        </a>

        <div class="profile-hero">
            <div class="profile-avatar" style="background:{{ $cor }}">{{ $ini }}</div>
            <div>
                <h2 class="profile-name">{{ $funcionario->nome }}</h2>
                <p class="profile-cargo">{{ $funcionario->cargo }}</p>
                <div style="margin-top:6px;display:flex;gap:6px">
                    <span class="badge {{ $funcionario->isGestor()?'badge-gestor':'badge-func' }}">{{ $funcionario->isGestor()?'Gestor':'Funcionario' }}</span>
                    <span class="badge badge-info">{{ strtoupper($funcionario->tipo_contrato ?? 'CLT') }}</span>
                </div>
            </div>
            <div style="margin-left:auto;display:flex;gap:8px">
                <a href="{{ route('funcionarios.edit',$funcionario) }}" class="btn btn-primary">Editar</a>
                <a href="{{ route('funcionarios.index') }}" class="btn btn-secondary">Voltar</a>
            </div>
        </div>

        <div class="grid-3">
            <div class="card">
                <div class="card-header"><span class="card-title">Dados Pessoais</span></div>
                <div class="card-body">
                    <div class="info-list">
                        <div class="info-row"><span class="info-label">E-mail</span><span class="info-value">{{ $funcionario->email }}</span></div>
                        <div class="info-row"><span class="info-label">CPF</span><span class="info-value">{{ $funcionario->cpfFormatado }}</span></div>
                        <div class="info-row"><span class="info-label">Telefone</span><span class="info-value">{{ $funcionario->telefone ?? '—' }}</span></div>
                        <div class="info-row"><span class="info-label">Nascimento</span><span class="info-value">{{ $funcionario->data_nascimento?->format('d/m/Y') ?? '—' }}</span></div>
                        <div class="info-row"><span class="info-label">Endereco</span><span class="info-value">{{ $funcionario->endereco }}</span></div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><span class="card-title">Contrato</span></div>
                <div class="card-body">
                    <div class="info-list">
                        <div class="info-row"><span class="info-label">Tipo</span><span class="info-value">{{ $funcionario->tipoContratoLabel() }}</span></div>
                        <div class="info-row"><span class="info-label">Admissao</span><span class="info-value">{{ $funcionario->data_admissao->format('d/m/Y') }}</span></div>
                        <div class="info-row"><span class="info-label">Tempo</span><span class="info-value">{{ $funcionario->data_admissao->diffForHumans(null,true) }}</span></div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><span class="card-title">Remuneracao</span></div>
                <div class="card-body">
                    <div class="info-list">
                        <div class="info-row"><span class="info-label">Salario</span><span class="info-value text-success fw-700">{{ $funcionario->salario_base ? 'R$ '.number_format($funcionario->salario_base,2,',','.') : '—' }}</span></div>
                        <div class="info-row"><span class="info-label">Valor/Hora</span><span class="info-value">{{ $funcionario->salario_base ? 'R$ '.number_format($funcionario->valorHora(),2,',','.') : '—' }}</span></div>
                        <div class="info-row"><span class="info-label">Carga Horaria</span><span class="info-value">{{ $funcionario->carga_horaria_mensal }}h/mes</span></div>
                        <div class="info-row"><span class="info-label">Banco de Horas</span><span class="info-value {{ $funcionario->banco_horas >= 0 ? 'text-success' : 'text-danger' }} fw-700">{{ number_format($funcionario->banco_horas,2,',','.') }}h</span></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tabs-wrap">
            <div class="tabs">
                <button class="tab-btn act" onclick="showTab('atestados',this)">Atestados @if($funcionario->atestadosPendentes()->count()>0)<span class="tab-badge">{{ $funcionario->atestadosPendentes()->count() }}</span>@endif</button>
                <button class="tab-btn" onclick="showTab('cargos',this)">Historico de Cargos</button>
                <button class="tab-btn" onclick="showTab('afastamentos',this)">Afastamentos</button>
            </div>
            <a href="{{ route('atestados.create',['funcionario_id'=>$funcionario->id]) }}" class="btn btn-primary" style="margin-bottom:1px">+ Novo Atestado</a>
        </div>

        <div id="tab-atestados" class="tab-panel act">
            <table class="tb"><thead><tr><th>Tipo</th><th>Periodo</th><th class="tc">Dias</th><th class="tc">Cobre Horas</th><th class="tc">Status</th><th></th></tr></thead><tbody>
                @forelse($funcionario->atestados as $a)
                <tr><td>{{ $a->tipoLabel() }}</td><td>{{ $a->data_inicio->format('d/m/Y') }}@if(!$a->data_inicio->equalTo($a->data_fim)) → {{ $a->data_fim->format('d/m/Y') }}@endif</td><td class="tc">{{ $a->dias_afastamento }}d</td><td class="tc"><span class="badge {{ $a->cobre_horas?'badge-success':'badge-warning' }}">{{ $a->cobre_horas?'Sim':'Nao' }}</span></td><td class="tc"><span class="badge {{ $a->status=='aprovado'?'badge-success':($a->status=='reprovado'?'badge-danger':'badge-warning') }}">{{ $a->statusLabel() }}</span></td><td class="tr"><a href="{{ route('atestados.show',$a) }}" class="btn-sm">Ver</a></td></tr>
                @empty<tr><td colspan="6" class="text-center text-muted py-4">Nenhum atestado registrado.</td></tr>
                @endforelse
            </tbody></table>
        </div>

        <div id="tab-cargos" class="tab-panel">
            <table class="tb"><thead><tr><th>Cargo</th><th>Inicio</th><th>Fim</th><th class="tc">Status</th></tr></thead><tbody>
                @forelse($funcionario->historicoCargos as $hc)
                <tr><td class="fw-600">{{ $hc->cargo }}</td><td>{{ $hc->data_inicio->format('d/m/Y') }}</td><td>{{ $hc->data_fim?->format('d/m/Y') ?? '—' }}</td><td class="tc"><span class="badge {{ $hc->isAtual()?'badge-success':'badge-warning' }}">{{ $hc->isAtual()?'Atual':'Encerrado' }}</span></td></tr>
                @empty<tr><td colspan="4" class="text-center text-muted py-4">Nenhum historico de cargo.</td></tr>
                @endforelse
            </tbody></table>
        </div>

        <div id="tab-afastamentos" class="tab-panel">
            <table class="tb"><thead><tr><th>Tipo</th><th>Inicio</th><th>Fim</th><th class="tc">Dias</th></tr></thead><tbody>
                @forelse($funcionario->historicoAfastamentos as $af)
                <tr><td>{{ $af->tipoLabel() }}</td><td>{{ $af->data_inicio->format('d/m/Y') }}</td><td>{{ $af->data_fim->format('d/m/Y') }}</td><td class="tc">{{ $af->dias }}d</td></tr>
                @empty<tr><td colspan="4" class="text-center text-muted py-4">Nenhum afastamento registrado.</td></tr>
                @endforelse
            </tbody></table>
        </div>
    </main>

    <script>
        function showTab(id,btn){document.querySelectorAll('.tab-panel').forEach(p=>p.classList.remove('act'));document.querySelectorAll('.tab-btn').forEach(b=>b.classList.remove('act'));document.getElementById('tab-'+id).classList.add('act');btn.classList.add('act');}
    </script>
    <script src="/js/dark.js"></script>
</body>
</html>