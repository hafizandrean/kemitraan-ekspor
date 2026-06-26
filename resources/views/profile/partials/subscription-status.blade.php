<section>
    <header>
        <h2 class="text-lg font-medium text-exportani-text font-display">Status Langganan</h2>
        <p class="mt-1 text-sm text-exportani-secondaryText">Informasi tier akun dan masa berlaku Premium.</p>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mt-6">
        <!-- Left: Plan Tier Panel (Centered & Symmetrical) -->
        <div class="md:col-span-5 flex flex-col justify-between items-center text-center rounded-2xl p-6 min-h-[250px] transition-all duration-300 relative overflow-hidden {{ $user->isPremium() ? 'bg-gradient-to-br from-amber-500/10 via-yellow-500/5 to-transparent border-2 border-amber-500/30 shadow-sm' : 'bg-exportani-background border border-exportani-border' }}">
            @if($user->isPremium())
                <!-- Gold Accent glow for premium users -->
                <div class="absolute -right-8 -top-8 w-24 h-24 bg-amber-400/20 rounded-full blur-xl"></div>
            @endif

            <div class="w-full flex flex-col items-center">
                <div class="flex flex-col items-center gap-1.5 w-full">
                    <p class="text-[10px] font-bold text-exportani-secondaryText uppercase tracking-wider">
                        Tier Saat Ini
                    </p>
                    @if($user->isPremium())
                        <span class="inline-flex items-center gap-1 rounded-full badge-premium px-2.5 py-0.5 text-[9px] uppercase tracking-wider">
                            <svg class="h-2.5 w-2.5 text-[#5B3D00] fill-current shrink-0" viewBox="0 0 24 24">
                                <path d="M12 2l2.8 7.2 7.2 2.8-7.2 2.8-2.8 7.2-2.8-7.2-7.2-2.8 7.2-2.8L12 2z"/>
                            </svg>
                            Active Premium
                        </span>
                    @else
                        <span class="inline-flex items-center rounded-full bg-exportani-border text-exportani-secondaryText border border-exportani-border/40 px-2.5 py-0.5 text-[9px] font-bold uppercase tracking-wide">
                            Free Tier
                        </span>
                    @endif
                </div>

                <div class="mt-5 flex flex-col items-center">
                    <h3 class="text-2xl font-black font-display tracking-tight {{ $user->isPremium() ? 'bg-gradient-to-r from-[#D4AF37] to-[#F5E6A3] bg-clip-text text-transparent' : 'text-exportani-text' }}">
                        {{ $user->isPremium() ? 'PREMIUM' : 'FREE TIER' }}
                    </h3>
                    @if($user->is_trusted_petani)
                        <span class="inline-flex items-center gap-0.5 rounded-full bg-exportani-mint/15 text-exportani-accent border border-exportani-mint/20 px-2 py-0.5 text-[9px] font-bold mt-1.5 uppercase">
                            <svg class="w-2.5 h-2.5 text-exportani-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            Tepercaya
                        </span>
                    @endif
                </div>

                <div class="mt-5 w-full flex justify-center">
                    @if($user->premium_expires_at)
                        <p class="text-xs text-exportani-secondaryText flex items-center justify-center gap-2 font-medium">
                            <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>Berlaku hingga <strong class="text-exportani-text">{{ $user->premium_expires_at->format('d F Y') }}</strong></span>
                        </p>
                    @else
                        <p class="text-xs text-exportani-secondaryText flex items-center justify-center gap-2 font-medium">
                            <svg class="w-4 h-4 text-exportani-secondaryText/80 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Akses dasar selamanya</span>
                        </p>
                    @endif
                </div>
            </div>

            <div class="mt-6 w-full">
                @if($user->isPremium())
                    <a href="{{ route('premium.upgrade') }}" class="w-full inline-flex justify-center items-center py-2 px-3 rounded-xl border border-exportani-border bg-white text-exportani-secondaryText hover:bg-exportani-background hover:text-exportani-primary transition duration-150 font-semibold text-xs shadow-sm">
                        Kelola Langganan
                    </a>
                @else
                    <a href="{{ route('premium.upgrade') }}" class="w-full inline-flex justify-center items-center py-2.5 px-4 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 text-white font-extrabold text-xs shadow-md transition duration-150 hover:shadow-lg">
                        Upgrade ke Premium
                    </a>
                @endif
            </div>
        </div>

        <!-- Right: Benefits Panel -->
        <div class="md:col-span-7 bg-white border border-exportani-border rounded-2xl p-6 flex flex-col justify-between shadow-sm">
            <div>
                <h4 class="text-[10px] font-bold text-exportani-text uppercase tracking-widest mb-5">
                    Benefit & Fitur Paket Anda
                </h4>

                <ul class="space-y-4">
                    @if ($user->role === 'petani')
                        <!-- Farmer Benefits -->
                        <li class="flex items-start gap-3.5">
                            <span class="flex-shrink-0 bg-exportani-mint/15 text-exportani-accent border border-exportani-mint/20 p-1 rounded-full mt-0.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <div>
                                <p class="text-sm font-bold text-exportani-text">Posting Produk Marketplace</p>
                                <p class="text-xs text-exportani-secondaryText mt-0.5 leading-relaxed">{{ $user->isPremium() ? 'Tanpa batas posting produk' : 'Terbatas maksimal 5 produk aktif' }}</p>
                            </div>
                        </li>

                        <li class="flex items-start gap-3.5">
                            <span class="flex-shrink-0 bg-exportani-mint/15 text-exportani-accent border border-exportani-mint/20 p-1 rounded-full mt-0.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <div>
                                <p class="text-sm font-bold text-exportani-text">Hubungi Eksportir Langsung</p>
                                <p class="text-xs text-exportani-secondaryText mt-0.5 leading-relaxed">{{ $user->isPremium() ? 'Fitur chat langsung tanpa batas' : 'Fitur chat terbatas hanya untuk menanggapi permohonan masuk' }}</p>
                            </div>
                        </li>

                        <li class="flex items-start gap-3.5 {{ $user->isPremium() ? '' : 'opacity-50' }}">
                            @if ($user->isPremium())
                                <span class="flex-shrink-0 bg-exportani-mint/15 text-exportani-accent border border-exportani-mint/20 p-1 rounded-full mt-0.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </span>
                                <div>
                                    <p class="text-sm font-bold text-exportani-text">Mitra Kerja Sama Prioritas</p>
                                    <p class="text-xs text-exportani-secondaryText mt-0.5 leading-relaxed">Produk Anda didahulukan di hasil pencarian eksportir</p>
                                </div>
                            @else
                                <span class="flex-shrink-0 bg-exportani-background border border-exportani-border/40 text-exportani-secondaryText/50 p-1 rounded-full mt-0.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </span>
                                <div>
                                    <p class="text-sm font-semibold text-exportani-secondaryText/80">Mitra Kerja Sama Prioritas</p>
                                    <p class="text-xs text-exportani-secondaryText/60 mt-0.5 leading-relaxed">Meningkatkan visibilitas produk Anda di mata eksportir (Khusus Premium)</p>
                                </div>
                            @endif
                        </li>

                        <li class="flex items-start gap-3.5 {{ $user->isPremium() ? '' : 'opacity-50' }}">
                            @if ($user->isPremium())
                                <span class="flex-shrink-0 bg-exportani-mint/15 text-exportani-accent border border-exportani-mint/20 p-1 rounded-full mt-0.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </span>
                                <div>
                                    <p class="text-sm font-bold text-exportani-text">Verifikasi Lencana Tepercaya</p>
                                    <p class="text-xs text-exportani-secondaryText mt-0.5 leading-relaxed">Mendapatkan potongan diskon premium hingga 20%</p>
                                </div>
                            @else
                                <span class="flex-shrink-0 bg-exportani-background border border-exportani-border/40 text-exportani-secondaryText/50 p-1 rounded-full mt-0.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </span>
                                <div>
                                    <p class="text-sm font-semibold text-exportani-secondaryText/80 font-sans">Verifikasi Lencana Tepercaya & Potongan Biaya</p>
                                    <p class="text-xs text-exportani-secondaryText/60 mt-0.5 leading-relaxed">Potongan diskon biaya langganan bulanan bagi Petani Tepercaya (Khusus Premium)</p>
                                </div>
                            @endif
                        </li>

                    @elseif ($user->role === 'eksportir')
                        <!-- Exporter Benefits -->
                        <li class="flex items-start gap-3.5">
                            <span class="flex-shrink-0 bg-exportani-mint/15 text-exportani-accent border border-exportani-mint/20 p-1 rounded-full mt-0.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <div>
                                <p class="text-sm font-bold text-exportani-text">Pencarian & Kontak Petani</p>
                                <p class="text-xs text-exportani-secondaryText mt-0.5 leading-relaxed">Mencari produk pertanian unggulan di seluruh Indonesia</p>
                            </div>
                        </li>

                        <li class="flex items-start gap-3.5">
                            <span class="flex-shrink-0 bg-exportani-mint/15 text-exportani-accent border border-exportani-mint/20 p-1 rounded-full mt-0.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <div>
                                <p class="text-sm font-bold text-exportani-text">Pengajuan Kemitraan Ekspor</p>
                                <p class="text-xs text-exportani-secondaryText mt-0.5 leading-relaxed">{{ $user->isPremium() ? 'Mengajukan kemitraan ekspor tanpa batas' : 'Terbatas maksimal mengajukan 3 kemitraan aktif' }}</p>
                            </div>
                        </li>

                        <li class="flex items-start gap-3.5">
                            <span class="flex-shrink-0 bg-exportani-mint/15 text-exportani-accent border border-exportani-mint/20 p-1 rounded-full mt-0.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <div>
                                <p class="text-sm font-bold text-exportani-text">Fitur Obrolan Langsung (Direct Chat)</p>
                                <p class="text-xs text-exportani-secondaryText mt-0.5 leading-relaxed">{{ $user->isPremium() ? 'Melakukan percakapan langsung dengan petani mana saja' : 'Percakapan terbatas hanya jika pengajuan kemitraan disetujui' }}</p>
                            </div>
                        </li>

                        <li class="flex items-start gap-3.5 {{ $user->isPremium() ? '' : 'opacity-50' }}">
                            @if ($user->isPremium())
                                <span class="flex-shrink-0 bg-exportani-mint/15 text-exportani-accent border border-exportani-mint/20 p-1 rounded-full mt-0.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </span>
                                <div>
                                    <p class="text-sm font-bold text-exportani-text">Akses Wawasan Pasar Ekspor Premium</p>
                                    <p class="text-xs text-exportani-secondaryText mt-0.5 leading-relaxed">Analisis permintaan global, harga komoditas terkini, dan tren pasar</p>
                                </div>
                            @else
                                <span class="flex-shrink-0 bg-exportani-background border border-exportani-border/40 text-exportani-secondaryText/50 p-1 rounded-full mt-0.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </span>
                                <div>
                                    <p class="text-sm font-semibold text-exportani-secondaryText/80">Akses Wawasan Pasar Ekspor Premium</p>
                                    <p class="text-xs text-exportani-secondaryText/60 mt-0.5 leading-relaxed">Mendapatkan statistik komoditas dan peluang pasar ekspor terlengkap (Khusus Premium)</p>
                                </div>
                            @endif
                        </li>

                    @else
                        <!-- Admin / Other Benefits -->
                        <li class="flex items-start gap-3.5">
                            <span class="flex-shrink-0 bg-exportani-mint/15 text-exportani-accent border border-exportani-mint/20 p-1 rounded-full mt-0.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <div>
                                <p class="text-sm font-bold text-exportani-text">Akses Dashboard Moderasi</p>
                                <p class="text-xs text-exportani-secondaryText mt-0.5 leading-relaxed">Melakukan pengawasan seluruh riwayat obrolan dan produk aktif di platform</p>
                            </div>
                        </li>

                        <li class="flex items-start gap-3.5">
                            <span class="flex-shrink-0 bg-exportani-mint/15 text-exportani-accent border border-exportani-mint/20 p-1 rounded-full mt-0.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <div>
                                <p class="text-sm font-bold text-exportani-text">Manajemen Pengguna & Lencana</p>
                                <p class="text-xs text-exportani-secondaryText mt-0.5 leading-relaxed">Memverifikasi keanggotaan premium serta status tepercaya petani</p>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</section>
