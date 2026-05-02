@php
    $navFunc = Auth::user()->funcionario ?? null;
    $currentRoute = request()->route()->getName();
@endphp
<header style="background:#fff;border-bottom:1px solid #e5e7eb;padding:0 40px;height:60px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:100">
    <div style="display:flex;align-items:center;gap:10px">
        <div style="width:32px;height:32px;background:#2563eb;border-radius:7px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:900;font-size:.72rem">RH</div>
        <div>
            <div style="font-size:.9rem;font-weight:700;color:#111827">SMART RH</div>
            <div style="font-size:.58rem;color:#9ca3af;font-weight:500">SISTEMA DE RH</div>
        </div>
    </div>
    <nav style="display:flex;align-items:center;gap:12px">
        <div style="display:flex;gap:2px">
            @if($navFunc && $navFunc->isGestor())
                <a href="{{ route('gestor.dashboard') }}" style="display:flex;align-items:center;gap:6px;padding:7px 13px;border-radius:7px;color:#6b7280;text-decoration:none;font-size:.8rem;font-weight:500;transition:.15s;{{ $currentRoute == 'gestor.dashboard' ? 'background:#eff6ff;color:#2563eb' : '' }}">Dashboard</a>
                <a href="{{ route('funcionarios.index') }}" style="display:flex;align-items:center;gap:6px;padding:7px 13px;border-radius:7px;color:#6b7280;text-decoration:none;font-size:.8rem;font-weight:500;transition:.15s;{{ str_starts_with($currentRoute, 'funcionarios') ? 'background:#eff6ff;color:#2563eb' : '' }}">Funcionarios</a>
                <a href="{{ route('atestados.index') }}" style="display:flex;align-items:center;gap:6px;padding:7px 13px;border-radius:7px;color:#6b7280;text-decoration:none;font-size:.8rem;font-weight:500;transition:.15s;{{ str_starts_with($currentRoute, 'atestados') ? 'background:#eff6ff;color:#2563eb' : '' }}">Atestados</a>
                <a href="{{ route('funcionarios.index') }}" style="display:flex;align-items:center;gap:6px;padding:7px 13px;border-radius:7px;color:#6b7280;text-decoration:none;font-size:.8rem;font-weight:500;transition:.15s">Exportar CSV</a>
            @else
                <a href="{{ route('ponto.index') }}" style="display:flex;align-items:center;gap:6px;padding:7px 13px;border-radius:7px;color:#6b7280;text-decoration:none;font-size:.8rem;font-weight:500;transition:.15s;{{ $currentRoute == 'ponto.index' ? 'background:#eff6ff;color:#2563eb' : '' }}">Meu Ponto</a>
                <a href="{{ route('atestados.index') }}" style="display:flex;align-items:center;gap:6px;padding:7px 13px;border-radius:7px;color:#6b7280;text-decoration:none;font-size:.8rem;font-weight:500;transition:.15s;{{ str_starts_with($currentRoute, 'atestados') ? 'background:#eff6ff;color:#2563eb' : '' }}">Atestados</a>
            @endif
            <a href="{{ route('profile.edit') }}" style="display:flex;align-items:center;gap:6px;padding:7px 13px;border-radius:7px;color:#6b7280;text-decoration:none;font-size:.8rem;font-weight:500;transition:.15s;{{ $currentRoute == 'profile.edit' ? 'background:#eff6ff;color:#2563eb' : '' }}">Perfil</a>
        </div>
        <div style="width:34px;height:34px;background:#2563eb;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.78rem;flex-shrink:0">{{ strtoupper(substr(Auth::user()->name,0,1)) }}</div>
        <form method="POST" action="{{ route('logout') }}">@csrf
            <button type="submit" style="display:flex;align-items:center;gap:5px;padding:7px 12px;border-radius:7px;color:#9ca3af;font-size:.8rem;font-weight:500;background:none;border:none;cursor:pointer;transition:.15s">Sair</button>
        </form>
    </nav>
</header>