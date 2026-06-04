<x-app-layout>
    <div class="h-[calc(100vh-3rem)] flex overflow-hidden bg-stone-50" x-data="{ reportModalOpen: false }">
        
        <!-- Chat Sidebar -->
        <div class="w-full md:w-80 lg:w-96 border-r border-stone-200 bg-white flex flex-col shrink-0 {{ isset($conversation) ? 'hidden md:flex' : 'flex' }}">
            <div class="p-4 border-b border-stone-100 flex items-center justify-between bg-stone-50/50">
                <h2 class="font-display text-lg font-bold text-stone-900 tracking-tight">Daftar Chat</h2>
                @if(($unreadMessagesCount ?? 0) > 0)
                    <span class="inline-flex items-center rounded-full bg-amber-100 px-2 py-0.5 text-xs font-semibold text-amber-800">
                        {{ $unreadMessagesCount }} baru
                    </span>
                @endif
            </div>

            <!-- List of Chats -->
            <div class="flex-1 overflow-y-auto divide-y divide-stone-100">
                @forelse($conversations as $conv)
                    @php
                        $opponent = Auth::id() === $conv->farmer_id ? $conv->exporter : $conv->farmer;
                        $isActive = isset($conversation) && $conversation->id === $conv->id;
                        $latestMsg = $conv->latestMessage();
                        $unreadCount = $conv->unreadMessagesCountFor(Auth::user());
                    @endphp
                    <a href="{{ route('chat.show', $conv) }}" class="flex items-start gap-3 p-4 text-left transition hover:bg-stone-50/80 {{ $isActive ? 'bg-emerald-50/70 border-l-4 border-emerald-600' : '' }}">
                        <!-- Avatar -->
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-100 font-bold text-emerald-800 text-sm">
                            {{ substr($opponent->name, 0, 1) }}
                        </div>
                        
                        <!-- Details -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-semibold text-stone-900 text-sm truncate pr-2">{{ $opponent->name }}</span>
                                <span class="text-[10px] text-stone-400 shrink-0">
                                    {{ $conv->last_message_at ? $conv->last_message_at->diffForHumans() : $conv->updated_at->diffForHumans() }}
                                </span>
                            </div>
                            
                            <div class="flex items-center gap-1.5 mb-1.5">
                                @if($opponent->role === 'petani')
                                    <span class="inline-flex items-center rounded bg-emerald-50 px-1.5 py-0.5 text-[10px] font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/10">Petani</span>
                                @else
                                    <span class="inline-flex items-center rounded bg-sky-50 px-1.5 py-0.5 text-[10px] font-medium text-sky-700 ring-1 ring-inset ring-sky-600/10">Eksportir</span>
                                @endif
                                
                                @if($conv->product)
                                    <span class="inline-flex items-center rounded bg-amber-50 px-1.5 py-0.5 text-[10px] font-medium text-amber-700 ring-1 ring-inset ring-amber-600/10 truncate max-w-[120px]">
                                        {{ $conv->product->nama_produk }}
                                    </span>
                                @endif
                            </div>

                            <p class="text-xs text-stone-500 truncate">
                                @if($latestMsg)
                                    {{ $latestMsg->sender_id === Auth::id() ? 'Anda: ' : '' }}{{ $latestMsg->message }}
                                @else
                                    <i>Belum ada pesan</i>
                                @endif
                            </p>
                        </div>
                        
                        <!-- Unread dot -->
                        @if($unreadCount > 0)
                            <div class="mt-1 shrink-0 flex h-5 min-w-5 items-center justify-center rounded-full bg-amber-500 px-1 text-[10px] font-bold text-stone-900">
                                {{ $unreadCount }}
                            </div>
                        @endif
                    </a>
                @empty
                    <div class="p-8 text-center text-stone-500 text-sm">
                        <svg class="mx-auto h-8 w-8 text-stone-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        Belum ada percakapan.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Chat Room -->
        <div class="flex-1 flex flex-col bg-stone-100/30 {{ !isset($conversation) ? 'hidden md:flex' : 'flex' }}">
            @if(isset($conversation))
                @php
                    $opponent = Auth::id() === $conversation->farmer_id ? $conversation->exporter : $conversation->farmer;
                @endphp
                <!-- Header -->
                <div class="h-16 px-6 border-b border-stone-200 bg-white flex items-center justify-between shrink-0">
                    <div class="flex items-center gap-3">
                        <!-- Back button for mobile -->
                        <a href="{{ route('chat.index') }}" class="md:hidden p-1.5 rounded-lg text-stone-500 hover:bg-stone-100 hover:text-stone-700 transition">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                        
                        <div>
                            <h3 class="font-display font-bold text-stone-900">{{ $opponent->name }}</h3>
                            <div class="flex items-center gap-1.5 mt-0.5">
                                <span class="text-xs text-stone-500 uppercase font-semibold tracking-wider">
                                    {{ $opponent->role === 'petani' ? 'Petani' : 'Eksportir' }}
                                </span>
                                @if($conversation->product)
                                    <span class="text-xs text-stone-300">•</span>
                                    <a href="{{ route('products.show', $conversation->product) }}" class="text-xs text-emerald-600 hover:underline inline-flex items-center gap-0.5">
                                        Percakapan terkait: {{ $conversation->product->nama_produk }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Actions (Report) -->
                    <div>
                        <button type="button" @click="reportModalOpen = true" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-rose-600 border border-rose-200 rounded-lg hover:bg-rose-50 transition">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            Laporkan Pengguna
                        </button>
                    </div>
                </div>

                <!-- Messages Stream -->
                <div class="flex-1 overflow-y-auto p-6 space-y-4">
                    @forelse($messages as $msg)
                        @php
                            $isMe = $msg->sender_id === Auth::id();
                        @endphp
                        <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[70%] flex flex-col {{ $isMe ? 'items-end' : 'items-start' }}">
                                <div class="rounded-2xl px-4 py-2.5 text-sm shadow-sm {{ $isMe ? 'bg-emerald-600 text-white rounded-tr-none' : 'bg-white text-stone-800 border border-stone-200/80 rounded-tl-none' }}">
                                    <p class="whitespace-pre-wrap leading-relaxed">{{ $msg->message }}</p>
                                </div>
                                <span class="text-[10px] text-stone-400 mt-1 px-1">
                                    {{ $msg->created_at->format('H:i') }}
                                    @if($isMe)
                                        <span class="ml-1 text-emerald-600 font-semibold">{{ $msg->is_read ? 'Dibaca' : 'Terkirim' }}</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="h-full flex flex-col items-center justify-center text-stone-400">
                            <p class="text-sm">Belum ada pesan. Mulai percakapan sekarang!</p>
                        </div>
                    @endforelse
                </div>

                <!-- Input Form -->
                <div class="p-4 border-t border-stone-200 bg-white shrink-0">
                    @if(Auth::user()->isSuspended())
                        <div class="rounded-xl bg-amber-50 border border-amber-200 p-3 text-xs text-amber-800 text-center">
                            Akun Anda sedang ditangguhkan (suspended) oleh admin. Anda tidak dapat mengirimkan pesan.
                        </div>
                    @else
                        <form method="POST" action="{{ route('chat.store', $conversation) }}" class="flex items-center gap-2">
                            @csrf
                            <input type="text" name="message" required placeholder="Tulis pesan Anda..." autocomplete="off" class="flex-1 rounded-xl border border-stone-200 px-4 py-2.5 text-sm text-stone-800 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500">
                            <button type="submit" class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-600 text-white hover:bg-emerald-500 shadow transition-colors shrink-0">
                                <svg class="h-5 w-5 transform rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Report Modal -->
                <div x-show="reportModalOpen" class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto outline-none" style="display: none;">
                    <div class="fixed inset-0 bg-stone-900/50 backdrop-blur-sm transition-opacity" @click="reportModalOpen = false"></div>
                    
                    <div class="relative w-full max-w-md mx-auto bg-white rounded-2xl shadow-xl z-50 border border-stone-200 overflow-hidden">
                        <div class="p-6 border-b border-stone-100 flex items-center justify-between">
                            <h3 class="font-display font-bold text-stone-900">Laporkan Pengguna</h3>
                            <button type="button" @click="reportModalOpen = false" class="text-stone-400 hover:text-stone-600">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        
                        <form method="POST" action="{{ route('chat.report') }}" class="p-6 space-y-4">
                            @csrf
                            <input type="hidden" name="reported_user_id" value="{{ $opponent->id }}">
                            <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                            
                            <div>
                                <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wide mb-1.5">Alasan Pelaporan</label>
                                <select name="reason" required class="w-full rounded-lg border border-stone-200 text-sm text-stone-800 py-2.5 px-3 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500">
                                    <option value="spam">Spam / Pesan Bertubi-tubi</option>
                                    <option value="fraud">Penipuan / Fraud</option>
                                    <option value="harassment">Pelecehan / Kata-kata Tidak Layak</option>
                                    <option value="inappropriate">Konten Tidak Pantas</option>
                                    <option value="other">Lainnya</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-semibold text-stone-500 uppercase tracking-wide mb-1.5">Deskripsi Masalah</label>
                                <textarea name="description" required rows="4" minlength="10" placeholder="Jelaskan detail pelanggaran agar admin dapat mengevaluasi..." class="w-full rounded-lg border border-stone-200 text-sm text-stone-800 py-2 px-3 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500"></textarea>
                            </div>
                            
                            <div class="flex items-center justify-end gap-3 pt-2">
                                <button type="button" @click="reportModalOpen = false" class="px-4 py-2 text-sm font-semibold text-stone-600 rounded-lg hover:bg-stone-50">Batal</button>
                                <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-rose-600 rounded-lg hover:bg-rose-500 shadow-sm transition">Kirim Laporan</button>
                            </div>
                        </form>
                    </div>
                </div>

            @else
                <!-- Placeholder when no conversation is selected -->
                <div class="flex-1 flex flex-col items-center justify-center p-8 bg-stone-50 text-stone-500">
                    <svg class="h-16 w-16 text-stone-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <h3 class="font-display font-bold text-stone-800 text-base">Mulai Diskusi Kemitraan</h3>
                    <p class="text-sm text-stone-500 text-center max-w-sm mt-1">Pilih salah satu percakapan di daftar kiri untuk membaca pesan atau hubungi petani langsung dari halaman detail produk.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>