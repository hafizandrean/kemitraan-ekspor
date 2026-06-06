<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 font-display">Status Langganan</h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Informasi tier akun dan masa berlaku Premium.</p>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mt-6">
        <!-- Left: Plan Tier Panel (Centered & Symmetrical) -->
        <div class="md:col-span-5 flex flex-col justify-between items-center text-center rounded-2xl p-6 min-h-[250px] transition-all duration-300 relative overflow-hidden {{ $user->isPremium() ? 'bg-gradient-to-br from-amber-500/10 via-yellow-500/5 to-transparent border-2 border-amber-500/30 shadow-sm' : 'bg-gradient-to-br from-stone-50 via-stone-50/50 to-transparent dark:from-slate-800/40 dark:to-transparent border border-stone-200 dark:border-gray-700/50' }}">
            @if($user->isPremium())
                <!-- Gold Accent glow for premium users -->
                <div class="absolute -right-8 -top-8 w-24 h-24 bg-amber-400/20 rounded-full blur-xl"></div>
            @endif

            <div class="w-full flex flex-col items-center">
                <div class="flex flex-col items-center gap-1.5 w-full">
                    <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">
                        Tier Saat Ini
                    </p>
                    @if($user->isPremium())
                        <span class="inline-flex items-center rounded-full bg-amber-100 dark:bg-amber-950/40 text-amber-800 dark:text-amber-300 px-2.5 py-0.5 text-[10px] font-bold ring-1 ring-amber-500/15 uppercase tracking-wide">
                            Active Plan
                        </span>
                    @else
                        <span class="inline-flex items-center rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 px-2.5 py-0.5 text-[10px] font-bold ring-1 ring-slate-500/10 uppercase tracking-wide">
                            Free Tier
                        </span>
                    @endif
                </div>

                <div class="mt-5 flex flex-col items-center">
                    <h3 class="text-3xl font-black font-display tracking-tight {{ $user->isPremium() ? 'bg-gradient-to-r from-amber-500 via-yellow-500 to-amber-600 bg-clip-text text-transparent' : 'text-slate-800 dark:text-slate-200' }}">
                        {{ $user->isPremium() ? 'PREMIUM' : 'FREE TIER' }}
                    </h3>
                    @if($user->is_trusted_petani)
                        <span class="inline-flex items-center gap-0.5 rounded-full bg-emerald-100 dark:bg-emerald-950/40 text-emerald-800 dark:text-emerald-300 px-2 py-0.5 text-[9px] font-bold mt-1.5">
                            <svg class="w-2.5 h-2.5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            Tepercaya
                        </span>
                    @endif
                </div>

                <div class="mt-5 w-full flex justify-center">
                    @if($user->premium_expires_at)
                        <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>Berlaku hingga <strong>{{ $user->premium_expires_at->format('d F Y') }}</strong></span>
                        </p>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 text-slate-400 dark:text-slate-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Akses dasar selamanya</span>
                        </p>
                    @endif
                </div>
            </div>

            <div class="mt-6 w-full">
                @if($user->isPremium())
                    <a href="{{ route('premium.upgrade') }}" class="w-full inline-flex justify-center items-center py-2.5 px-4 rounded-xl border border-gray-300 dark:border-gray-600 hover:bg-stone-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-bold text-xs transition duration-200">
                        Kelola Langganan
                    </a>
                @else
                    <a href="{{ route('premium.upgrade') }}" class="w-full inline-flex justify-center items-center py-3 px-4 rounded-xl bg-gradient-to-r from-amber-500 via-yellow-500 to-amber-600 text-stone-900 font-extrabold text-sm shadow-md hover:from-amber-600 hover:to-amber-700 hover:shadow-lg transition duration-200 transform hover:-translate-y-0.5">
                        Upgrade ke Premium
                    </a>
                @endif
            </div>
        </div>

        <!-- Right: Benefits Panel -->
        <div class="md:col-span-7 bg-white dark:bg-gray-800 border border-stone-200 dark:border-gray-700/50 rounded-2xl p-6 flex flex-col justify-between">
            <div>
                <h4 class="text-sm font-bold text-gray-800 dark:text-gray-200 uppercase tracking-widest mb-5">
                    Benefit & Fitur Paket Anda
                </h4>

                <ul class="space-y-4">
                    @if ($user->role === 'petani')
                        <!-- Farmer Benefits -->
                        <li class="flex items-start gap-3.5">
                            <span class="flex-shrink-0 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 p-1 rounded-full mt-0.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <div>
                                <p class="text-sm font-bold text-gray-900 dark:text-gray-100">Posting Produk Marketplace</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">{{ $user->isPremium() ? 'Tanpa batas posting produk' : 'Terbatas maksimal 5 produk aktif' }}</p>
                            </div>
                        </li>

                        <li class="flex items-start gap-3.5">
                            <span class="flex-shrink-0 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 p-1 rounded-full mt-0.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <div>
                                <p class="text-sm font-bold text-gray-900 dark:text-gray-100">Hubungi Eksportir Langsung</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">{{ $user->isPremium() ? 'Fitur chat langsung tanpa batas' : 'Fitur chat terbatas hanya untuk menanggapi permohonan masuk' }}</p>
                            </div>
                        </li>

                        <li class="flex items-start gap-3.5 {{ $user->isPremium() ? '' : 'opacity-60' }}">
                            @if ($user->isPremium())
                                <span class="flex-shrink-0 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 p-1 rounded-full mt-0.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </span>
                                <div>
                                    <p class="text-sm font-bold text-gray-900 dark:text-gray-100">Mitra Kerja Sama Prioritas</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">Produk Anda didahulukan di hasil pencarian eksportir</p>
                                </div>
                            @else
                                <span class="flex-shrink-0 bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-505 p-1 rounded-full mt-0.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </span>
                                <div>
                                    <p class="text-sm font-semibold text-slate-400 dark:text-slate-500">Mitra Kerja Sama Prioritas</p>
                                    <p class="text-xs text-slate-505 dark:text-slate-600 mt-1 leading-relaxed">Meningkatkan visibilitas produk Anda di mata eksportir (Khusus Premium)</p>
                                </div>
                            @endif
                        </li>

                        <li class="flex items-start gap-3.5 {{ $user->isPremium() ? '' : 'opacity-60' }}">
                            @if ($user->isPremium())
                                <span class="flex-shrink-0 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 p-1 rounded-full mt-0.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </span>
                                <div>
                                    <p class="text-sm font-bold text-gray-900 dark:text-gray-100">Verifikasi Lencana Tepercaya</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">Mendapatkan potongan diskon premium hingga 20%</p>
                                </div>
                            @else
                                <span class="flex-shrink-0 bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-505 p-1 rounded-full mt-0.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </span>
                                <div>
                                    <p class="text-sm font-semibold text-slate-400 dark:text-slate-500 font-sans">Verifikasi Lencana Tepercaya & Potongan Biaya</p>
                                    <p class="text-xs text-slate-505 dark:text-slate-600 mt-1 leading-relaxed">Potongan diskon biaya langganan bulanan bagi Petani Tepercaya (Khusus Premium)</p>
                                </div>
                            @endif
                        </li>

                    @elseif ($user->role === 'eksportir')
                        <!-- Exporter Benefits -->
                        <li class="flex items-start gap-3.5">
                            <span class="flex-shrink-0 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 p-1 rounded-full mt-0.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <div>
                                <p class="text-sm font-bold text-gray-900 dark:text-gray-100">Pencarian & Kontak Petani</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">Mencari produk pertanian unggulan di seluruh Indonesia</p>
                            </div>
                        </li>

                        <li class="flex items-start gap-3.5">
                            <span class="flex-shrink-0 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 p-1 rounded-full mt-0.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <div>
                                <p class="text-sm font-bold text-gray-900 dark:text-gray-100">Pengajuan Kemitraan Ekspor</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">{{ $user->isPremium() ? 'Mengajukan kemitraan ekspor tanpa batas' : 'Terbatas maksimal mengajukan 3 kemitraan aktif' }}</p>
                            </div>
                        </li>

                        <li class="flex items-start gap-3.5">
                            <span class="flex-shrink-0 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 p-1 rounded-full mt-0.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <div>
                                <p class="text-sm font-bold text-gray-900 dark:text-gray-100">Fitur Obrolan Langsung (Direct Chat)</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">{{ $user->isPremium() ? 'Melakukan percakapan langsung dengan petani mana saja' : 'Percakapan terbatas hanya jika pengajuan kemitraan disetujui' }}</p>
                            </div>
                        </li>

                        <li class="flex items-start gap-3.5 {{ $user->isPremium() ? '' : 'opacity-60' }}">
                            @if ($user->isPremium())
                                <span class="flex-shrink-0 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 p-1 rounded-full mt-0.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </span>
                                <div>
                                    <p class="text-sm font-bold text-gray-900 dark:text-gray-100">Akses Wawasan Pasar Ekspor Premium</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">Analisis permintaan global, harga komoditas terkini, dan tren pasar</p>
                                </div>
                            @else
                                <span class="flex-shrink-0 bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-505 p-1 rounded-full mt-0.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </span>
                                <div>
                                    <p class="text-sm font-semibold text-slate-400 dark:text-slate-500">Akses Wawasan Pasar Ekspor Premium</p>
                                    <p class="text-xs text-slate-505 dark:text-slate-600 mt-1 leading-relaxed">Mendapatkan statistik komoditas dan peluang pasar ekspor terlengkap (Khusus Premium)</p>
                                </div>
                            @endif
                        </li>

                    @else
                        <!-- Admin / Other Benefits -->
                        <li class="flex items-start gap-3.5">
                            <span class="flex-shrink-0 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 p-1 rounded-full mt-0.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <div>
                                <p class="text-sm font-bold text-gray-900 dark:text-gray-100">Akses Dashboard Moderasi</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">Melakukan pengawasan seluruh riwayat obrolan dan produk aktif di platform</p>
                            </div>
                        </li>

                        <li class="flex items-start gap-3.5">
                            <span class="flex-shrink-0 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 p-1 rounded-full mt-0.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <div>
                                <p class="text-sm font-bold text-gray-900 dark:text-gray-100">Manajemen Pengguna & Lencana</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">Memverifikasi keanggotaan premium serta status tepercaya petani</p>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</section>
