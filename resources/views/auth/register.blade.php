<x-guest-layout>
    <div class="mb-8">
        <h1 class="font-display text-2xl font-semibold text-stone-900 tracking-tight">Daftar</h1>
        <p class="mt-2 text-sm text-stone-600">Buat akun sebagai petani atau eksportir.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1.5 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1.5 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1.5 w-full"
                type="password"
                name="password"
                required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1.5 w-full"
                type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="role">Pilih Role</label>
            <select id="role" name="role" required class="block mt-1 w-full rounded-lg border-stone-300 bg-white text-stone-900 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                <option value="petani" @selected(old('role') === 'petani')>Petani</option>
                <option value="eksportir" @selected(old('role') === 'eksportir')>Eksportir</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-3 pt-2">
            <a class="text-sm font-medium text-stone-600 hover:text-stone-900 text-center sm:text-right sm:mr-auto" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
            <x-primary-button class="w-full sm:w-auto justify-center">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
