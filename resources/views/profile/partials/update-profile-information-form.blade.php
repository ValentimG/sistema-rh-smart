<div class="card">
    <h3 class="card-tt">Informacoes do Perfil</h3>
    <p style="color:#6b7280;font-size:.87rem;margin-bottom:20px;">Atualize seu nome e e-mail.</p>
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
        <button type="submit" class="btn-p">Salvar</button>
    </form>
</div>