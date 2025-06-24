@extends('layouts.guest')

@section('title', 'Iniciar Sessão')

@section('content')

    {{-- Status da sessão --}}
    @if (session('status'))
        <div class="mb-4 text-sm text-green-600 font-medium">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div class="form-control mb-4">
            <label for="email" class="label">
                <span class="label-text">Email</span>
            </label>
            <input id="email" type="email" name="email"
                   class="input input-bordered w-full"
                   value="{{ old('email') }}" required autofocus autocomplete="username" />
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div class="form-control mb-4">
            <label for="password" class="label">
                <span class="label-text">Palavra-passe</span>
            </label>
            <input id="password" type="password" name="password"
                   class="input input-bordered w-full"
                   required autocomplete="current-password" />
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Lembrar-me --}}
        <div class="form-control mb-4">
            <label class="label cursor-pointer justify-start gap-2">
                <input type="checkbox" name="remember" class="checkbox checkbox-sm" />
                <span class="label-text">Lembrar-me</span>
            </label>
        </div>

        {{-- Ações --}}
        <div class="flex items-center justify-between mt-4">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="link link-hover text-sm text-gray-600 hover:text-gray-900">
                    Esqueceste-te da tua palavra-passe?
                </a>
            @endif

            <button type="submit"
                    class="btn btn-primary btn-sm">
                Aceder
            </button>
        </div>
    </form>
@endsection
