<x-app-layout>
    <x-slot name="header">
        <div class="flex items-end justify-between gap-4">
            <div>
                <h2 class="font-display text-2xl font-semibold text-stone-900 tracking-tight">
                    Notifikasi
                </h2>
                <p class="mt-1 text-sm text-stone-600">Update aktivitas penting akun kamu.</p>
            </div>
            <form method="POST" action="{{ route('notifications.read-all') }}">
                @csrf
                <x-secondary-button>Tandai semua dibaca</x-secondary-button>
            </form>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto space-y-4">
            @if (session('success'))
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-900">
                    {{ session('success') }}
                </div>
            @endif

            @forelse($notifications as $notification)
                <div class="rounded-xl border {{ $notification->is_read ? 'border-stone-200 bg-white' : 'border-emerald-200 bg-emerald-50/40' }} p-5">
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <p class="font-semibold text-stone-900">{{ $notification->title }}</p>
                                @if(!$notification->is_read)
                                    <span class="inline-flex rounded-full bg-amber-100 px-2 py-0.5 text-[10px] font-bold tracking-wide text-amber-900 uppercase">Baru</span>
                                @else
                                    <span class="inline-flex rounded-full bg-stone-100 px-2 py-0.5 text-[10px] font-bold tracking-wide text-stone-600 uppercase">Dibaca</span>
                                @endif
                            </div>
                            <p class="mt-1 text-sm text-stone-600">{{ $notification->message }}</p>
                            <p class="mt-2 text-xs text-stone-500">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="flex items-center gap-2 shrink-0 mt-3 sm:mt-0">
                            @if(auth()->user()->role === 'farmer')
                                <a href="{{ route('requests.index') }}" class="inline-flex items-center justify-center rounded-lg border border-stone-200 bg-white px-3 py-1.5 text-xs font-semibold text-stone-700 shadow-sm hover:bg-stone-50 hover:border-stone-300 transition">
                                    Lihat Detail
                                </a>
                            @elseif(auth()->user()->role === 'exporter')
                                <a href="{{ route('partnerships.history') }}" class="inline-flex items-center justify-center rounded-lg border border-stone-200 bg-white px-3 py-1.5 text-xs font-semibold text-stone-700 shadow-sm hover:bg-stone-50 hover:border-stone-300 transition">
                                    Lihat Detail
                                </a>
                            @endif

                            @if(!$notification->is_read)
                                <form method="POST" action="{{ route('notifications.read', $notification->id) }}" class="m-0">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-emerald-100 px-3 py-1.5 text-xs font-semibold text-emerald-800 hover:bg-emerald-200 transition">
                                        Tandai Dibaca
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-xl border border-dashed border-stone-300 bg-stone-50 p-10 text-center text-stone-600">
                    Belum ada notifikasi.
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>

