<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display text-lg font-bold text-exportani-text tracking-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Alert for avatar updates -->
            @if (session('status') === 'avatar-updated')
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition class="p-4 rounded-xl bg-exportani-mint/15 text-exportani-accent border border-exportani-mint/20 flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-exportani-primary animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm font-semibold">Foto profil berhasil diperbarui!</span>
                    </div>
                    <button @click="show = false" class="text-exportani-primary hover:text-exportani-dark text-xs font-bold focus:outline-none">Tutup</button>
                </div>
            @endif

            <!-- Profile Header Card -->
            <div class="relative overflow-hidden bg-white shadow-sm border border-exportani-border sm:rounded-2xl p-6 sm:p-8">
                <!-- Top Gradient Bar -->
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-exportani-teal via-exportani-mint to-exportani-primary"></div>
                
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                    <!-- Left: Avatar Form -->
                    <div class="flex-shrink-0">
                        <form action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data" id="avatar-form" class="flex flex-col items-center">
                            @csrf
                            @method('patch')
                            <div class="relative group cursor-pointer" onclick="document.getElementById('avatar-input').click()" title="Klik untuk mengubah foto profil">
                                @if($user->getAvatarUrl())
                                    <img src="{{ $user->getAvatarUrl() }}" alt="{{ $user->name }}" class="w-24 h-24 sm:w-28 sm:h-28 rounded-full object-cover border-4 border-white shadow-md ring-4 ring-exportani-primary/10 transition-transform duration-300 group-hover:scale-105">
                                @else
                                    <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full bg-gradient-to-tr from-exportani-dark to-exportani-primary flex items-center justify-center border-4 border-white shadow-md ring-4 ring-exportani-primary/10 text-white font-bold text-3xl font-display select-none transition-transform duration-300 group-hover:scale-105">
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
                                <div class="absolute bottom-1 right-1 bg-exportani-primary text-white p-1.5 rounded-full shadow-md border border-white hover:bg-exportani-dark transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            
                            <input type="file" name="avatar" id="avatar-input" class="hidden" accept="image/*" onchange="document.getElementById('avatar-form').submit()">
                            
                            <button type="button" onclick="document.getElementById('avatar-input').click()" class="mt-3 inline-flex items-center gap-1.5 text-xs font-bold text-exportani-primary hover:text-exportani-dark hover:underline whitespace-nowrap">
                                Ubah Foto Profil
                            </button>
                            
                            <x-input-error class="mt-1" :messages="$errors->get('avatar')" />
                        </form>
                    </div>

                    <!-- Right: Info Panel -->
                    <div class="flex-1 text-center sm:text-left pt-2">
                        <h1 class="font-display text-2xl sm:text-3xl font-extrabold text-exportani-text leading-tight">
                            {{ $user->name }}
                        </h1>
                        <p class="text-sm text-exportani-secondaryText mt-1 flex items-center justify-center sm:justify-start gap-1.5 font-medium">
                            <svg class="w-4 h-4 text-exportani-secondaryText/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            {{ $user->email }}
                        </p>

                        <!-- Badges -->
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mt-4">
                            <!-- Role Badge -->
                            @if ($user->role === 'petani')
                                <span class="inline-flex items-center gap-1 rounded-full bg-exportani-mint/15 text-exportani-accent border border-exportani-mint/20 px-3 py-1 text-xs font-bold">
                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/></svg>
                                    Petani
                                </span>
                            @elseif ($user->role === 'eksportir')
                                <span class="inline-flex items-center gap-1 rounded-full bg-sky-50 text-sky-800 border border-sky-200/50 px-3 py-1 text-xs font-bold">
                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 112 0 1 1 0 01-2 0zm8 0a1 1 0 112 0 1 1 0 01-2 0z"/></svg>
                                    Eksportir
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 rounded-full bg-purple-50 text-purple-800 border border-purple-200/50 px-3 py-1 text-xs font-bold">
                                    Admin
                                </span>
                            @endif

                            <!-- Premium Badge -->
                            @if ($user->isPremium())
                                <span class="inline-flex items-center gap-1.5 rounded-full badge-premium px-3 py-1 text-xs">
                                    <svg class="h-3 w-3 text-[#5B3D00] fill-current" viewBox="0 0 24 24">
                                        <path d="M12 2l2.8 7.2 7.2 2.8-7.2 2.8-2.8 7.2-2.8-7.2-7.2-2.8 7.2-2.8L12 2z"/>
                                    </svg>
                                    Premium
                                </span>
                            @endif

                            <!-- Trusted badge -->
                            @if ($user->is_trusted_petani)
                                <span class="inline-flex items-center gap-1 rounded-full bg-exportani-primary/10 border border-exportani-primary/20 text-exportani-primary px-3 py-1 text-xs font-bold">
                                    <svg class="h-3 w-3 text-exportani-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    Mitra Tepercaya
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Overview Section -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <!-- Stat Card 1 -->
                <div class="bg-white shadow-sm border border-exportani-border border-l-4 border-l-exportani-mint sm:rounded-2xl p-5 flex items-center gap-4 transition duration-150 hover:shadow-md">
                    <div class="flex-shrink-0 bg-exportani-mint/15 text-exportani-accent p-3.5 rounded-2xl">
                        @if ($user->role === 'eksportir')
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        @else
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        @endif
                    </div>
                    <div>
                        <p class="text-2xl font-black text-exportani-text font-sans leading-tight">
                            {{ $totalProducts }}
                        </p>
                        <p class="text-[10px] font-bold text-exportani-secondaryText uppercase tracking-widest mt-0.5">
                            @if ($user->role === 'petani')
                                Total Produk
                            @elseif ($user->role === 'eksportir')
                                Produk Favorit
                            @else
                                Produk Sistem
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-white shadow-sm border border-exportani-border border-l-4 border-l-exportani-mint sm:rounded-2xl p-5 flex items-center gap-4 transition duration-150 hover:shadow-md">
                    <div class="flex-shrink-0 bg-sky-50 text-sky-850 p-3.5 rounded-2xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-black text-exportani-text font-sans leading-tight">
                            {{ $totalPartnerships }}
                        </p>
                        <p class="text-[10px] font-bold text-exportani-secondaryText uppercase tracking-widest mt-0.5">
                            @if ($user->role === 'petani')
                                Kemitraan Masuk
                            @elseif ($user->role === 'eksportir')
                                Kemitraan Diajukan
                            @else
                                Total Kemitraan
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Stat Card 3 -->
                <div class="bg-white shadow-sm border border-exportani-border border-l-4 border-l-exportani-mint sm:rounded-2xl p-5 flex items-center gap-4 transition duration-150 hover:shadow-md">
                    <div class="flex-shrink-0 bg-amber-50 text-amber-705 p-3.5 rounded-2xl">
                        @if ($user->role === 'admin')
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        @else
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        @endif
                    </div>
                    <div>
                        <p class="text-2xl font-black text-exportani-text font-sans leading-tight">
                            {{ $totalConversations }}
                        </p>
                        <p class="text-[10px] font-bold text-exportani-secondaryText uppercase tracking-widest mt-0.5">
                            @if ($user->role === 'admin')
                                Total Pengguna
                            @else
                                Total Percakapan
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            {{-- Status Langganan - Full Width untuk 12-kolom grid internal --}}
            <div class="p-6 sm:p-8 bg-white border border-exportani-border shadow-sm sm:rounded-2xl">
                <div class="w-full">
                    @include('profile.partials.subscription-status', ['user' => $user])
                </div>
            </div>

            {{-- Formulir Update Profil dan Password - Berdampingan (Symmetrical) --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="p-6 sm:p-8 bg-white border border-exportani-border shadow-sm sm:rounded-2xl">
                    <div class="w-full">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="p-6 sm:p-8 bg-white border border-exportani-border shadow-sm sm:rounded-2xl">
                    <div class="w-full">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            {{-- Hapus Akun (Destructive Action) - Tetap di Bawah --}}
            <div class="p-6 sm:p-8 bg-white border border-exportani-border shadow-sm sm:rounded-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
