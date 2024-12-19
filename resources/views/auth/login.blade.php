<x-guest-layout>
    <div class="flex flex-col items-center mb-8">
        <img src="{{ asset('image/lista.png') }}" alt="Logo" class="w-20 h-20 mb-4 animate-float">
        <h2 class="text-2xl font-bold text-gray-900">Bem-vindo de volta!</h2>
        <p class="text-gray-600">Entre para gerenciar suas tarefas</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div class="space-y-2">
            <x-input-label for="email" :value="__('Email')" class="text-gray-700" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-envelope text-gray-400"></i>
                </div>
                <x-text-input id="email"
                    class="block mt-1 w-full pl-10 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                    autocomplete="username" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="space-y-2">
            <x-input-label for="password" :value="__('Senha')" class="text-gray-700" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-gray-400"></i>
                </div>
                <x-text-input id="password"
                    class="block mt-1 w-full pl-10 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Lembrar para mim') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-indigo-600 hover:text-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Esqueceu sua senha?') }}
                </a>
            @endif
        </div>

        <div class="flex flex-col gap-4">
            <x-primary-button class="w-full justify-center py-3 bg-indigo-600 hover:bg-indigo-700">
                <i class="fas fa-sign-in-alt mr-2"></i> {{ __('Entrar') }}
            </x-primary-button>

            <p class="text-center text-sm text-gray-600">
                Não tem uma conta?
                <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Cadastre-se
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
