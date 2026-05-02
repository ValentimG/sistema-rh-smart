<form method="post" action="{{ route('profile.destroy') }}">
    @csrf @method('delete')
    <button type="submit" class="btn btn-danger">Excluir Conta</button>
</form>