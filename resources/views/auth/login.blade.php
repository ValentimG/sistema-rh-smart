<x-guest-layout>
    <div style="text-align:center;margin-bottom:20px;">
        <div style="font-size:1.3rem;font-weight:700;color:#111827;">SMART RH</div>
        <div style="font-size:.8rem;color:#9ca3af;margin-top:4px;">Sistema de Gestao de Recursos Humanos</div>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div style="margin-bottom:14px;">
            <label style="display:block;font-size:.78rem;font-weight:600;color:#374151;margin-bottom:4px;">E-mail</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                   style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:7px;font-size:.87rem;outline:none;"
                   onfocus="this.style.borderColor='#2563eb'">
        </div>

        <div style="margin-bottom:14px;">
            <label style="display:block;font-size:.78rem;font-weight:600;color:#374151;margin-bottom:4px;">Senha</label>
            <input type="password" name="password" required
                   style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:7px;font-size:.87rem;outline:none;"
                   onfocus="this.style.borderColor='#2563eb'">
        </div>

        <div style="margin-bottom:20px;display:flex;align-items:center;gap:8px;">
            <input type="checkbox" name="remember" id="remember" style="accent-color:#2563eb;">
            <label for="remember" style="font-size:.8rem;color:#6b7280;">Lembrar-me</label>
        </div>

        <button type="submit"
                style="width:100%;padding:12px;background:#2563eb;color:#fff;border:none;border-radius:7px;font-weight:600;font-size:.87rem;cursor:pointer;transition:.2s;"
                onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'">
            Entrar
        </button>

        <div style="text-align:center;margin-top:16px;">
            <a href="{{ route('register') }}" style="color:#2563eb;font-size:.82rem;text-decoration:none;">Nao tem conta? Registre-se</a>
        </div>
    </form>
</x-guest-layout>