<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $funcionario->nome }} — SMART RH</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    @php $ini = collect(explode(' ',$funcionario->nome))->map(fn($p)=>strtoupper($p[0]))->take(2)->implode(''); @endphp
    @php $cores=['#2563eb','#059669','#d97706','#dc2626','#0891b2','#7c3aed']; $cor=$cores[$funcionario->id%count($cores)]; @endphp
    @include('layouts.header')

    <main class="pg pg-sm">
        <a href="{{ route('funcionarios.index') }}" class="back-link">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
            Voltar para Funcionarios
        </a>

        <div class="employee-hero">
            <div class="employee-hero-avatar" style="background:{{ $cor }}">{{ $ini }}</div>
            <div class="employee-hero-info">
                <h1 class="employee-hero-name">{{ $funcionario->nome }}</h1>
                <p class="employee-hero-role">{{ $funcionario->cargo }}</p>
                <div class="employee-hero-badges">
                    <span class="badge {{ $funcionario->isGestor()?'badge-gestor':'badge-func' }}">{{ $funcionario->isGestor()?'Gestor':'Funcionario' }}</span>
                    <span class="badge badge-info">{{ strtoupper($funcionario->tipo_contrato ?? 'CLT') }}</span>
                    <span class="badge badge-success">{{ $funcionario->data_admissao->diffForHumans(null,true) }} de casa</span>
                </div>
            </div>
            <div class="employee-hero-actions">
                <a href="{{ route('funcionarios.edit',$funcionario) }}" class="btn btn-primary">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Editar
                </a>
            </div>
        </div>

        <div class="grid-3">
            <div class="card card-detail">
                <div class="card-header-detail">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Dados Pessoais
                </div>
                <div class="card-body-detail">
                    <div class="detail-item"><span class="detail-label">E-mail</span><span class="detail-value">{{ $funcionario->email }}</span></div>
                    <div class="detail-item"><span class="detail-label">CPF</span><span class="detail-value mono">{{ $funcionario->cpfFormatado }}</span></div>
                    <div class="detail-item"><span class="detail-label">Telefone</span><span class="detail-value">{{ $funcionario->telefone ?? '—' }}</span></div>
                    <div class="detail-item"><span class="detail-label">Nascimento</span><span class="detail-value">{{ $funcionario->data_nascimento?->format('d/m/Y') ?? '—' }}</span></div>
                    <div class="detail-item"><span class="detail-label">Endereco</span><span class="detail-value">{{ $funcionario->endereco }}</span></div>
                </div>
            </div>

            <div class="card card-detail">
                <div class="card-header-detail">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    Contrato
                </div>
                <div class="card-body-detail">
                    <div class="detail-item"><span class="detail-label">Tipo</span><span class="detail-value">{{ $funcionario->tipoContratoLabel() }}</span></div>
                    <div class="detail-item"><span class="detail-label">Admissao</span><span class="detail-value">{{ $funcionario->data_admissao->format('d/m/Y') }}</span></div>
                    <div class="detail-item"><span class="detail-label">Tempo</span><span class="detail-value">{{ $funcionario->data_admissao->diffForHumans(null,true) }}</span></div>
                    @if($funcionario->beneficios)
                    <div class="detail-item"><span class="detail-label">Beneficios</span><span class="detail-value tags">@foreach($funcionario->beneficios as $b)<span class="tag">{{ $b }}</span>@endforeach</span></div>
                    @endif
                </div>
            </div>

            <div class="card card-detail">
                <div class="card-header-detail">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    Remuneracao
                </div>
                <div class="card-body-detail">
                    <div class="detail-item"><span class="detail-label">Salario</span><span class="detail-value highlight">{{ $funcionario->salario_base ? 'R$ '.number_format($funcionario->salario_base,2,',','.') : '—' }}</span></div>
                    <div class="detail-item"><span class="detail-label">Valor/Hora</span><span class="detail-value mono">{{ $funcionario->salario_base ? 'R$ '.number_format($funcionario->valorHora(),2,',','.') : '—' }}</span></div>
                    <div class="detail-item"><span class="detail-label">Carga Horaria</span><span class="detail-value">{{ $funcionario->carga_horaria_mensal }}h/mes</span></div>
                    <div class="detail-item"><span class="detail-label">Banco de Horas</span><span class="detail-value {{ $funcionario->banco_horas >= 0 ? 'text-success' : 'text-danger' }} fw-700">{{ number_format($funcionario->banco_horas,2,',','.') }}h</span></div>
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

        <div id="tab-atestados" class="tab-panel act"><div class="table-responsive"><table class="tb"><thead><tr><th>Tipo</th><th>Periodo</th><th class="tc">Dias</th><th class="tc">Cobre Horas</th><th class="tc">Status</th><th></th></tr></thead><tbody>@forelse($funcionario->atestados as $a)<tr><td>{{ $a->tipoLabel() }}</td><td>{{ $a->data_inicio->format('d/m/Y') }}@if(!$a->data_inicio->equalTo($a->data_fim)) → {{ $a->data_fim->format('d/m/Y') }}@endif</td><td class="tc">{{ $a->dias_afastamento }}d</td><td class="tc"><span class="badge {{ $a->cobre_horas?'badge-success':'badge-warning' }}">{{ $a->cobre_horas?'Sim':'Nao' }}</span></td><td class="tc"><span class="badge {{ $a->status=='aprovado'?'badge-success':($a->status=='reprovado'?'badge-danger':'badge-warning') }}">{{ $a->statusLabel() }}</span></td><td class="tr"><a href="{{ route('atestados.show',$a) }}" class="btn-sm">Ver</a></td></tr>@empty<tr><td colspan="6" class="text-center text-muted py-4">Nenhum atestado registrado.</td></tr>@endforelse</tbody></table></div></div>
        <div id="tab-cargos" class="tab-panel"><div class="table-responsive"><table class="tb"><thead><tr><th>Cargo</th><th>Inicio</th><th>Fim</th><th class="tc">Status</th></tr></thead><tbody>@forelse($funcionario->historicoCargos as $hc)<tr><td class="fw-600">{{ $hc->cargo }}</td><td>{{ $hc->data_inicio->format('d/m/Y') }}</td><td>{{ $hc->data_fim?->format('d/m/Y') ?? '—' }}</td><td class="tc"><span class="badge {{ $hc->isAtual()?'badge-success':'badge-warning' }}">{{ $hc->isAtual()?'Atual':'Encerrado' }}</span></td></tr>@empty<tr><td colspan="4" class="text-center text-muted py-4">Nenhum historico de cargo.</td></tr>@endforelse</tbody></table></div></div>
        <div id="tab-afastamentos" class="tab-panel"><div class="table-responsive"><table class="tb"><thead><tr><th>Tipo</th><th>Inicio</th><th>Fim</th><th class="tc">Dias</th></tr></thead><tbody>@forelse($funcionario->historicoAfastamentos as $af)<tr><td>{{ $af->tipoLabel() }}</td><td>{{ $af->data_inicio->format('d/m/Y') }}</td><td>{{ $af->data_fim->format('d/m/Y') }}</td><td class="tc">{{ $af->dias }}d</td></tr>@empty<tr><td colspan="4" class="text-center text-muted py-4">Nenhum afastamento registrado.</td></tr>@endforelse</tbody></table></div></div>
    </main>

    <script>function showTab(id,btn){document.querySelectorAll('.tab-panel').forEach(p=>p.classList.remove('act'));document.querySelectorAll('.tab-btn').forEach(b=>b.classList.remove('act'));document.getElementById('tab-'+id).classList.add('act');btn.classList.add('act');}</script>
    <script src="/js/dark.js"></script>
</body>
</html>