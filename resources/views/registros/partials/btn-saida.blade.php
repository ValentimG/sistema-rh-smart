@if($hoje->entrada && !$hoje->saida && (!$hoje->saida_almoco || $hoje->volta_almoco))
<button class="btn-action btn-action-red" data-url="{{ route('ponto.saida') }}">
    <span class="btn-action-icon bg-red">
        <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
    </span>
    <span>
        <span class="btn-action-title">Registrar Saida</span>
        <span class="btn-action-sub">Encerrar jornada</span>
    </span>
</button>
@else
<div class="btn-action btn-action-disabled">
    <span class="btn-action-icon bg-gray">
        <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
    </span>
    <span>
        <span class="btn-action-title">Registrar Saida</span>
        <span class="btn-action-sub">Aguardando etapa anterior</span>
    </span>
</div>
@endif