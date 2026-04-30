<div class="card">
    <h3 class="card-tt">Alterar Senha</h3>
    <p style="color:#6b7280;font-size:.87rem;margin-bottom:20px;">Use uma senha longa e segura.</p>
    <form method="post" action="{{ route('password.update') }}">
        @csrf @method('put')
        <div class="form-group">
            <label class="form-label">Senha Atual</label>
            <input class="form-input" type="password" name="current_password" required>
        </div>
        <div class="form-group">
            <label class="form-label">Nova Senha</label>
            <input class="form-input" type="password" name="password" required>
        </div>
        <div class="form-group">
            <label class="form-label">Confirmar Senha</label>
            <input class="form-input" type="password" name="password_confirmation" required>
        </div>
        <button type="submit" class="btn-p">Salvar</button>
    </form>
</div>