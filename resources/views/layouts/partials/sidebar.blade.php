@php
    $user = auth()->user();
    $isAdmin = $user?->isAdmin ?? false;
    $isSuperadmin = $user?->isSuperadmin ?? false;
@endphp

<aside class="w-64 bg-white border-r shadow hidden md:block">
    <nav class="p-4 space-y-2 text-sm">

        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 p-2 rounded hover:bg-gray-100">
            <i class="fa-solid fa-tachometer-alt w-4 h-4"></i>
            <span>Dashboard</span>
        </a>

        {{-- Perfil --}}
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 p-2 rounded hover:bg-gray-100">
            <i class="fa-solid fa-user w-4 h-4"></i>
            <span>Perfil</span>
        </a>

        {{-- Utilizadores --}}
        <div class="pt-4">
            <p class="text-gray-500 font-bold uppercase text-xs mb-1">Utilizadores</p>

            @if ($isAdmin || $isSuperadmin)
                <a href="{{ route('users.index') }}" class="flex items-center gap-2 p-2 rounded hover:bg-gray-100">
                    <i class="fa-solid fa-list w-4 h-4"></i>
                    <span>Listar Utilizadores</span>
                </a>
            @endif

            @if ($isAdmin)
                <a href="{{ route('users.create') }}" class="flex items-center gap-2 p-2 rounded hover:bg-gray-100">
                    <i class="fa-solid fa-plus w-4 h-4"></i>
                    <span>Criar Utilizador</span>
                </a>
            @endif

            @if ($isSuperadmin)
                <a href="{{ route('teams.teamadmin.create') }}" class="flex items-center gap-2 p-2 rounded hover:bg-gray-100">
                    <i class="fa-solid fa-user-shield w-4 h-4"></i>
                    <span>Criar Administrador</span>
                </a>

                <a href="{{ route('teams.teamadmin.index') }}" class="flex items-center gap-2 p-2 rounded hover:bg-gray-100">
                    <i class="fa-solid fa-users w-4 h-4"></i>
                    <span>Admins de Setor</span>
                </a>
            @endif
        </div>

        {{-- Clientes --}}
        <div class="pt-4">
            <p class="text-gray-500 font-bold uppercase text-xs mb-1">Clientes</p>

            <a href="{{ route('clients.index') }}" class="flex items-center gap-2 p-2 rounded hover:bg-gray-100">
                <i class="fa-solid fa-list w-4 h-4"></i>
                <span>Listar Clientes</span>
            </a>

            @if ($isAdmin || $isSuperadmin)
                <a href="{{ route('clients.create') }}" class="flex items-center gap-2 p-2 rounded hover:bg-gray-100">
                    <i class="fa-solid fa-plus w-4 h-4"></i>
                    <span>Criar Cliente</span>
                </a>

                <a href="{{ route('clients.index') }}" class="flex items-center gap-2 p-2 rounded hover:bg-gray-100">
                    <i class="fa-solid fa-search w-4 h-4"></i>
                    <span>Pesquisar Clientes</span>
                </a>
            @endif
        </div>

    </nav>
</aside>
