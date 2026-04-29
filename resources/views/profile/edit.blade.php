<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;gap:10px;">
            <div style="width:32px;height:32px;background:#2563eb;border-radius:7px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:900;font-size:.72rem;">RH</div>
            <div>
                <div style="font-size:.9rem;font-weight:700;color:#111827;">SMART RH</div>
                <div style="font-size:.58rem;color:#9ca3af;font-weight:500;">MEU PERFIL</div>
            </div>
        </div>
    </x-slot>

    <div style="background:#f8f9fa;min-height:100vh;padding:30px 0;">
        <div style="max-width:600px;margin:0 auto;padding:0 20px;">

            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:24px;margin-bottom:20px;">
                <h3 style="font-size:1rem;font-weight:600;color:#111827;margin-bottom:16px;">Informações do Perfil</h3>
                @include('profile.partials.update-profile-information-form')
            </div>

            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:24px;margin-bottom:20px;">
                <h3 style="font-size:1rem;font-weight:600;color:#111827;margin-bottom:16px;">Alterar Senha</h3>
                @include('profile.partials.update-password-form')
            </div>

            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:24px;">
                <h3 style="font-size:1rem;font-weight:600;color:#dc2626;margin-bottom:16px;">Excluir Conta</h3>
                @include('profile.partials.delete-user-form')
            </div>

        </div>
    </div>
</x-app-layout>