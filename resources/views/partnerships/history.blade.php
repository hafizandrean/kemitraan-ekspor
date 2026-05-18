<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-display text-2xl font-semibold text-stone-900 tracking-tight">
                {{ __('Riwayat Kerja Sama') }}
            </h2>
            <p class="mt-1 text-sm text-stone-600">Daftar semua pengajuan kerja sama yang pernah Anda buat.</p>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <div class="rounded-2xl border border-stone-200/80 bg-white/90 p-6 sm:p-8 shadow-sm shadow-stone-900/5">
                <div class="space-y-4">
                    @forelse($history as $h)
                        <div class="rounded-xl border border-stone-200/80 bg-stone-50/40 p-5 sm:p-6">
                            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                                <div class="min-w-0">
                                    <a href="{{ route('products.show', $h->product_id) }}" class="font-display text-lg font-semibold text-stone-900 hover:text-emerald-600 hover:underline">
                                        {{ $h->product->nama_produk }}
                                    </a>
                                    <div class="mt-2 text-sm text-stone-600">
                                        Petani: <span class="font-semibold text-stone-800">{{ $h->farmer->name }}</span>
                                    </div>
                                    <div class="mt-1 text-sm text-stone-500">
                                        Tanggal Pengajuan: {{ $h->created_at->format('d M Y H:i') }}
                                    </div>
                                    <div class="mt-3">
                                        @if($h->status === 'pending')
                                            <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-900 ring-1 ring-amber-200/80">Menunggu Respon</span>
                                        @elseif($h->status === 'accepted')
                                            <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-900 ring-1 ring-emerald-200/80">Diterima</span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-900 ring-1 ring-red-200/80">Ditolak</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-xl border border-dashed border-stone-300 bg-stone-50 px-6 py-14 text-center text-stone-600">
                            Belum ada partnership. Anda belum mengajukan kerja sama apapun.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
