<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ajustes de Ponto — SMART RH</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    @include('layouts.header')
    <main class="pg">
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

        <div class="page-header">
            <div>
                <h1 class="section-title" style="font-size:1.3rem;color:var(--gray-900);text-transform:none;letter-spacing:0">Ajustes de Ponto</h1>
                <p class="text-muted text-sm">{{ $isGestor ? 'Gerencie as solicitacoes' : 'Suas solicitacoes' }}</p>
            </div>
            @if(!$isGestor)
            <a href="{{ route('ajustes.create') }}" class="btn btn-primary">+ Nova Solicitacao</a>
            @endif
        </div>

        <div class="card">
            <div class="table-responsive">
                <table class="tb">
                    <thead><tr>
                        @if($isGestor)<th>Funcionario</th>@endif
                        <th>Data</th><th>Tipo</th><th>Horario</th><th>Motivo</th><th class="text-center">Status</th><th class="text-center">Acoes</th>
                    </tr></thead>
                    <tbody>
                        @forelse($ajustes as $a)
                        <tr>
                            @if($isGestor)<td><span class="fw-600">{{ $a->funcionario->nome }}</span></td>@endif
                            <td>{{ $a->data->format('d/m/Y') }}</td>
                            <td>{{ ucfirst(str_replace('_',' ',$a->tipo)) }}</td>
                            <td>{{ \Carbon\Carbon::parse($a->horario_solicitado)->format('H:i') }}</td>
                            <td class="text-muted text-sm">{{ Str::limit($a->motivo, 40) }}</td>
                            <td class="text-center"><span class="badge {{ $a->status=='aprovado'?'badge-success':($a->status=='reprovado'?'badge-danger':'badge-warning') }}">{{ $a->statusLabel() }}</span></td>
                            <td class="text-center">
                                @if($isGestor && $a->status == 'pendente')
                                <form method="POST" action="{{ route('ajustes.aprovar', $a) }}" style="display:inline">@csrf<button class="btn-sm btn-sm-success">Aprovar</button></form>
                                <form method="POST" action="{{ route('ajustes.reprovar', $a) }}" style="display:inline">@csrf<button class="btn-sm btn-sm-danger">Reprovar</button></form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="{{ $isGestor?7:6 }}" class="text-center text-muted py-4">Nenhuma solicitacao encontrada.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <script src="/js/dark.js"></script>
</body>
</html>