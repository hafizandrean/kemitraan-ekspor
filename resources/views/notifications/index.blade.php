<x-app-layout>
    <x-slot name="header">
        <div class="flex items-end justify-between gap-4">
            <div>
                <h2 class="font-display text-2xl font-semibold text-exportani-text tracking-tight">
                    Notifikasi
                </h2>
                <p class="mt-1 text-sm text-exportani-secondaryText">Update aktivitas penting akun kamu.</p>
            </div>
            <form method="POST" action="{{ route('notifications.read-all') }}">
                @csrf
                <x-secondary-button type="submit">Tandai semua dibaca</x-secondary-button>
            </form>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto space-y-4">
            @if (session('success'))
                <div class="rounded-xl border border-exportani-mint/30 bg-exportani-mint/10 px-4 py-3 text-sm font-medium text-exportani-accent">
                    {{ session('success') }}
                </div>
            @endif

            @forelse($notifications as $notification)
                <div class="rounded-2xl border {{ $notification->is_read ? 'border-exportani-border bg-white shadow-sm' : 'border-exportani-mint/45 bg-exportani-mint/5 shadow-sm' }} p-5 transition duration-150">
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <p class="font-semibold text-exportani-text">{{ $notification->title }}</p>
                                @if(!$notification->is_read)
                                    <span class="inline-flex rounded-full bg-amber-100 border border-amber-250/30 px-2 py-0.5 text-[9px] font-bold tracking-wide text-amber-800 uppercase">Baru</span>
                                @else
                                    <span class="inline-flex rounded-full bg-exportani-background border border-exportani-border px-2 py-0.5 text-[9px] font-bold tracking-wide text-exportani-secondaryText uppercase">Dibaca</span>
                                @endif
                            </div>
                            <p class="mt-1 text-sm text-exportani-secondaryText">{{ $notification->message }}</p>
                            <p class="mt-2 text-xs text-exportani-secondaryText/80">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="flex items-center gap-2 shrink-0 mt-3 sm:mt-0">
                            @if(auth()->user()->role === 'petani')
                                <a href="{{ route('requests.index') }}" class="inline-flex items-center justify-center rounded-lg border border-exportani-border bg-white px-3 py-1.5 text-xs font-semibold text-exportani-secondaryText shadow-sm hover:bg-exportani-background hover:text-exportani-primary transition">
                                    Lihat Detail
                                </a>
                            @elseif(auth()->user()->role === 'eksportir')
                                <a href="{{ route('partnerships.history') }}" class="inline-flex items-center justify-center rounded-lg border border-exportani-border bg-white px-3 py-1.5 text-xs font-semibold text-exportani-secondaryText shadow-sm hover:bg-exportani-background hover:text-exportani-primary transition">
                                    Lihat Detail
                                </a>
                            @endif

                            @if(!$notification->is_read)
                                <form method="POST" action="{{ route('notifications.read', $notification->id) }}" class="m-0">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-exportani-mint/15 px-3 py-1.5 text-xs font-semibold text-exportani-accent hover:bg-exportani-mint/25 transition">
                                        Tandai Dibaca
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-2xl border border-dashed border-exportani-border bg-white p-12 text-center text-exportani-secondaryText shadow-sm">
                    Belum ada notifikasi.
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
