<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-display text-2xl font-semibold text-stone-900 tracking-tight">Riwayat Kerja Sama</h2>
            <p class="mt-1 text-sm text-stone-600">Portofolio dan track record kemitraan {{ $role === 'farmer' ? 'dengan eksportir' : 'dengan petani' }}.</p>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto space-y-6">
            <form method="GET" class="rounded-xl border border-stone-200 bg-white p-4 shadow-sm grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <div>
                    <label class="text-xs font-medium text-stone-600">Tahun</label>
                    <select name="year" class="mt-1 w-full rounded-lg border-stone-300 text-sm">
                        <option value="">Semua tahun</option>
                        @foreach($years as $y)
                            <option value="{{ $y }}" @selected(request('year') == $y)>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs font-medium text-stone-600">Status</label>
                    <select name="status_filter" class="mt-1 w-full rounded-lg border-stone-300 text-sm">
                        <option value="">Semua</option>
                        <option value="aktif" @selected(request('status_filter') === 'aktif')>Aktif / Berjalan</option>
                        <option value="berhasil" @selected(request('status_filter') === 'berhasil')>Berhasil</option>
                        <option value="gagal" @selected(request('status_filter') === 'gagal')>Gagal / Ditolak</option>
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label class="text-xs font-medium text-stone-600">Nama mitra</label>
                    <input type="text" name="partner" value="{{ request('partner') }}" placeholder="Cari nama petani/eksportir..." class="mt-1 w-full rounded-lg border-stone-300 text-sm">
                </div>
                <div class="sm:col-span-2 lg:col-span-4 flex gap-2">
                    <x-primary-button type="submit">Terapkan Filter</x-primary-button>
                    <a href="{{ route('partnerships.history') }}" class="text-sm text-stone-600 hover:text-stone-900 self-center">Reset</a>
                </div>
            </form>

            <div class="space-y-4">
                @forelse($history as $h)
                    <a href="{{ route('partnerships.show', $h) }}" class="block rounded-xl border border-stone-200 bg-white p-5 shadow-sm hover:border-emerald-300 hover:shadow-md transition">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                            <div>
                                <h3 class="font-display text-lg font-semibold text-stone-900">{{ $h->product->nama_produk }}</h3>
                                <p class="mt-1 text-sm text-stone-600">
                                    Mitra: <span class="font-medium">{{ $role === 'farmer' ? $h->exporter->name : $h->farmer->name }}</span>
                                </p>
                                <p class="text-xs text-stone-500 mt-1">Diajukan {{ $h->created_at->format('d M Y') }}</p>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                @if($h->status === 'completed')
                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">Berhasil</span>
                                @elseif($h->isFailed())
                                    <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-800">Gagal</span>
                                @elseif($h->status === 'pending')
                                    <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">Menunggu</span>
                                @else
                                    <span class="rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-800">{{ $h->workflowStageLabel() }}</span>
                                @endif
                                @if($h->rating)
                                    <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-900">★ {{ $h->rating }}/5</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="rounded-xl border border-dashed border-stone-300 bg-stone-50 px-6 py-14 text-center text-stone-600">
                        Belum ada riwayat kerja sama.
                    </div>
                @endforelse
            </div>

            {{ $history->links() }}
        </div>
    </div>
</x-app-layout>
