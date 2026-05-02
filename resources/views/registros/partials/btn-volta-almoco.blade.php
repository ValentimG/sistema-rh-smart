@if($hoje->saida_almoco && !$hoje->volta_almoco)
<button class="btn-action btn-action-blue" data-url="{{ route('ponto.volta-almoco') }}">
    <span class="btn-action-icon bg-blue">
        <svg viewBox="0 0 24 24"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
    </span>
    <span>
        <span class="btn-action-title">Volta do Almoco</span>
        <span class="btn-action-sub">Retornar ao trabalho</span>
    </span>
</button>
@elseif($hoje->volta_almoco)
<div class="btn-action btn-action-done">
    <span class="btn-action-icon bg-green-light">
        <svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
    </span>
    <span>
        <span class="btn-action-title">Volta Registrada</span>
        <span class="btn-action-sub">{{ $hoje->volta_almoco->format('H:i') }}</span>
    </span>
</div>
@else
<div class="btn-action btn-action-disabled">
    <span class="btn-action-icon bg-gray">
        <svg viewBox="0 0 24 24"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
    </span>
    <span>
        <span class="btn-action-title">Volta do Almoco</span>
        <span class="btn-action-sub">Aguardando saida almoco</span>
    </span>
</div>
@endif