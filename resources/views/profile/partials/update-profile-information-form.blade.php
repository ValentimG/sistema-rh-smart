<form method="post" action="{{ route('profile.update') }}">
    @csrf @method('patch')
    <div class="form-group">
        <label class="form-label">Nome</label>
        <input class="form-input" type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required>
    </div>
    <div class="form-group">
        <label class="form-label">E-mail</label>
        <input class="form-input" type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Salvar</button>
</form>