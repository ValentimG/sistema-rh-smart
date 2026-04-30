<div class="card">
    <h3 class="card-tt" style="color:#dc2626;">Excluir Conta</h3>
    <p style="color:#6b7280;font-size:.87rem;margin-bottom:20px;">Ao excluir sua conta, todos os dados serao permanentemente removidos.</p>
    <form method="post" action="{{ route('profile.destroy') }}">
        @csrf @method('delete')
        <button type="submit" class="btn-del">Excluir Conta</button>
    </form>
</div>