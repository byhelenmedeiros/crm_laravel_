@extends('layouts.guest')

@section('title', 'CRM UIN SPORTS')

@section('content')
<div class="flex bg-white rounded shadow max-w-3xl mx-auto overflow-hidden">

    {{-- Lado esquerdo: Logotipo e versão --}}
    <div class="w-1/2 bg-gray-100 p-6 flex flex-col justify-center items-center text-center">
        <img src="{{ asset('images/Logo-UIN-high.png') }}" alt="Logotipo" class="w-20 h-20 mb-2" />

        <p class="text-xs text-gray-500">
            Laravel {{ Illuminate\Foundation\Application::VERSION }} · PHP {{ PHP_VERSION }}
            <br>
            <span class="font-semibold">CRM UIN SPORTS v2.0</span>
        </p>
    </div>

    {{-- Lado direito: Formulário de login --}}
    <div class="w-1/2 p-6 flex items-center">
        <form method="POST" action="{{ route('login') }}" class="w-full space-y-4">
            @csrf

            @if (session('status'))
                <div class="text-sm text-green-600 font-medium">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Email --}}
            <div class="form-control">
                <label for="email" class="label">
                    <span class="label-text">Email</span>
                </label>
                <input type="email" id="email" name="email"
                    class="input input-bordered w-full"
                    value="{{ old('email') }}" required autofocus />
                @error('email')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            {{-- Senha --}}
            <div class="form-control">
                <label for="password" class="label">
                    <span class="label-text">Senha</span>
                </label>
                <input type="password" id="password" name="password"
                    class="input input-bordered w-full"
                    required autocomplete="current-password" />
                @error('password')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            {{-- Lembrar-me + Ações --}}
            <div class="flex items-center justify-between">
                <label class="label gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="checkbox checkbox-sm" />
                    <span class="label-text text-sm">Lembrar-me</span>
                </label>

                <a href="{{ route('password.request') }}"
                   class="text-sm link text-gray-600 hover:text-gray-900">
                    Esqueceu a senha?
                </a>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-primary btn-sm">
                    Iniciar Sessão
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
