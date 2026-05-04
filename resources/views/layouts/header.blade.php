@php
    $navFunc = Auth::user()->funcionario ?? null;
    $currentRoute = request()->route()->getName();
@endphp
<header class="hd">
    <div style="display:flex;align-items:center;gap:12px">
        <div class="logo">
            <div class="logo-ic">RH</div>
            <div>
                <div class="logo-n">SMART RH</div>
                <div class="logo-s">SISTEMA DE RH</div>
            </div>
        </div>
    </div>
    <nav class="hd-r">
        <div class="nav">
            @if($navFunc && $navFunc->isGestor())
                <a href="{{ route('gestor.dashboard') }}" class="nl {{ $currentRoute == 'gestor.dashboard' ? 'on' : '' }}">Dashboard</a>
                <a href="{{ route('funcionarios.index') }}" class="nl {{ str_starts_with($currentRoute, 'funcionarios') ? 'on' : '' }}">Funcionarios</a>
                <a href="{{ route('atestados.index') }}" class="nl {{ str_starts_with($currentRoute, 'atestados') ? 'on' : '' }}">Atestados</a>
                <a href="{{ route('calendario.index') }}" class="nl {{ $currentRoute == 'calendario.index' ? 'on' : '' }}">Calendario</a>
                <a href="{{ route('ferias.index') }}" class="nl {{ str_starts_with($currentRoute, 'ferias') ? 'on' : '' }}">Ferias</a>
                <a href="{{ route('ajustes.index') }}" class="nl {{ str_starts_with($currentRoute, 'ajustes') ? 'on' : '' }}">Ajustes</a>
                <a href="{{ route('gestor.exportar-csv') }}" class="nl">Exportar CSV</a>
            @else
                <a href="{{ route('ponto.index') }}" class="nl {{ $currentRoute == 'ponto.index' ? 'on' : '' }}">Meu Ponto</a>
                <a href="{{ route('atestados.index') }}" class="nl {{ str_starts_with($currentRoute, 'atestados') ? 'on' : '' }}">Atestados</a>
                <a href="{{ route('calendario.index') }}" class="nl {{ $currentRoute == 'calendario.index' ? 'on' : '' }}">Calendario</a>
                <a href="{{ route('ferias.index') }}" class="nl {{ str_starts_with($currentRoute, 'ferias') ? 'on' : '' }}">Ferias</a>
                <a href="{{ route('ponto.extrato') }}" class="nl {{ $currentRoute == 'ponto.extrato' ? 'on' : '' }}">Extrato</a>
                <a href="{{ route('ajustes.index') }}" class="nl {{ str_starts_with($currentRoute, 'ajustes') ? 'on' : '' }}">Ajustes</a>
            @endif
            <a href="{{ route('profile.edit') }}" class="nl {{ $currentRoute == 'profile.edit' ? 'on' : '' }}">Perfil</a>
        </div>
        <button class="theme-toggle">☾</button>
        <div class="av">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="lg-btn">Sair</button>
        </form>
    </nav>
</header>