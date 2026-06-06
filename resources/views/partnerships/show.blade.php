<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('partnerships.history') }}" class="inline-flex items-center justify-center h-9 w-9 rounded-lg border border-exportani-border bg-white text-exportani-secondaryText hover:bg-exportani-background hover:text-exportani-primary transition shadow-sm">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="font-display text-lg font-bold text-exportani-text tracking-tight">{{ $partnership->product->nama_produk }}</h2>
                <p class="mt-0.5 text-xs text-exportani-secondaryText">Detail kerja sama · {{ $partnership->workflowStageLabel() }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto space-y-6">
        @if(session('success'))
            <div class="rounded-xl border border-exportani-mint/30 bg-exportani-mint/10 px-4 py-3 text-sm font-medium text-exportani-accent shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                {{-- Timeline --}}
                <div class="rounded-2xl border border-exportani-border bg-white p-6 shadow-sm h-full flex flex-col justify-between">
                    <div>
                        <h3 class="font-semibold text-exportani-text mb-6">Timeline Status</h3>
                        <ol class="relative border-l-2 border-exportani-mint/40 ml-3 space-y-8">
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
                                <li class="ml-6 text-sm">
                                    <span class="absolute -left-[9px] flex h-4 w-4 items-center justify-center rounded-full {{ $isDone ? 'bg-exportani-primary' : 'bg-exportani-border' }} ring-4 ring-white"></span>
                                    <p class="font-semibold {{ $isCurrent ? 'text-exportani-primary font-bold' : 'text-exportani-text' }}">{{ $workflowStages[$stage] }}</p>
                                    @if($event = $partnership->timelineEvents->where('stage', $stage)->last())
                                        <p class="text-xs text-exportani-secondaryText mt-1">{{ $event->created_at->format('d M Y H:i') }}</p>
                                    @endif
                                </li>
                            @endforeach
                        </ol>
                    </div>

                    @if(auth()->user()->role === 'petani' && $partnership->status === 'active' && $partnership->workflow_stage !== 'completed')
                        <form method="POST" action="{{ route('partnerships.advance', $partnership) }}" class="mt-6">
                            @csrf
                            <x-primary-button type="submit">Lanjut ke Tahap Berikutnya</x-primary-button>
                        </form>
                    @endif
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-2xl border border-exportani-border bg-white p-5 shadow-sm">
                    <h3 class="font-semibold text-exportani-text">Ringkasan</h3>
                    <dl class="mt-3 space-y-2 text-sm">
                        <div class="flex justify-between"><dt class="text-exportani-secondaryText">Produk</dt><dd class="font-medium text-exportani-text">{{ $partnership->product->nama_produk }}</dd></div>
                        <div class="flex justify-between"><dt class="text-exportani-secondaryText">Nilai kontrak</dt><dd class="font-medium text-exportani-text">Rp{{ number_format($partnership->total_nilai_kontrak ?? 0, 0, ',', '.') }}</dd></div>
                    </dl>
                    @if(auth()->user()->role === 'petani' && $partnership->status === 'active')
                        <form method="POST" action="{{ route('partnerships.contract.update', $partnership) }}" class="mt-3">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="total_nilai_kontrak" value="{{ $partnership->total_nilai_kontrak }}" min="0" step="1000" class="w-full rounded-lg border-exportani-border bg-white text-exportani-text text-sm focus:border-exportani-primary focus:ring-exportani-primary" placeholder="Nilai kontrak (Rp)">
                            <button type="submit" class="mt-2 text-xs font-bold text-exportani-primary hover:text-exportani-dark transition">Simpan nilai</button>
                        </form>
                    @endif
                </div>

                <div class="rounded-2xl border border-exportani-border bg-white p-5 shadow-sm">
                    <h3 class="font-semibold text-exportani-text">Mitra</h3>
                    @if(auth()->user()->role === 'petani')
                        <p class="mt-2 font-medium text-exportani-text">{{ $partnership->eksportir->name }}</p>
                        @if($canViewExporterContact)
                            <p class="text-sm text-exportani-secondaryText mt-1">{{ $partnership->eksportir->email }}</p>
                            @if($partnership->eksportir->phone)
                                <p class="text-sm text-exportani-secondaryText">{{ $partnership->eksportir->phone }}</p>
                            @endif
                        @else
                            <div class="mt-3 rounded-xl border border-amber-200 bg-amber-50 p-3.5 text-xs text-amber-900 leading-relaxed shadow-sm">
                                Kontak eksportir terkunci untuk akun Free.
                                <a href="{{ route('premium.upgrade') }}" class="block mt-1.5 font-bold text-exportani-primary hover:text-exportani-dark underline">Upgrade ke Premium</a>
                            </div>
                        @endif
                    @else
                        <p class="mt-2 font-medium text-exportani-text">{{ $partnership->petani->name }}</p>
                        @if($partnership->petani->is_trusted_petani)
                            <span class="mt-2 inline-flex rounded-full bg-exportani-mint/15 border border-exportani-mint/20 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-exportani-accent">Petani Tepercaya</span>
                        @endif
                    @endif
                </div>

                @if($partnership->status === 'completed' && auth()->user()->role === 'eksportir')
                    <div class="rounded-2xl border border-exportani-border bg-white p-5 shadow-sm">
                        <h3 class="font-semibold text-exportani-text">Rating & Review</h3>
                        @if($partnership->rating)
                            <p class="mt-2 text-amber-500 text-lg">@for($i=0;$i<$partnership->rating;$i++)★@endfor</p>
                            <p class="text-sm text-exportani-secondaryText mt-2">{{ $partnership->review }}</p>
                        @else
                            <form method="POST" action="{{ route('partnerships.review', $partnership) }}" class="mt-3 space-y-3">
                                @csrf
                                <select name="rating" required class="w-full rounded-lg border-exportani-border bg-white text-exportani-text text-sm focus:border-exportani-primary focus:ring-exportani-primary">
                                    @for($r=5;$r>=1;$r--)
                                        <option value="{{ $r }}">{{ $r }} bintang</option>
                                    @endfor
                                </select>
                                <textarea name="review" rows="3" class="w-full rounded-lg border-exportani-border bg-white text-exportani-text text-sm focus:border-exportani-primary focus:ring-exportani-primary" placeholder="Testimoni untuk petani..."></textarea>
                                <x-primary-button type="submit" class="w-full justify-center">Kirim Rating</x-primary-button>
                            </form>
                        @endif
                    </div>
                @endif

                @if($partnership->rating && auth()->user()->role === 'petani')
                    <div class="rounded-2xl border border-amber-250 bg-amber-50 p-5 shadow-sm">
                        <p class="text-sm font-semibold text-amber-900">Ulasan dari eksportir</p>
                        <p class="text-amber-500 mt-1">★ {{ $partnership->rating }}/5</p>
                        <p class="text-sm text-amber-900/90 mt-2">{{ $partnership->review }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Log transaksi --}}
            <div class="rounded-2xl border border-exportani-border bg-white p-6 shadow-sm">
                <h3 class="font-semibold text-exportani-text mb-4">Log Transaksi</h3>
                <div class="space-y-3">
                    @forelse($partnership->transactions as $tx)
                        <div class="flex justify-between border-b border-exportani-border py-3 text-sm last:border-0">
                            <div>
                                <p class="font-medium text-exportani-text">{{ number_format($tx->quantity_kg, 0, ',', '.') }} kg</p>
                                <p class="text-exportani-secondaryText">{{ $tx->notes ?? '—' }}</p>
                            </div>
                            <p class="text-exportani-secondaryText">{{ $tx->transaction_date->format('d M Y') }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-exportani-secondaryText py-2">Belum ada log pengiriman.</p>
                    @endforelse
                </div>

                @if(in_array($partnership->status, ['active', 'completed']))
                    <form method="POST" action="{{ route('partnerships.transactions.store', $partnership) }}" class="mt-4 grid sm:grid-cols-3 gap-3 border-t border-exportani-border pt-4">
                        @csrf
                        <input type="number" name="quantity_kg" min="1" placeholder="Kuantitas (kg)" required class="rounded-lg border-exportani-border bg-white text-exportani-text text-sm focus:border-exportani-primary focus:ring-exportani-primary">
                        <input type="date" name="transaction_date" required class="rounded-lg border-exportani-border bg-white text-exportani-text text-sm focus:border-exportani-primary focus:ring-exportani-primary">
                        <input type="text" name="notes" placeholder="Catatan" class="rounded-lg border-exportani-border bg-white text-exportani-text text-sm focus:border-exportani-primary focus:ring-exportani-primary sm:col-span-3">
                        <x-primary-button type="submit" class="sm:col-span-3 justify-center">Tambah Log</x-primary-button>
                    </form>
                @endif
            </div>

            {{-- Dokumen --}}
            <div class="rounded-2xl border border-exportani-border bg-white p-6 shadow-sm">
                <h3 class="font-semibold text-exportani-text mb-4">Dokumen Digital</h3>
                <ul class="space-y-2">
                    @forelse($partnership->documents as $doc)
                        <li class="flex items-center justify-between rounded-lg bg-exportani-background px-3 py-2 text-sm border border-exportani-border">
                            <span class="text-exportani-text font-medium">{{ $documentTypes[$doc->type] ?? $doc->type }} — {{ $doc->original_name }}</span>
                            <a href="{{ route('partnerships.documents.download', [$partnership, $doc]) }}" class="font-bold text-exportani-primary hover:text-exportani-dark hover:underline">Unduh PDF</a>
                        </li>
                    @empty
                        <li class="text-sm text-exportani-secondaryText py-2">Belum ada dokumen diunggah.</li>
                    @endforelse
                </ul>
                <form method="POST" action="{{ route('partnerships.documents.store', $partnership) }}" enctype="multipart/form-data" class="mt-4 grid sm:grid-cols-2 gap-3 border-t border-exportani-border pt-4">
                    @csrf
                    <select name="type" required class="rounded-lg border-exportani-border bg-white text-exportani-text text-sm focus:border-exportani-primary focus:ring-exportani-primary">
                        @foreach($documentTypes as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <input type="file" name="document" accept=".pdf" required class="text-sm text-exportani-secondaryText focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-exportani-mint/15 file:text-exportani-accent hover:file:bg-exportani-mint/25">
                    <x-primary-button type="submit" class="sm:col-span-2 justify-center">Unggah Dokumen</x-primary-button>
                </form>
            </div>

            <div class="space-y-6">
                <div class="rounded-2xl border border-exportani-border bg-white p-5 shadow-sm">
                    <h3 class="font-semibold text-exportani-text">Ringkasan</h3>
                    <dl class="mt-3 space-y-2 text-sm">
                        <div class="flex justify-between"><dt class="text-exportani-secondaryText">Produk</dt><dd class="font-medium text-exportani-text">{{ $partnership->product->nama_produk }}</dd></div>
                        <div class="flex justify-between"><dt class="text-exportani-secondaryText">Nilai kontrak</dt><dd class="font-medium text-exportani-text">Rp{{ number_format($partnership->total_nilai_kontrak ?? 0, 0, ',', '.') }}</dd></div>
                    </dl>
                    @if(auth()->user()->role === 'petani' && $partnership->status === 'active')
                        <form method="POST" action="{{ route('partnerships.contract.update', $partnership) }}" class="mt-3">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="total_nilai_kontrak" value="{{ $partnership->total_nilai_kontrak }}" min="0" step="1000" class="w-full rounded-lg border-exportani-border bg-white text-exportani-text text-sm focus:border-exportani-primary focus:ring-exportani-primary" placeholder="Nilai kontrak (Rp)">
                            <button type="submit" class="mt-2 text-xs font-bold text-exportani-primary hover:text-exportani-dark transition">Simpan nilai</button>
                        </form>
                    @endif
                </div>

                <div class="rounded-2xl border border-exportani-border bg-white p-5 shadow-sm">
                    <h3 class="font-semibold text-exportani-text">Mitra</h3>
                    @if(auth()->user()->role === 'petani')
                        <p class="mt-2 font-medium text-exportani-text">{{ $partnership->eksportir->name }}</p>
                        @if($canViewExporterContact)
                            <p class="text-sm text-exportani-secondaryText mt-1">{{ $partnership->eksportir->email }}</p>
                            @if($partnership->eksportir->phone)
                                <p class="text-sm text-exportani-secondaryText">{{ $partnership->eksportir->phone }}</p>
                            @endif
                        @else
                            <div class="mt-3 rounded-xl border border-amber-200 bg-amber-50 p-3.5 text-xs text-amber-900 leading-relaxed shadow-sm">
                                Kontak eksportir terkunci untuk akun Free.
                                <a href="{{ route('premium.upgrade') }}" class="block mt-1.5 font-bold text-exportani-primary hover:text-exportani-dark underline">Upgrade ke Premium</a>
                            </div>
                        @endif
                    @else
                        <p class="mt-2 font-medium text-exportani-text">{{ $partnership->petani->name }}</p>
                        @if($partnership->petani->is_trusted_petani)
                            <span class="mt-2 inline-flex rounded-full bg-exportani-mint/15 border border-exportani-mint/20 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-exportani-accent">Petani Tepercaya</span>
                        @endif
                    @endif
                </div>

                @if($partnership->status === 'completed' && auth()->user()->role === 'eksportir')
                    <div class="rounded-2xl border border-exportani-border bg-white p-5 shadow-sm">
                        <h3 class="font-semibold text-exportani-text">Rating & Review</h3>
                        @if($partnership->rating)
                            <p class="mt-2 text-amber-500 text-lg">@for($i=0;$i<$partnership->rating;$i++)★@endfor</p>
                            <p class="text-sm text-exportani-secondaryText mt-2">{{ $partnership->review }}</p>
                        @else
                            <form method="POST" action="{{ route('partnerships.review', $partnership) }}" class="mt-3 space-y-3">
                                @csrf
                                <select name="rating" required class="w-full rounded-lg border-exportani-border bg-white text-exportani-text text-sm focus:border-exportani-primary focus:ring-exportani-primary">
                                    @for($r=5;$r>=1;$r--)
                                        <option value="{{ $r }}">{{ $r }} bintang</option>
                                    @endfor
                                </select>
                                <textarea name="review" rows="3" class="w-full rounded-lg border-exportani-border bg-white text-exportani-text text-sm focus:border-exportani-primary focus:ring-exportani-primary" placeholder="Testimoni untuk petani..."></textarea>
                                <x-primary-button type="submit" class="w-full justify-center">Kirim Rating</x-primary-button>
                            </form>
                        @endif
                    </div>
                @endif

                @if($partnership->rating && auth()->user()->role === 'petani')
                    <div class="rounded-2xl border border-amber-250 bg-amber-50 p-5 shadow-sm">
                        <p class="text-sm font-semibold text-amber-900">Ulasan dari eksportir</p>
                        <p class="text-amber-500 mt-1">★ {{ $partnership->rating }}/5</p>
                        <p class="text-sm text-amber-900/90 mt-2">{{ $partnership->review }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
