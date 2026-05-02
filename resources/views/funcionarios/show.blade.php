<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8"><link rel="icon" href="/favicon.svg" type="image/svg+xml"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $funcionario->nome }} — SMART RH</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <style>
        .profile-card { background: #fff; border: 1px solid var(--gray-200); border-radius: 16px; padding: 24px; margin-bottom: 20px; display: flex; align-items: center; gap: 18px; box-shadow: 0 1px 3px rgba(0,0,0,.04); }
        .pav { width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.3rem; color: #fff; flex-shrink: 0; }
        .pname { font-size: 1.15rem; font-weight: 700; color: var(--gray-900); }
        .pcargo { font-size: .82rem; color: var(--gray-400); margin-top: 2px; }
        .pbadge { display: flex; gap: 6px; margin-top: 6px; }
        .badge { display: inline-flex; padding: 4px 10px; border-radius: 999px; font-size: .7rem; font-weight: 700; }
        .bg-g { background: #ede9fe; color: #5b21b6; } .bg-f { background: var(--gray-100); color: var(--gray-600); } .bg-clt { background: #dbeafe; color: #1e40af; }
        .pacts { margin-left: auto; display: flex; gap: 8px; }
        .grid3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 20px; }
        .sec { background: #fff; border: 1px solid var(--gray-200); border-radius: 16px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.04); }
        .sec-h { padding: 14px 18px; border-bottom: 1px solid var(--gray-100); font-size: .67rem; font-weight: 700; text-transform: uppercase; letter-spacing: .8px; color: var(--gray-400); background: var(--gray-50); }
        .fd { padding: 12px 18px; border-bottom: 1px solid var(--gray-100); }
        .fd:last-child { border-bottom: none; }
        .fl { font-size: .63rem; font-weight: 700; text-transform: uppercase; color: var(--gray-400); }
        .fv { font-size: .83rem; font-weight: 500; color: var(--gray-900); margin-top: 2px; }
        .fv-hi { color: var(--success); font-weight: 700; }
        .tags { display: flex; flex-wrap: wrap; gap: 5px; margin-top: 4px; }
        .tag { background: #eff6ff; color: var(--primary); padding: 2px 8px; border-radius: 999px; font-size: .68rem; font-weight: 600; }
        .tabs-wrap { display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 0; }
        .tabs { display: flex; gap: 2px; }
        .tab-btn { padding: 9px 16px; border: 1px solid var(--gray-200); border-bottom: none; border-radius: 8px 8px 0 0; font-size: .8rem; font-weight: 600; color: var(--gray-600); background: var(--gray-50); cursor: pointer; transition: all .2s; }
        .tab-btn.act { background: #fff; color: var(--primary); border-color: var(--primary); border-bottom-color: #fff; position: relative; z-index: 1; }
        .tab-panel { display: none; background: #fff; border: 1px solid var(--gray-200); border-radius: 0 8px 8px 8px; overflow: hidden; }
        .tab-panel.act { display: block; }
        .bge { display: inline-flex; padding: 2px 9px; border-radius: 999px; font-size: .68rem; font-weight: 700; }
        .st-a { background: #d1fae5; color: #065f46; } .st-p { background: #fef3c7; color: #92400e; } .st-r { background: #fee2e2; color: #991b1b; }
        .emp { text-align: center; padding: 28px; color: var(--gray-400); font-size: .82rem; }
        .alert { padding: 12px 16px; border-radius: 10px; font-size: .82rem; margin-bottom: 16px; }
        .a-ok { background: #dcfce7; color: #065f46; border: 1px solid #a7f3d0; }
        .btn-sm { padding: 5px 12px; font-size: .72rem; border-radius: 8px; border: 1px solid var(--gray-200); background: #fff; color: var(--gray-600); cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; font-weight: 600; transition: all .2s; }
        .btn-sm:hover { border-color: var(--primary); color: var(--primary); }
        body.dark .profile-card, body.dark .sec { background: rgba(30,41,59,.8); border-color: rgba(255,255,255,.05); }
        body.dark .pname { color: #f1f5f9; }
        body.dark .sec-h { background: rgba(15,23,42,.6); color: #64748b; border-bottom-color: rgba(255,255,255,.04); }
        body.dark .fd { border-bottom-color: rgba(255,255,255,.04); }
        body.dark .fv { color: #e2e8f0; }
        body.dark .tab-btn { background: rgba(30,41,59,.5); border-color: rgba(255,255,255,.05); color: #94a3b8; }
        body.dark .tab-btn.act { background: rgba(30,41,59,.8); color: #60a5fa; border-color: #60a5fa; }
        body.dark .tab-panel { background: rgba(30,41,59,.8); border-color: rgba(255,255,255,.05); }
        body.dark .btn-sm { background: #1e293b; border-color: #334155; color: #94a3b8; }
        body.dark .btn-sm:hover { background: rgba(37,99,235,.1); color: #60a5fa; }
        body.dark .tag { background: rgba(37,99,235,.15); color: #60a5fa; }
        body.dark .badge.bg-f { background: #334155; color: #94a3b8; }
    </style>
</head>
<body>
    @php
        $ini = collect(explode(' ',$funcionario->nome))->map(fn($p)=>strtoupper($p[0]))->take(2)->implode('');
        $cores=['#2563eb','#059669','#d97706','#dc2626','#0891b2','#7c3aed'];
        $cor = $cores[$funcionario->id % count($cores)];
        $mesesTrabalhados ??= $funcionario->data_admissao->diffInMonths(now());
    @endphp
    @include('layouts.header')
    <main class="pg">
        @if(session('success')) <div class="alert a-ok">{{ session('success') }}</div> @endif

        <div class="profile-card">
            <div class="pav" style="background:{{ $cor }}">{{ $ini }}</div>
            <div>
                <div class="pname">{{ $funcionario->nome }}</div>
                <div class="pcargo">{{ $funcionario->cargo }}</div>
                <div class="pbadge">
                    <span class="badge {{ $funcionario->isGestor()?'bg-g':'bg-f' }}">{{ $funcionario->isGestor()?'Gestor':'Funcionario' }}</span>
                    <span class="badge bg-clt">{{ strtoupper($funcionario->tipo_contrato ?? 'CLT') }}</span>
                </div>
            </div>
            <div class="pacts">
                <a href="{{ route('funcionarios.edit',$funcionario) }}" class="btn btn-primary">Editar</a>
                <a href="{{ route('funcionarios.index') }}" class="btn btn-secondary">Voltar</a>
            </div>
        </div>

        <div class="grid3">
            <div class="sec">
                <div class="sec-h">Dados Pessoais</div>
                <div class="fd"><span class="fl">E-mail</span><span class="fv">{{ $funcionario->email }}</span></div>
                <div class="fd"><span class="fl">CPF</span><span class="fv">{{ $funcionario->cpfFormatado }}</span></div>
                <div class="fd"><span class="fl">Telefone</span><span class="fv">{{ $funcionario->telefone ?? '—' }}</span></div>
                <div class="fd"><span class="fl">Nascimento</span><span class="fv">{{ $funcionario->data_nascimento?->format('d/m/Y') ?? '—' }}</span></div>
                <div class="fd"><span class="fl">Sexo</span><span class="fv">{{ ucfirst(str_replace('_',' ',$funcionario->sexo ?? '—')) }}</span></div>
                <div class="fd"><span class="fl">Estado Civil</span><span class="fv">{{ ucfirst(str_replace('_',' ',$funcionario->estado_civil ?? '—')) }}</span></div>
                <div class="fd"><span class="fl">Endereco</span><span class="fv">{{ $funcionario->endereco }}</span></div>
            </div>
            <div class="sec">
                <div class="sec-h">Contrato</div>
                <div class="fd"><span class="fl">Tipo de Contrato</span><span class="fv">{{ $funcionario->tipoContratoLabel() }}</span></div>
                <div class="fd"><span class="fl">Admissao</span><span class="fv">{{ $funcionario->data_admissao->format('d/m/Y') }}</span></div>
                <div class="fd"><span class="fl">Tempo de Casa</span><span class="fv">{{ $funcionario->data_admissao->diffForHumans(null,true) }}</span></div>
                <div class="fd"><span class="fl">Beneficios</span>@if($funcionario->beneficios)<div class="tags">@foreach($funcionario->beneficios as $b)<span class="tag">{{ $b }}</span>@endforeach</div>@else<span class="fv">Nao informado</span>@endif</div>
            </div>
            <div class="sec">
                <div class="sec-h">Remuneracao</div>
                <div class="fd"><span class="fl">Salario Base</span><span class="fv fv-hi">{{ $funcionario->salario_base ? 'R$ '.number_format($funcionario->salario_base,2,',','.') : '—' }}</span></div>
                <div class="fd"><span class="fl">Valor por Hora</span><span class="fv">{{ $funcionario->salario_base ? 'R$ '.number_format($funcionario->valorHora(),2,',','.') : '—' }}</span></div>
                <div class="fd"><span class="fl">Carga Horaria</span><span class="fv">{{ $funcionario->carga_horaria_mensal }}h</span></div>
                <div class="fd"><span class="fl">Banco de Horas</span><span class="fv">{{ number_format($funcionario->banco_horas,2,',','.') }}h</span></div>
                <div class="fd"><span class="fl">13 Proporcional</span><span class="fv fv-hi">{{ $funcionario->salario_base ? 'R$ '.number_format($funcionario->estimativaDecimoTerceiro($mesesTrabalhados),2,',','.') : '—' }}</span></div>
            </div>
        </div>

        <div class="tabs-wrap">
            <div class="tabs">
                <button class="tab-btn act" onclick="showTab('atestados',this)">Atestados @if($funcionario->atestadosPendentes()->count()>0)<span style="background:#f59e0b;color:#fff;border-radius:999px;padding:1px 7px;font-size:.63rem;margin-left:5px">{{ $funcionario->atestadosPendentes()->count() }}</span>@endif</button>
                <button class="tab-btn" onclick="showTab('cargos',this)">Historico de Cargos</button>
                <button class="tab-btn" onclick="showTab('afastamentos',this)">Afastamentos</button>
            </div>
            <a href="{{ route('atestados.create',['funcionario_id'=>$funcionario->id]) }}" class="btn btn-primary" style="margin-bottom:1px">+ Novo Atestado</a>
        </div>

        <div id="tab-atestados" class="tab-panel act">
            <table class="tb"><thead><tr><th>Tipo</th><th>Periodo</th><th class="text-center">Dias</th><th class="text-center">Cobre Horas</th><th class="text-center">Status</th><th></th></tr></thead><tbody>
                @forelse($funcionario->atestados as $a)
                <tr><td>{{ $a->tipoLabel() }}</td><td>{{ $a->data_inicio->format('d/m/Y') }}@if(!$a->data_inicio->equalTo($a->data_fim)) → {{ $a->data_fim->format('d/m/Y') }}@endif</td><td class="text-center">{{ $a->dias_afastamento }}d</td><td class="text-center"><span class="bge" style="{{ $a->cobre_horas?'background:#dbeafe;color:#1e40af':'background:var(--gray-100);color:var(--gray-600)' }}">{{ $a->cobre_horas?'Sim':'Nao' }}</span></td><td class="text-center"><span class="bge {{ match($a->status){'aprovado'=>'st-a','reprovado'=>'st-r',default=>'st-p'} }}">{{ $a->statusLabel() }}</span></td><td class="text-right"><a href="{{ route('atestados.show',$a) }}" class="btn-sm">Ver</a></td></tr>
                @empty<tr><td colspan="6" class="emp">Nenhum atestado registrado.</td></tr>
                @endforelse
            </tbody></table>
        </div>

        <div id="tab-cargos" class="tab-panel">
            <table class="tb"><thead><tr><th>Cargo</th><th>Inicio</th><th>Fim</th><th>Motivo</th><th class="text-center">Situacao</th></tr></thead><tbody>
                @forelse($funcionario->historicoCargos as $hc)
                <tr><td class="fw-600">{{ $hc->cargo }}</td><td>{{ $hc->data_inicio->format('d/m/Y') }}</td><td>{{ $hc->data_fim?->format('d/m/Y') ?? '—' }}</td><td>{{ $hc->motivo ?? '—' }}</td><td class="text-center"><span class="bge {{ $hc->isAtual()?'st-a':'st-p' }}">{{ $hc->isAtual()?'Atual':'Encerrado' }}</span></td></tr>
                @empty<tr><td colspan="5" class="emp">Nenhum historico de cargo.</td></tr>
                @endforelse
            </tbody></table>
        </div>

        <div id="tab-afastamentos" class="tab-panel">
            <table class="tb"><thead><tr><th>Tipo</th><th>Inicio</th><th>Fim</th><th class="text-center">Dias</th><th>Observacao</th></tr></thead><tbody>
                @forelse($funcionario->historicoAfastamentos as $af)
                <tr><td>{{ $af->tipoLabel() }}</td><td>{{ $af->data_inicio->format('d/m/Y') }}</td><td>{{ $af->data_fim->format('d/m/Y') }}</td><td class="text-center">{{ $af->dias }}d</td><td>{{ $af->observacao ?? '—' }}</td></tr>
                @empty<tr><td colspan="5" class="emp">Nenhum afastamento registrado.</td></tr>
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
