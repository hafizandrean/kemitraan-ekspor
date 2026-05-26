<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('partnerships.history') }}" class="text-stone-500 hover:text-emerald-700">← Kembali</a>
            <div>
                <h2 class="font-display text-2xl font-semibold text-stone-900">{{ $partnership->product->nama_produk }}</h2>
                <p class="text-sm text-stone-600">Detail kerja sama · {{ $partnership->workflowStageLabel() }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto space-y-6">
        @if(session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">{{ session('success') }}</div>
        @endif

        <div class="grid lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                {{-- Timeline --}}
                <div class="rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
                    <h3 class="font-semibold text-stone-900 mb-6">Timeline Status</h3>
                    <ol class="relative border-l-2 border-emerald-200 ml-3 space-y-8">
                        @php
                            $currentIndex = $partnership->workflow_stage
                                ? array_search($partnership->workflow_stage, $workflowOrder, true)
                                : -1;
                        @endphp
                        @foreach($workflowOrder as $index => $stage)
                            @php
                                $isDone = $partnership->status === 'completed' || ($currentIndex !== false && $index <= $currentIndex);
                                $isCurrent = $partnership->workflow_stage === $stage;
                            @endphp
                            <li class="ml-6">
                                <span class="absolute -left-[9px] flex h-4 w-4 items-center justify-center rounded-full {{ $isDone ? 'bg-emerald-600' : 'bg-stone-300' }} ring-4 ring-white"></span>
                                <p class="font-semibold {{ $isCurrent ? 'text-emerald-700' : 'text-stone-800' }}">{{ $workflowStages[$stage] }}</p>
                                @if($event = $partnership->timelineEvents->where('stage', $stage)->last())
                                    <p class="text-xs text-stone-500 mt-1">{{ $event->created_at->format('d M Y H:i') }}</p>
                                @endif
                            </li>
                        @endforeach
                    </ol>

                    @if(auth()->user()->role === 'farmer' && $partnership->status === 'active' && $partnership->workflow_stage !== 'completed')
                        <form method="POST" action="{{ route('partnerships.advance', $partnership) }}" class="mt-6">
                            @csrf
                            <x-primary-button type="submit">Lanjut ke Tahap Berikutnya</x-primary-button>
                        </form>
                    @endif
                </div>

                {{-- Log transaksi --}}
                <div class="rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
                    <h3 class="font-semibold text-stone-900 mb-4">Log Transaksi</h3>
                    @forelse($partnership->transactions as $tx)
                        <div class="flex justify-between border-b border-stone-100 py-3 text-sm last:border-0">
                            <div>
                                <p class="font-medium text-stone-800">{{ number_format($tx->quantity_kg, 0, ',', '.') }} kg</p>
                                <p class="text-stone-500">{{ $tx->notes ?? '—' }}</p>
                            </div>
                            <p class="text-stone-600">{{ $tx->transaction_date->format('d M Y') }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-stone-500">Belum ada log pengiriman.</p>
                    @endforelse

                    @if(in_array($partnership->status, ['active', 'completed']))
                        <form method="POST" action="{{ route('partnerships.transactions.store', $partnership) }}" class="mt-4 grid sm:grid-cols-3 gap-3 border-t border-stone-100 pt-4">
                            @csrf
                            <input type="number" name="quantity_kg" min="1" placeholder="Kuantitas (kg)" required class="rounded-lg border-stone-300 text-sm">
                            <input type="date" name="transaction_date" required class="rounded-lg border-stone-300 text-sm">
                            <input type="text" name="notes" placeholder="Catatan" class="rounded-lg border-stone-300 text-sm sm:col-span-3">
                            <x-primary-button type="submit" class="sm:col-span-3 justify-center">Tambah Log</x-primary-button>
                        </form>
                    @endif
                </div>

                {{-- Dokumen --}}
                <div class="rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
                    <h3 class="font-semibold text-stone-900 mb-4">Dokumen Digital</h3>
                    <ul class="space-y-2">
                        @forelse($partnership->documents as $doc)
                            <li class="flex items-center justify-between rounded-lg bg-stone-50 px-3 py-2 text-sm">
                                <span>{{ $documentTypes[$doc->type] ?? $doc->type }} — {{ $doc->original_name }}</span>
                                <a href="{{ route('partnerships.documents.download', [$partnership, $doc]) }}" class="font-semibold text-emerald-700 hover:underline">Unduh PDF</a>
                            </li>
                        @empty
                            <li class="text-sm text-stone-500">Belum ada dokumen diunggah.</li>
                        @endforelse
                    </ul>
                    <form method="POST" action="{{ route('partnerships.documents.store', $partnership) }}" enctype="multipart/form-data" class="mt-4 grid sm:grid-cols-2 gap-3 border-t border-stone-100 pt-4">
                        @csrf
                        <select name="type" required class="rounded-lg border-stone-300 text-sm">
                            @foreach($documentTypes as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <input type="file" name="document" accept=".pdf" required class="text-sm">
                        <x-primary-button type="submit" class="sm:col-span-2 justify-center">Unggah Dokumen</x-primary-button>
                    </form>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-xl border border-stone-200 bg-white p-5 shadow-sm">
                    <h3 class="font-semibold text-stone-900">Ringkasan</h3>
                    <dl class="mt-3 space-y-2 text-sm">
                        <div class="flex justify-between"><dt class="text-stone-500">Produk</dt><dd class="font-medium">{{ $partnership->product->nama_produk }}</dd></div>
                        <div class="flex justify-between"><dt class="text-stone-500">Nilai kontrak</dt><dd class="font-medium">Rp{{ number_format($partnership->total_nilai_kontrak ?? 0, 0, ',', '.') }}</dd></div>
                    </dl>
                    @if(auth()->user()->role === 'farmer' && $partnership->status === 'active')
                        <form method="POST" action="{{ route('partnerships.contract.update', $partnership) }}" class="mt-3">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="total_nilai_kontrak" value="{{ $partnership->total_nilai_kontrak }}" min="0" step="1000" class="w-full rounded-lg border-stone-300 text-sm" placeholder="Nilai kontrak (Rp)">
                            <button type="submit" class="mt-2 text-xs font-semibold text-emerald-700">Simpan nilai</button>
                        </form>
                    @endif
                </div>

                <div class="rounded-xl border border-stone-200 bg-white p-5 shadow-sm">
                    <h3 class="font-semibold text-stone-900">Mitra</h3>
                    @if(auth()->user()->role === 'farmer')
                        <p class="mt-2 font-medium">{{ $partnership->exporter->name }}</p>
                        @if($canViewExporterContact)
                            <p class="text-sm text-stone-600 mt-1">{{ $partnership->exporter->email }}</p>
                            @if($partnership->exporter->phone)
                                <p class="text-sm text-stone-600">{{ $partnership->exporter->phone }}</p>
                            @endif
                        @else
                            <div class="mt-3 rounded-lg border border-amber-200 bg-amber-50 p-3 text-xs text-amber-900">
                                Kontak eksportir terkunci untuk akun Free.
                                <a href="{{ route('premium.upgrade') }}" class="block mt-1 font-semibold text-emerald-700 underline">Upgrade ke Premium</a>
                            </div>
                        @endif
                    @else
                        <p class="mt-2 font-medium">{{ $partnership->farmer->name }}</p>
                        @if($partnership->farmer->is_trusted_farmer)
                            <span class="mt-2 inline-flex rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-semibold text-emerald-800">Trusted Farmer</span>
                        @endif
                    @endif
                </div>

                @if($partnership->status === 'completed' && auth()->user()->role === 'exporter')
                    <div class="rounded-xl border border-stone-200 bg-white p-5 shadow-sm">
                        <h3 class="font-semibold text-stone-900">Rating & Review</h3>
                        @if($partnership->rating)
                            <p class="mt-2 text-amber-500 text-lg">@for($i=0;$i<$partnership->rating;$i++)★@endfor</p>
                            <p class="text-sm text-stone-600 mt-2">{{ $partnership->review }}</p>
                        @else
                            <form method="POST" action="{{ route('partnerships.review', $partnership) }}" class="mt-3 space-y-3">
                                @csrf
                                <select name="rating" required class="w-full rounded-lg border-stone-300 text-sm">
                                    @for($r=5;$r>=1;$r--)
                                        <option value="{{ $r }}">{{ $r }} bintang</option>
                                    @endfor
                                </select>
                                <textarea name="review" rows="3" class="w-full rounded-lg border-stone-300 text-sm" placeholder="Testimoni untuk petani..."></textarea>
                                <x-primary-button type="submit" class="w-full justify-center">Kirim Rating</x-primary-button>
                            </form>
                        @endif
                    </div>
                @endif

                @if($partnership->rating && auth()->user()->role === 'farmer')
                    <div class="rounded-xl border border-amber-200 bg-amber-50 p-5">
                        <p class="text-sm font-semibold text-amber-900">Ulasan dari eksportir</p>
                        <p class="text-amber-500 mt-1">★ {{ $partnership->rating }}/5</p>
                        <p class="text-sm text-amber-900/90 mt-2">{{ $partnership->review }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
