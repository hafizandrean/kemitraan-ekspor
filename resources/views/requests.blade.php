<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-display text-2xl font-semibold text-stone-900 tracking-tight">
                {{ __('Permintaan masuk') }}
            </h2>
            <p class="mt-1 text-sm text-stone-600">Pengajuan kerja sama dari eksportir untuk produkmu.</p>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <div class="rounded-2xl border border-stone-200/80 bg-white/90 p-6 sm:p-8 shadow-sm shadow-stone-900/5">
                <div class="space-y-4">
                    @forelse($requests as $r)
                        <div class="rounded-xl border border-stone-200/80 bg-stone-50/40 p-5 sm:p-6">
                            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                                <div class="min-w-0">
                                    <div class="font-display text-lg font-semibold text-stone-900">
                                        {{ $r->product->nama_produk }}
                                    </div>
                                    <div class="mt-2 text-sm text-stone-600">
                                        Eksportir: <span class="font-semibold text-stone-800">{{ $r->exporter->name }}</span>
                                    </div>
                                    <div class="mt-3">
                                        @if($r->status === 'pending')
                                            <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-900 ring-1 ring-amber-200/80">pending</span>
                                        @elseif($r->status === 'accepted')
                                            <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-900 ring-1 ring-emerald-200/80">accepted</span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-900 ring-1 ring-red-200/80">rejected</span>
                                        @endif
                                    </div>
                                </div>

                                @if ($r->status === 'pending')
                                    <div class="flex flex-wrap gap-2 lg:shrink-0">
                                        <form method="POST" action="{{ route('requests.accept', $r->id) }}">
                                            @csrf
                                            <x-primary-button class="justify-center">Accept</x-primary-button>
                                        </form>
                                        <form method="POST" action="{{ route('requests.reject', $r->id) }}">
                                            @csrf
                                            <x-danger-button class="justify-center">Reject</x-danger-button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="rounded-xl border border-dashed border-stone-300 bg-stone-50 px-6 py-14 text-center text-stone-600">
                            Belum ada permintaan kerja sama masuk.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
