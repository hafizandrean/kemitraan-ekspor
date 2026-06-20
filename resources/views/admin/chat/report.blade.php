<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.chat.dashboard') }}" class="flex h-10 w-10 items-center justify-center rounded-full bg-stone-100 dark:bg-gray-750 text-stone-500 dark:text-gray-400 hover:bg-exportani-mint/10 hover:text-exportani-primary transition-colors">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="font-display text-2xl font-semibold text-exportani-text tracking-tight">
                    Tinjau Laporan Chat
                </h2>
                <p class="mt-1 text-sm text-exportani-secondaryText">Analisis isi percakapan dan putuskan tindakan administratif.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left 2 Cols: Chat Transcripts -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 border border-exportani-border dark:border-gray-700/50 rounded-2xl shadow-sm overflow-hidden flex flex-col h-[600px]">
                <div class="px-6 py-4 bg-stone-50 dark:bg-gray-900/30 border-b border-stone-100 dark:border-gray-700/50 flex items-center justify-between shrink-0">
                    <div>
                        <h3 class="font-semibold text-stone-900 dark:text-white text-xs">Transkrip Percakapan</h3>
                        @if($report->conversation && $report->conversation->product)
                            <p class="text-[10px] text-stone-500 dark:text-stone-400 mt-0.5">Produk terkait: <span class="font-bold text-exportani-primary">{{ $report->conversation->product->nama_produk }}</span></p>
                        @endif
                    </div>
                    <span class="text-[9px] bg-red-50 dark:bg-red-950/20 text-red-700 dark:text-red-400 font-bold px-2 py-0.5 rounded border border-red-500/10 uppercase tracking-wide">Privasi Terbuka (Moderasi)</span>
                </div>

                <!-- Scrollable Messages Stream -->
                <div class="flex-1 overflow-y-auto p-6 space-y-4 bg-stone-50/50 dark:bg-gray-900/10">
                    @forelse($messages as $msg)
                        @php
                            $isReporter = $msg->sender_id === $report->reporter_id;
                            $isReported = $msg->sender_id === $report->reported_user_id;
                            $senderName = $msg->sender->name;
                            $senderRole = $msg->sender->role;
                        @endphp
                        
                        <div class="flex flex-col {{ $isReporter ? 'items-start' : 'items-end' }}">
                            <div class="flex items-center gap-1.5 mb-1 px-1">
                                <span class="text-[10px] font-bold text-stone-850 dark:text-gray-250">{{ $senderName }}</span>
                                <span class="text-[9px] uppercase tracking-wider text-stone-400 dark:text-stone-500">({{ $senderRole }})</span>
                                @if($isReporter)
                                    <span class="bg-blue-50 dark:bg-blue-950/30 text-blue-700 dark:text-blue-400 text-[8px] font-extrabold px-1 rounded uppercase tracking-wider">Pelapor</span>
                                @elseif($isReported)
                                    <span class="bg-red-50 dark:bg-red-950/30 text-red-700 dark:text-red-400 text-[8px] font-extrabold px-1 rounded uppercase tracking-wider">Terlapor</span>
                                @endif
                            </div>
                            
                            <div class="max-w-[85%] rounded-2xl px-4 py-2.5 text-xs shadow-sm {{ $isReporter ? 'bg-white dark:bg-gray-700 text-stone-800 dark:text-gray-200 rounded-tl-none border border-stone-200/50 dark:border-gray-650' : 'bg-exportani-primary text-white rounded-tr-none' }}">
                                <p class="whitespace-pre-wrap leading-relaxed">{{ $msg->message }}</p>
                            </div>
                            <span class="text-[9px] text-stone-400 mt-1 px-1">{{ $msg->created_at->format('d M H:i') }}</span>
                        </div>
                    @empty
                        <div class="h-full flex flex-col items-center justify-center text-stone-400 dark:text-stone-500">
                            <svg class="h-12 w-12 text-stone-300 dark:text-gray-700 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            <p class="text-xs">Tidak ada riwayat pesan dalam percakapan ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Column: Moderation Details & Actions -->
        <div class="space-y-6">
            <!-- Card 1: Detail Aduan -->
            <div class="bg-white dark:bg-gray-800 border border-exportani-border dark:border-gray-700/50 rounded-2xl shadow-sm p-6 space-y-4">
                <h3 class="font-display text-sm font-bold text-stone-900 dark:text-white pb-3 border-b border-stone-100 dark:border-gray-700/50">Detail Laporan</h3>
                
                <div class="space-y-3.5 text-xs">
                    <div>
                        <span class="block text-[10px] font-bold text-stone-400 dark:text-stone-500 uppercase tracking-wide">Pengadu / Pelapor</span>
                        <div class="mt-1 font-semibold text-stone-850 dark:text-white">
                            {{ $report->reporter->name }} <span class="text-[10px] text-stone-400 dark:text-stone-500">({{ $report->reporter->email }})</span>
                        </div>
                    </div>

                    <div>
                        <span class="block text-[10px] font-bold text-stone-400 dark:text-stone-500 uppercase tracking-wide">Yang Dilaporkan</span>
                        <div class="mt-1 font-semibold text-stone-850 dark:text-white">
                            {{ $report->reportedUser->name }} <span class="text-[10px] text-stone-400 dark:text-stone-500">({{ $report->reportedUser->email }})</span>
                        </div>
                    </div>

                    <div>
                        <span class="block text-[10px] font-bold text-stone-400 dark:text-stone-500 uppercase tracking-wide">Kategori Pelanggaran</span>
                        <div class="mt-1.5">
                            @php
                                $reasonLabels = [
                                    'spam' => 'Spam / Pesan Massal',
                                    'fraud' => 'Penipuan / Fraud',
                                    'harassment' => 'Pelecehan / Kata Kasar',
                                    'inappropriate' => 'Konten Tidak Pantas',
                                    'other' => 'Lainnya'
                                ];
                                $label = $reasonLabels[$report->reason] ?? ucfirst($report->reason);
                            @endphp
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[10px] font-bold bg-red-50 dark:bg-red-950/20 text-red-700 dark:text-red-400 border border-red-500/10">
                                {{ $label }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <span class="block text-[10px] font-bold text-stone-400 dark:text-stone-500 uppercase tracking-wide">Deskripsi Pengaduan</span>
                        <div class="mt-1.5 p-3 bg-stone-50 dark:bg-gray-900 border border-stone-200/60 dark:border-gray-750 rounded-xl text-stone-700 dark:text-gray-300 leading-relaxed font-sans italic">
                            "{{ $report->description }}"
                        </div>
                    </div>

                    <div>
                        <span class="block text-[10px] font-bold text-stone-400 dark:text-stone-500 uppercase tracking-wide">Tanggal Masuk</span>
                        <div class="mt-1 font-medium text-stone-600 dark:text-stone-400">
                            {{ $report->created_at->format('d M Y - H:i:s') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Form Keputusan Admin -->
            <div class="bg-white dark:bg-gray-800 border border-exportani-border dark:border-gray-700/50 rounded-2xl shadow-sm p-6 space-y-4">
                <h3 class="font-display text-sm font-bold text-stone-900 dark:text-white pb-3 border-b border-stone-100 dark:border-gray-700/50">Tindakan Laporan</h3>
                
                @if($report->status === 'pending')
                    <div class="space-y-3 pt-1">
                        <form method="POST" action="{{ route('admin.chat.report.resolve', $report) }}">
                            @csrf
                            <input type="hidden" name="action" value="resolve">
                            <button type="submit" class="w-full inline-flex items-center justify-center rounded-xl bg-exportani-primary hover:bg-exportani-dark text-white font-bold py-3 text-xs shadow-md transition-colors">
                                Selesaikan Laporan (Resolve)
                            </button>
                        </form>
                        
                        <form method="POST" action="{{ route('admin.chat.report.resolve', $report) }}">
                            @csrf
                            <input type="hidden" name="action" value="dismiss">
                            <button type="submit" class="w-full inline-flex items-center justify-center rounded-xl border border-stone-250 dark:border-gray-700 bg-white dark:bg-gray-900 hover:bg-stone-50 dark:hover:bg-gray-750 text-stone-700 dark:text-gray-300 font-bold py-3 text-xs transition duration-150">
                                Abaikan / Tolak Laporan (Dismiss)
                            </button>
                        </form>
                    </div>
                @else
                    <div class="rounded-xl p-4 bg-stone-50 dark:bg-gray-900 border border-stone-150 dark:border-gray-750 text-center space-y-1">
                        <span class="block text-[10px] font-bold uppercase tracking-wider text-stone-400 dark:text-stone-500">Status Laporan</span>
                        <strong class="text-xs uppercase tracking-widest text-exportani-primary font-black">
                            {{ $report->status === 'resolved' ? 'Selesai (Resolved)' : 'Ditolak (Dismissed)' }}
                        </strong>
                    </div>
                @endif
            </div>

            <!-- Card 3: Administrasi Pengguna Terlapor -->
            <div class="bg-white dark:bg-gray-800 border border-exportani-border dark:border-gray-700/50 rounded-2xl shadow-sm p-6 space-y-4">
                <h3 class="font-display text-sm font-bold text-stone-900 dark:text-white pb-3 border-b border-stone-100 dark:border-gray-700/50">Status Pengguna Terlapor</h3>
                
                <div class="space-y-4 pt-1">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-stone-500 dark:text-stone-400">Status Akun Terlapor:</span>
                        @if($report->reportedUser->status === 'suspended')
                            <span class="inline-flex items-center rounded-full bg-amber-100 dark:bg-amber-950/45 px-2.5 py-0.5 text-xs font-bold text-amber-800 dark:text-amber-300 border border-amber-500/10">Suspended</span>
                        @elseif($report->reportedUser->status === 'banned')
                            <span class="inline-flex items-center rounded-full bg-red-100 dark:bg-red-950/45 px-2.5 py-0.5 text-xs font-bold text-red-800 dark:text-red-300 border border-red-500/10">Banned</span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-exportani-mint/15 px-2.5 py-0.5 text-xs font-bold text-exportani-accent border border-exportani-mint/20">Active</span>
                        @endif
                    </div>

                    <form method="POST" action="{{ route('admin.users.status.update', $report->reportedUser) }}" class="space-y-2.5">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-bold text-stone-500 dark:text-stone-400 uppercase tracking-wide mb-1.5">Ubah Status Akun</label>
                            <select name="status" required class="w-full rounded-xl border border-stone-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-stone-850 dark:text-gray-200 py-2.5 px-3 text-xs font-semibold focus:outline-none focus:ring-1 focus:ring-exportani-primary focus:border-exportani-primary">
                                <option value="active" {{ $report->reportedUser->status === 'active' ? 'selected' : '' }}>Aktifkan Akun (Active)</option>
                                <option value="suspended" {{ $report->reportedUser->status === 'suspended' ? 'selected' : '' }}>Tangguhkan Akun (Suspend)</option>
                                <option value="banned" {{ $report->reportedUser->status === 'banned' ? 'selected' : '' }}>Blokir Permanen (Ban)</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="w-full inline-flex items-center justify-center rounded-xl bg-stone-900 dark:bg-gray-700 hover:bg-stone-800 dark:hover:bg-gray-650 text-white font-bold py-2.5 text-xs transition duration-150 shadow-sm">
                            Terapkan Status Baru
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
