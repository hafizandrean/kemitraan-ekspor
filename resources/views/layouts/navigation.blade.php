<nav x-data="{ open: false }" class="sticky top-0 z-50 border-b border-exportani-dark/10 bg-exportani-dark shadow-md shadow-exportani-dark/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Changed height from h-14 to h-12 for a tighter, denser Vercel/Stripe style navbar -->
        <div class="flex justify-between h-12">
            <div class="flex items-center gap-6">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group">
                        <x-application-logo class="h-7 w-7 shrink-0 drop-shadow" />
                        <span class="hidden sm:inline font-display text-xs font-bold text-white tracking-tight">EXPORTANI</span>
                    </a>
                </div>

                <div class="hidden md:flex items-center gap-3.5">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" dark-nav>
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if (Auth::user()->role === 'petani')
                        <x-nav-link :href="route('petani.products.index')" :active="request()->routeIs('petani.products.*')" dark-nav>
                            {{ __('Produk Saya') }}
                        </x-nav-link>
                        <x-nav-link :href="route('requests.index')" :active="request()->routeIs('requests.*')" dark-nav>
                            {{ __('Permintaan Masuk') }}
                        </x-nav-link>
                        <x-nav-link :href="route('partnerships.history')" :active="request()->routeIs('partnerships.*')" dark-nav>
                            {{ __('Riwayat Kerja Sama') }}
                        </x-nav-link>
                    @endif

                    @if (Auth::user()->role === 'eksportir')
                        <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')" dark-nav>
                            {{ __('Cari Produk') }}
                        </x-nav-link>
                        <x-nav-link :href="route('partnerships.history')" :active="request()->routeIs('partnerships.history')" dark-nav>
                            {{ __('Riwayat Kerja Sama') }}
                        </x-nav-link>
                    @endif

                    @if (Auth::user()->role === 'admin')
                        <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')" dark-nav>
                            Kategori
                        </x-nav-link>
                        <x-nav-link :href="route('admin.recommendations.index')" :active="request()->routeIs('admin.recommendations.*')" dark-nav>
                            Rekomendasi
                        </x-nav-link>
                        <x-nav-link :href="route('admin.trusted-farmers.index')" :active="request()->routeIs('admin.trusted-farmers.*')" dark-nav>
                            Petani Tepercaya
                        </x-nav-link>
                        <x-nav-link :href="route('admin.chat.dashboard')" :active="request()->routeIs('admin.chat.*')" dark-nav>
                            Moderasi Chat
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden md:flex md:items-center md:gap-3">
                <a href="{{ route('chat.index') }}" class="relative inline-flex items-center justify-center h-7 w-7 rounded-lg bg-white/10 ring-1 ring-white/15 text-white hover:bg-white/15 transition" title="Chat">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    @if(($unreadMessagesCount ?? 0) > 0)
                        <span class="absolute -top-1 -right-1 inline-flex items-center justify-center min-w-4 h-4 rounded-full bg-amber-500 px-1 text-[8px] font-bold text-stone-900">
                            {{ $unreadMessagesCount > 99 ? '99+' : $unreadMessagesCount }}
                        </span>
                    @endif
                </a>
                <a href="{{ route('notifications.index') }}" class="relative inline-flex items-center justify-center h-7 w-7 rounded-lg bg-white/10 ring-1 ring-white/15 text-white hover:bg-white/15 transition" title="Notifikasi">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 1 0-12 0v3.2c0 .5-.2 1-.6 1.4L4 17h5m6 0v1a3 3 0 1 1-6 0v-1m6 0H9"/>
                    </svg>
                    @if(($unreadNotificationsCount ?? 0) > 0)
                        <span class="absolute -top-1 -right-1 inline-flex items-center justify-center min-w-4 h-4 rounded-full bg-red-500 px-1 text-[8px] font-bold text-white">
                            {{ $unreadNotificationsCount > 99 ? '99+' : $unreadNotificationsCount }}
                        </span>
                    @endif
                </a>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button type="button" class="inline-flex items-center gap-1.5 rounded-lg px-2 py-1 text-xs font-semibold text-white bg-white/10 ring-1 ring-white/15 hover:bg-white/15 focus:outline-none transition">
                            <span class="max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                            <svg class="h-2.5 w-2.5 shrink-0 opacity-60" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.94a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('premium.index')">
                            {{ __('Premium & Langganan') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="flex items-center md:hidden">
                <button @click="open = ! open" type="button" class="inline-flex items-center justify-center rounded-lg p-2 text-white/90 hover:bg-white/10 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden border-t border-white/10 bg-exportani-dark/95 backdrop-blur">
        <div class="pt-2 pb-3 space-y-0.5 px-2">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" dark-nav>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if (Auth::user()->role === 'petani')
                <x-responsive-nav-link :href="route('petani.products.index')" :active="request()->routeIs('petani.products.*')" dark-nav>
                    {{ __('Produk Saya') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('requests.index')" :active="request()->routeIs('requests.*')" dark-nav>
                    {{ __('Permintaan Masuk') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('partnerships.history')" :active="request()->routeIs('partnerships.*')" dark-nav>
                    {{ __('Riwayat Kerja Sama') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('chat.index')" :active="request()->routeIs('chat.*')" dark-nav>
                    {{ __('Chat') }}
                    @if(($unreadMessagesCount ?? 0) > 0)
                        <span class="ml-1 px-1.5 py-0.5 rounded-full text-[9px] font-bold bg-amber-500 text-stone-900 leading-none">
                            {{ $unreadMessagesCount }}
                        </span>
                    @endif
                </x-responsive-nav-link>
            @endif

            @if (Auth::user()->role === 'eksportir')
                <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')" dark-nav>
                    {{ __('Cari Produk') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('partnerships.history')" :active="request()->routeIs('partnerships.history')" dark-nav>
                    {{ __('Riwayat Kerja Sama') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('chat.index')" :active="request()->routeIs('chat.*')" dark-nav>
                    {{ __('Chat') }}
                    @if(($unreadMessagesCount ?? 0) > 0)
                        <span class="ml-1 px-1.5 py-0.5 rounded-full text-[9px] font-bold bg-amber-500 text-stone-900 leading-none">
                            {{ $unreadMessagesCount }}
                        </span>
                    @endif
                </x-responsive-nav-link>
            @endif

            @if (Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')" dark-nav>
                    Kategori
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.recommendations.index')" :active="request()->routeIs('admin.recommendations.*')" dark-nav>
                    Rekomendasi
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.trusted-farmers.index')" :active="request()->routeIs('admin.trusted-farmers.*')" dark-nav>
                    Petani Tepercaya
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.chat.dashboard')" :active="request()->routeIs('admin.chat.*')" dark-nav>
                    Moderasi Chat
                </x-responsive-nav-link>
            @endif

            <x-responsive-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.*')" dark-nav>
                {{ __('Notifikasi') }}
                @if(($unreadNotificationsCount ?? 0) > 0)
                    ({{ $unreadNotificationsCount }})
                @endif
            </x-responsive-nav-link>
        </div>

        <div class="pt-3 pb-4 px-4 border-t border-white/10">
            <div class="text-white font-medium flex items-center gap-1.5 text-xs">
                {{ Auth::user()->name }}
            </div>
            <div class="text-xs text-white/70 mt-0.5">{{ Auth::user()->email }}</div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" dark-nav>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('premium.index')" dark-nav>
                    {{ __('Premium & Langganan') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();" dark-nav>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
