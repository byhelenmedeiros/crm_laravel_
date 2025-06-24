<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', config('app.name', 'Laravel'))</title>

    @routes
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="font-sans antialiased bg-gray-100 text-sm text-gray-900">

<div class="flex h-screen">

    {{-- Sidebar Fixo --}}
    @include('layouts.partials.sidebar')

    {{-- Conteúdo Principal --}}
    <div class="flex-1 flex flex-col">
        {{-- Header --}}
        <header class="flex items-center justify-between bg-gray-600 border-b border-gray-200 p-3 text-white">
            <div>
                <input type="text" placeholder="Pesquisar..."
                    class="input input-sm w-64 text-black placeholder:text-sm" />
            </div>

            <div class="flex items-center gap-3">
                @auth
                    <div class="text-right hidden md:block">
                        <div class="font-semibold">{{ auth()->user()->name }}</div>
                        <div class="text-xs">{{ auth()->user()->email }}</div>
                    </div>
                @endauth

                <button class="text-white hover:text-pink-300"><i class="fa-solid fa-envelope"></i></button>
                <button class="text-white hover:text-pink-300"><i class="fa-solid fa-bell"></i></button>
                <button class="text-white hover:text-pink-300"><i class="fa-solid fa-cog"></i></button>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="btn btn-sm bg-gray-700 hover:bg-red-700 text-white px-3">
                        Sair
                    </button>
                </form>
            </div>
        </header>

        {{-- Main --}}
        <main class="flex-1 p-4">
            @yield('content')
        </main>
    </div>
</div>

</body>
</html>
