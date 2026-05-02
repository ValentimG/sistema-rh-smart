@if($hoje->entrada && !$hoje->saida_almoco)
<button class="btn-action btn-action-orange" data-url="{{ route('ponto.saida-almoco') }}">
    <span class="btn-action-icon bg-orange">
        <svg viewBox="0 0 24 24"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/></svg>
    </span>
    <span>
        <span class="btn-action-title">Saida para Almoco</span>
        <span class="btn-action-sub">Pausa para refeicao</span>
    </span>
</button>
@elseif($hoje->saida_almoco)
<div class="btn-action btn-action-done">
    <span class="btn-action-icon bg-green-light">
        <svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
    </span>
    <span>
        <span class="btn-action-title">Saida Registrada</span>
        <span class="btn-action-sub">{{ $hoje->saida_almoco->format('H:i') }}</span>
    </span>
</div>
@else
<div class="btn-action btn-action-disabled">
    <span class="btn-action-icon bg-gray">
        <svg viewBox="0 0 24 24"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/></svg>
    </span>
    <span>
        <span class="btn-action-title">Saida para Almoco</span>
        <span class="btn-action-sub">Aguardando entrada</span>
    </span>
</div>
@endif