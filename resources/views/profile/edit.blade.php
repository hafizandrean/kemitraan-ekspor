<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Alert for avatar updates -->
            @if (session('status') === 'avatar-updated')
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/30 text-emerald-800 dark:text-emerald-200 border border-emerald-100 dark:border-emerald-900/50 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm font-medium">Foto profil berhasil diperbarui!</span>
                    </div>
                    <button @click="show = false" class="text-emerald-600 hover:text-emerald-800 dark:text-emerald-400 dark:hover:text-emerald-200 text-xs focus:outline-none">Tutup</button>
                </div>
            @endif

            <!-- Profile Header Card -->
            <div class="relative overflow-hidden bg-white dark:bg-gray-800 shadow-sm border border-emerald-100/50 dark:border-gray-700/50 sm:rounded-2xl p-6 sm:p-8">
                <!-- Top Gradient Bar -->
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-emerald-500 via-teal-500 to-emerald-600"></div>
                
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                    <!-- Left: Avatar Form -->
                    <div class="flex-shrink-0">
                        <form action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data" id="avatar-form" class="flex flex-col items-center">
                            @csrf
                            @method('patch')
                            <div class="relative group cursor-pointer" onclick="document.getElementById('avatar-input').click()" title="Klik untuk mengubah foto profil">
                                @if($user->getAvatarUrl())
                                    <img src="{{ $user->getAvatarUrl() }}" alt="{{ $user->name }}" class="w-24 h-24 sm:w-28 sm:h-28 rounded-full object-cover border-4 border-white dark:border-gray-700 shadow-md ring-4 ring-emerald-500/10 transition-transform duration-300 group-hover:scale-105">
                                @else
                                    <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center border-4 border-white dark:border-gray-700 shadow-md ring-4 ring-emerald-500/10 text-white font-bold text-3xl font-display select-none transition-transform duration-300 group-hover:scale-105">
                                        {{ $user->getInitials() }}
                                    </div>
                                @endif
                                
                                <!-- Camera Overlay -->
                                <div class="absolute inset-0 bg-black/40 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                
                                <!-- Corner Camera Badge -->
                                <div class="absolute bottom-1 right-1 bg-emerald-600 text-white p-1.5 rounded-full shadow-md border border-white dark:border-gray-700 hover:bg-emerald-700 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            
                            <input type="file" name="avatar" id="avatar-input" class="hidden" accept="image/*" onchange="document.getElementById('avatar-form').submit()">
                            
                            <button type="button" onclick="document.getElementById('avatar-input').click()" class="mt-3 inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 hover:underline whitespace-nowrap">
                                Ubah Foto Profil
                            </button>
                            
                            <x-input-error class="mt-1" :messages="$errors->get('avatar')" />
                        </form>
                    </div>

                    <!-- Right: Info Panel -->
                    <div class="flex-1 text-center sm:text-left pt-2">
                        <h1 class="font-display text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white leading-tight">
                            {{ $user->name }}
                        </h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 flex items-center justify-center sm:justify-start gap-1.5">
                            <svg class="w-4 h-4 text-stone-400 dark:text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            {{ $user->email }}
                        </p>

                        <!-- Badges -->
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mt-4">
                            <!-- Role Badge -->
                            @if ($user->role === 'petani')
                                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 dark:bg-emerald-950/40 text-emerald-800 dark:text-emerald-300 px-3 py-1 text-xs font-semibold ring-1 ring-emerald-500/10">
                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/></svg>
                                    Petani
                                </span>
                            @elseif ($user->role === 'eksportir')
                                <span class="inline-flex items-center gap-1 rounded-full bg-blue-100 dark:bg-blue-950/40 text-blue-800 dark:text-blue-300 px-3 py-1 text-xs font-semibold ring-1 ring-blue-500/10">
                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 112 0 1 1 0 01-2 0zm8 0a1 1 0 112 0 1 1 0 01-2 0z"/></svg>
                                    Eksportir
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 rounded-full bg-purple-100 dark:bg-purple-950/40 text-purple-800 dark:text-purple-300 px-3 py-1 text-xs font-semibold ring-1 ring-purple-500/10">
                                    Admin
                                </span>
                            @endif

                            <!-- Premium Badge -->
                            @if ($user->isPremium())
                                <span class="inline-flex items-center gap-1 rounded-full bg-gradient-to-r from-amber-500 via-yellow-500 to-amber-600 text-white px-3 py-1 text-xs font-bold shadow-sm shadow-amber-500/20">
                                    <svg class="h-3 w-3 fill-current text-white animate-pulse" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    Premium
                                </span>
                            @endif

                            <!-- Trusted badge -->
                            @if ($user->is_trusted_petani)
                                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 dark:bg-emerald-950/40 text-emerald-800 dark:text-emerald-300 px-3 py-1 text-xs font-semibold ring-1 ring-emerald-500/10">
                                    <svg class="h-3 w-3 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    Mitra Tepercaya
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.subscription-status', ['user' => $user])
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
