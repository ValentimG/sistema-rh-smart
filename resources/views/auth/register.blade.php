<x-guest-layout>
    <div style="min-height:100vh;display:flex;align-items:center;justify-content:center;background:#f8f9fa;padding:20px;overflow-y:auto;">
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:32px;width:100%;max-width:440px;">
            <div style="text-align:center;margin-bottom:24px;">
                <div style="font-size:1.3rem;font-weight:700;color:#111827;">Criar Conta</div>
                <div style="font-size:.8rem;color:#9ca3af;margin-top:4px;">SMART RH</div>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:.78rem;font-weight:600;color:#374151;margin-bottom:4px;">Nome completo</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:7px;font-size:.87rem;outline:none;"
                           onfocus="this.style.borderColor='#2563eb'">
                    @error('name')<div style="color:#dc2626;font-size:.72rem;margin-top:3px;">{{ $message }}</div>@enderror
                </div>

                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:.78rem;font-weight:600;color:#374151;margin-bottom:4px;">E-mail</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:7px;font-size:.87rem;outline:none;"
                           onfocus="this.style.borderColor='#2563eb'">
                    @error('email')<div style="color:#dc2626;font-size:.72rem;margin-top:3px;">{{ $message }}</div>@enderror
                </div>

                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:.78rem;font-weight:600;color:#374151;margin-bottom:4px;">Tipo de usuário</label>
                    <select name="tipo"
                            style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:7px;font-size:.87rem;outline:none;background:#fff;">
                        <option value="funcionario">Funcionário</option>
                        <option value="gestor">Gestor</option>
                    </select>
                    @error('tipo')<div style="color:#dc2626;font-size:.72rem;margin-top:3px;">{{ $message }}</div>@enderror
                </div>

                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:.78rem;font-weight:600;color:#374151;margin-bottom:4px;">Senha</label>
                    <input type="password" name="password" required
                           style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:7px;font-size:.87rem;outline:none;"
                           onfocus="this.style.borderColor='#2563eb'">
                    @error('password')<div style="color:#dc2626;font-size:.72rem;margin-top:3px;">{{ $message }}</div>@enderror
                </div>

                <div style="margin-bottom:20px;">
                    <label style="display:block;font-size:.78rem;font-weight:600;color:#374151;margin-bottom:4px;">Confirmar senha</label>
                    <input type="password" name="password_confirmation" required
                           style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:7px;font-size:.87rem;outline:none;"
                           onfocus="this.style.borderColor='#2563eb'">
                </div>

                <button type="submit"
                        style="width:100%;padding:12px;background:#2563eb;color:#fff;border:none;border-radius:7px;font-weight:600;font-size:.87rem;cursor:pointer;transition:.2s;"
                        onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'">
                    Registrar
                </button>

                <div style="text-align:center;margin-top:16px;">
                    <a href="{{ route('login') }}" style="color:#2563eb;font-size:.82rem;text-decoration:none;">Já tem conta? Faça login</a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>