<x-guest-layout>
    <div class="mb-8">
        <h1 class="font-display text-2xl font-semibold text-stone-900 tracking-tight">Masuk</h1>
        <p class="mt-2 text-sm text-stone-600">Gunakan email dan password yang terdaftar.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1.5 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1.5 w-full"
                type="password"
                name="password"
                required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-stone-300 text-emerald-600 shadow-sm focus:ring-emerald-500" name="remember">
                <span class="text-sm text-stone-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-3 pt-2">
            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-emerald-700 hover:text-emerald-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @else
                <span></span>
            @endif

            <x-primary-button class="w-full sm:w-auto justify-center">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <p class="text-center text-sm text-stone-600 pt-2">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-semibold text-emerald-700 hover:text-emerald-800">Daftar</a>
        </p>
    </form>
</x-guest-layout>
