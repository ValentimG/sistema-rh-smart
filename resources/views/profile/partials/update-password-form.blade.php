<form method="post" action="{{ route('password.update') }}">
    @csrf @method('put')
    <div class="form-group"><label class="form-label">Senha Atual</label><input type="password" name="current_password" class="form-input" required></div>
    <div class="form-group"><label class="form-label">Nova Senha</label><input type="password" name="password" class="form-input" required></div>
    <div class="form-group"><label class="form-label">Confirmar Senha</label><input type="password" name="password_confirmation" class="form-input" required></div>
    <button type="submit" class="btn btn-primary">Salvar</button>
</form>