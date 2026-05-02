@if(!$hoje->entrada)
<button class="btn-action btn-action-green" data-url="{{ route('ponto.entrada') }}" data-span="hora-entrada" data-cls="g">
    <span class="btn-action-icon bg-green">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
    </span>
    <span>
        <span class="btn-action-title">Registrar Entrada</span>
        <span class="btn-action-sub">Iniciar jornada de trabalho</span>
    </span>
</button>
@else
<div class="btn-action btn-action-done">
    <span class="btn-action-icon bg-green-light">
        <svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
    </span>
    <span>
        <span class="btn-action-title">Entrada Registrada</span>
        <span class="btn-action-sub">{{ $hoje->entrada->format('H:i') }}</span>
    </span>
</div>
@endif