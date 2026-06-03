<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-display text-2xl font-semibold text-stone-900 tracking-tight">Petani Tepercaya</h2>
            <p class="mt-1 text-sm text-stone-600">Kelola petani terverifikasi yang mendapat badge kepercayaan di platform.</p>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto space-y-6">
        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-900">{{ session('success') }}</div>
        @endif

        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">
            Saat ini <strong>{{ $trustedCount }}</strong> petani berstatus Petani Tepercaya.
        </div>

        <form method="GET" class="flex gap-3">
            <x-text-input name="q" value="{{ $q }}" placeholder="Cari nama atau email petani..." class="flex-1" />
            <x-primary-button type="submit">Cari</x-primary-button>
        </form>

        <div class="rounded-2xl border border-stone-200 bg-white overflow-hidden shadow-sm divide-y divide-stone-100">
            @forelse ($farmers as $petani)
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-5">
                    <div>
                        <div class="flex items-center gap-2">
                            <p class="font-semibold text-stone-900">{{ $petani->name }}</p>
                            @if ($petani->is_trusted_petani)
                                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-800">Tepercaya</span>
                            @endif
                        </div>
                        <p class="text-sm text-stone-500">{{ $petani->email }} · {{ $petani->products_count }} produk</p>
                    </div>
                    <form method="POST" action="{{ route('admin.trusted-farmers.toggle', $petani) }}">
                        @csrf
                        @if ($petani->is_trusted_petani)
                            <button type="submit" class="rounded-lg border border-stone-300 px-4 py-2 text-sm font-medium text-stone-700 hover:bg-stone-50">
                                Cabut Tepercaya
                            </button>
                        @else
                            <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
                                Jadikan Tepercaya
                            </button>
                        @endif
                    </form>
                </div>
            @empty
                <p class="p-8 text-center text-stone-500">Petani tidak ditemukan.</p>
            @endforelse
        </div>

        {{ $farmers->links() }}
    </div>
</x-app-layout>
