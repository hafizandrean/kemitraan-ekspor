<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-display text-lg font-bold text-exportani-text tracking-tight">EXPORTANI Premium</h2>
                <p class="mt-0.5 text-xs text-exportani-secondaryText">Value & keanggotaan premium Anda untuk perluas pasar global.</p>
            </div>
            <div class="shrink-0">
                <a href="{{ route('subscription.history') }}" class="inline-flex items-center gap-1.5 rounded-lg border border-exportani-border bg-white px-3 py-1.5 text-xs font-semibold text-exportani-secondaryText hover:bg-exportani-background hover:text-exportani-primary transition duration-150 shadow-sm">
                    <svg class="h-3.5 w-3.5 text-exportani-secondaryText" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Riwayat Langganan
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto space-y-8">
        
        <!-- Notification Alerts -->
        @if(session('success'))
            <div class="rounded-xl border border-exportani-mint/30 bg-exportani-mint/10 p-4 text-xs text-exportani-accent shadow-sm flex items-start gap-2.5">
                <svg class="h-4 w-4 text-exportani-primary shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <span class="font-bold">Berhasil:</span> {{ session('success') }}
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="rounded-xl border border-rose-200 bg-rose-50/60 p-4 text-xs text-rose-900 shadow-sm flex items-start gap-2.5">
                <svg class="h-4 w-4 text-rose-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div>
                    <span class="font-bold">Perhatian:</span> {{ session('error') }}
                </div>
            </div>
        @endif

        @php
            $premiumPlan = $plans->firstWhere('price', '>', 0);
            $freePlan = $plans->firstWhere('price', 0);
            
            $priceDisplay = $premiumPlan ? $premiumPlan->price : 50000;
            $hasDiscount = false;
            if ($premiumPlan && $user->role === 'petani' && $trustedDiscount) {
                $priceDisplay = $premiumPlan->price * 0.8;
                $hasDiscount = true;
            }
        @endphp

        <!-- 1. HERO PREMIUM (100% WIDTH) -->
        <div class="relative overflow-hidden bg-white shadow-sm border border-exportani-border rounded-2xl py-8 px-8 transition duration-300">
            <!-- Top Gradient Bar -->
            <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-exportani-teal via-exportani-mint to-exportani-primary"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="space-y-2 text-center sm:text-left max-w-xl">
                    <span class="inline-flex items-center gap-1 rounded-full badge-premium px-2.5 py-0.5 text-[9px] uppercase tracking-wider">
                        <svg class="h-2.5 w-2.5 text-[#5B3D00] fill-current shrink-0" viewBox="0 0 24 24">
                            <path d="M12 2l2.8 7.2 7.2 2.8-7.2 2.8-2.8 7.2-2.8-7.2-7.2-2.8 7.2-2.8L12 2z"/>
                        </svg>
                        EXPORTANI Premium
                    </span>
                    <h1 class="text-xl md:text-2xl font-black text-exportani-text leading-tight font-display mt-1">
                        Akses Penuh Tanpa Batas
                    </h1>
                    <p class="text-exportani-secondaryText text-xs font-medium leading-relaxed">
                        Perluas peluang ekspor dengan akses kemitraan tanpa batas, analisis pasar komoditas, dan komunikasi langsung dengan mitra potensial.
                    </p>
                </div>

                <!-- Live Status Meta Indicator (Right Panel of Hero) -->
                <div class="shrink-0 flex justify-center md:justify-end text-center md:text-right">
                    @if($isPremium && $activeSubscription)
                        <div class="bg-gradient-to-br from-amber-500/5 to-transparent border border-amber-200/60 rounded-xl px-5 py-4 min-w-[200px]">
                            <span class="inline-flex items-center gap-1.5 rounded-full badge-premium px-2 py-0.5 text-[9px] uppercase tracking-wider">
                                <svg class="h-2.5 w-2.5 text-[#5B3D00] fill-current shrink-0" viewBox="0 0 24 24">
                                    <path d="M12 2l2.8 7.2 7.2 2.8-7.2 2.8-2.8 7.2-2.8-7.2-7.2-2.8 7.2-2.8L12 2z"/>
                                </svg>
                                Premium Aktif
                            </span>
                            <p class="text-[10px] text-exportani-secondaryText mt-2 font-medium">Aktif hingga</p>
                            <p class="text-xs font-bold text-exportani-text mt-0.5">{{ $activeSubscription->end_date->format('d M Y') }}</p>
                        </div>
                    @else
                        <div class="bg-exportani-background border border-exportani-border rounded-xl px-5 py-4 min-w-[200px]">
                            <span class="inline-flex items-center rounded-full bg-exportani-border text-exportani-secondaryText px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider">
                                Akun Free
                            </span>
                            <p class="text-[10px] text-exportani-secondaryText mt-2 font-medium">Status Fitur</p>
                            <p class="text-xs font-bold text-exportani-text mt-0.5">Kemitraan Terbatas</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- 2. STATUS + PRICING (50/50 SPLIT GRID) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Left: Membership Management -->
            <div class="rounded-2xl border border-exportani-border bg-white p-8 shadow-sm flex flex-col justify-between hover:shadow-md transition-all duration-300">
                <div class="space-y-6">
                    <div>
                        <span class="text-[9px] font-extrabold uppercase tracking-wider text-exportani-secondaryText font-sans">Kelola Keanggotaan</span>
                        <h3 class="text-lg font-bold text-exportani-text mt-1">Status Keanggotaan</h3>
                        <p class="text-xs text-exportani-secondaryText mt-1.5 leading-relaxed">Kelola subscription otomatis dan simpan tagihan transaksi Anda secara transparan.</p>
                    </div>

                    @if($isPremium && $activeSubscription)
                        <div class="rounded-xl border border-emerald-100 bg-emerald-50/20 px-5 py-4 space-y-3">
                            <div class="flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span class="text-xs font-bold text-emerald-800 uppercase tracking-wider">Premium Member</span>
                            </div>
                            <div class="text-xs text-stone-700 space-y-1">
                                <p>Paket Langganan: <strong class="text-stone-900 font-bold">{{ $activeSubscription->plan->name }}</strong></p>
                                <p>Masa aktif: <span class="font-medium text-stone-900">s/d {{ $activeSubscription->end_date->format('d M Y') }}</span></p>
                            </div>
                            <a href="{{ route('premium.insight') }}" class="w-full inline-flex justify-center items-center py-2 px-3 rounded-lg bg-exportani-primary hover:bg-exportani-dark text-white font-bold text-xs shadow-sm transition">
                                Buka Analisis Pasar &rarr;
                            </a>
                        </div>
                    @elseif($pendingSubscription)
                        <div class="rounded-xl border border-amber-200 bg-amber-50/50 px-5 py-4 space-y-3">
                            <div class="flex items-center gap-1.5 text-amber-700">
                                <svg class="h-4 w-4 text-amber-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-xs font-bold uppercase tracking-wider">Pembayaran Pending</span>
                            </div>
                            <p class="text-xs text-amber-800 leading-relaxed">Selesaikan pembayaran transaksi untuk mengaktifkan keanggotaan Premium.</p>
                            <div class="flex items-center justify-between text-xs border-t border-amber-200/50 pt-2.5">
                                <span class="text-exportani-secondaryText">Total Tagihan:</span>
                                <strong class="text-amber-600 font-black">Rp{{ number_format($pendingSubscription->gross_amount, 0, ',', '.') }}</strong>
                            </div>
                        </div>
                    @elseif($user->premium_expires_at && $user->premium_expires_at->isPast())
                        <div class="rounded-xl border border-rose-100 bg-rose-50/20 px-5 py-4 space-y-2">
                            <div class="flex items-center gap-2 text-rose-700">
                                <span class="h-2 w-2 rounded-full bg-rose-500"></span>
                                <span class="text-xs font-bold uppercase tracking-wider">Premium Kedaluwarsa</span>
                            </div>
                            <p class="text-xs text-rose-800">Masa aktif langganan Anda telah berakhir pada {{ $user->premium_expires_at->format('d M Y') }}.</p>
                        </div>
                    @else
                        <div class="rounded-xl border border-exportani-border bg-exportani-background px-5 py-4">
                            <span class="inline-flex items-center rounded-full bg-exportani-border text-exportani-secondaryText px-2 py-0.5 text-[9px] font-semibold">
                                Akun Free Tier
                            </span>
                            <p class="text-xs text-exportani-secondaryText mt-2 leading-relaxed">Anda saat ini memiliki batas pengiriman proposal dan posting katalog produk.</p>
                        </div>
                    @endif
                </div>

                <div class="pt-6 border-t border-exportani-border mt-6 flex justify-between items-center">
                    <span class="text-xs text-exportani-secondaryText font-medium">Riwayat transaksi langganan</span>
                    <a href="{{ route('subscription.history') }}" class="text-xs font-bold text-exportani-primary hover:text-exportani-dark hover:underline transition">
                        Lihat Invoice &rarr;
                    </a>
                </div>
            </div>

            <!-- Right: Premium Plan Card -->
            @if($premiumPlan)
                <div class="rounded-2xl bg-white p-8 flex flex-col justify-between relative {{ $isPremium ? 'ring-2 ring-exportani-primary/20' : '' }} card-premium-recommended">
                    <div class="absolute -top-3.5 left-6 badge-premium text-[9px] font-bold px-3.5 py-1 rounded-full uppercase tracking-wider shadow-sm z-10">
                        Recommended Plan
                    </div>

                    <div class="space-y-6">
                        <div>
                            <span class="text-[9px] font-bold uppercase tracking-wider text-amber-700 font-sans">Premium Member</span>
                            <h3 class="text-xl font-bold text-exportani-text mt-1">{{ $premiumPlan->name }}</h3>
                            
                            <div class="mt-4 flex items-baseline text-exportani-text gap-1">
                                <span class="text-3xl font-black font-sans tracking-tight">
                                    Rp{{ number_format($priceDisplay, 0, ',', '.') }}
                                </span>
                                <span class="text-xs text-exportani-secondaryText font-medium">/ bulan</span>
                            </div>
                        </div>

                        <p class="text-xs text-exportani-secondaryText leading-relaxed">
                            Membuka seluruh batasan platform. Ideal untuk petani tepercaya & eksportir skala nasional yang aktif mencari peluang kemitraan ekspor global.
                        </p>

                        @if($trustedDiscount && !$isPremium)
                            <div class="flex items-center gap-1.5 text-[10px] text-exportani-primary font-bold">
                                <svg class="h-3.5 w-3.5 text-exportani-primary shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Potongan 20% otomatis sebagai Petani Tepercaya.</span>
                            </div>
                        @endif
                    </div>

                    <div class="pt-8 text-center">
                        @if($isPremium)
                            <button disabled class="w-full rounded-xl bg-emerald-600 py-3.5 text-xs font-bold uppercase tracking-wider text-white text-center shadow-sm">
                                Aktif
                            </button>
                        @elseif($pendingSubscription)
                            <a href="{{ route('premium.checkout', $pendingSubscription->plan_id) }}" class="block w-full rounded-xl bg-exportani-primary hover:bg-exportani-dark py-3.5 text-xs font-bold uppercase tracking-wider text-white shadow-sm hover:shadow-md transition duration-200 text-center">
                                Lanjutkan Pembayaran
                            </a>
                        @else
                            <a href="{{ route('premium.checkout', $premiumPlan) }}" class="block w-full rounded-xl bg-exportani-primary hover:bg-exportani-dark py-3.5 text-xs font-bold uppercase tracking-wider text-white shadow-sm hover:shadow-md transition duration-200 text-center">
                                Upgrade ke Premium
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- 4. FEATURE HIGHLIGHTS (2x2 GRID) -->
        <div class="space-y-6 pt-4">
            <div class="text-center">
                <h3 class="font-sans text-[10px] font-bold text-exportani-secondaryText uppercase tracking-widest">
                    Fitur Premium Unggulan
                </h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Card 1 -->
                <div class="bg-white border border-exportani-border rounded-2xl p-6 hover:shadow-md transition duration-350 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-exportani-mint/10 text-exportani-accent rounded-lg border border-exportani-mint/20">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-exportani-text text-sm uppercase tracking-wide">Insight Pasar Ekspor</h4>
                    </div>
                    <p class="text-xs text-exportani-secondaryText leading-relaxed">
                        Pantau tren harga dan peluang komoditas ekspor secara berkala. Dapatkan analisis supply & demand pasar ekspor global.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="bg-white border border-exportani-border rounded-2xl p-6 hover:shadow-md transition duration-350 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-exportani-mint/10 text-exportani-accent rounded-lg border border-exportani-mint/20">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-exportani-text text-sm uppercase tracking-wide">Chat Langsung</h4>
                    </div>
                    <p class="text-xs text-exportani-secondaryText leading-relaxed">
                        Komunikasi lebih cepat dengan petani dan eksportir potensial secara langsung untuk mempercepat negosiasi kontrak kerja sama.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="bg-white border border-exportani-border rounded-2xl p-6 hover:shadow-md transition duration-350 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-exportani-mint/10 text-exportani-accent rounded-lg border border-exportani-mint/20">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-exportani-text text-sm uppercase tracking-wide">Prioritas Pencarian</h4>
                    </div>
                    <p class="text-xs text-exportani-secondaryText leading-relaxed">
                        Produk dan profil premium akan tampil lebih menonjol di halaman hasil pencarian, meningkatkan peluang dihubungi pembeli potensial.
                    </p>
                </div>

                <!-- Card 4 -->
                <div class="bg-white border border-exportani-border rounded-2xl p-6 hover:shadow-md transition duration-350 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-exportani-mint/10 text-exportani-accent rounded-lg border border-exportani-mint/20">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-exportani-text text-sm uppercase tracking-wide">Kemitraan Tanpa Batas</h4>
                    </div>
                    <p class="text-xs text-exportani-secondaryText leading-relaxed">
                        Bangun kolaborasi dan ajukan proposal kerja sama kemitraan ekspor sebanyak-banyaknya tanpa batasan kuota proposal bulanan.
                    </p>
                </div>
            </div>
        </div>

        <!-- 5. COMPACT FEATURE COMPARISON -->
        <div class="space-y-6 pt-4">
            <div class="text-center">
                <h3 class="font-sans text-[10px] font-bold text-exportani-secondaryText uppercase tracking-widest">
                    Perbandingan Fitur Detail
                </h3>
            </div>
            
            <div class="border border-exportani-border bg-white rounded-2xl overflow-hidden shadow-sm">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-[#F8FAFC] border-b border-exportani-border text-[10px] font-bold text-exportani-secondaryText uppercase tracking-wider">
                            <th class="py-4 px-6 font-bold text-exportani-text">Fitur & Layanan</th>
                            <th class="py-4 px-6 font-bold text-exportani-secondaryText text-center w-36">Free Tier</th>
                            <th class="py-4 px-6 font-bold text-exportani-primary text-center w-36 bg-exportani-primary/5">Premium Plan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-exportani-border text-exportani-text">
                        <tr class="hover:bg-exportani-primary/5 transition">
                            <td class="py-4 px-6 font-bold">Kemitraan per Bulan</td>
                            <td class="py-4 px-6 text-center text-exportani-secondaryText">5 proposal</td>
                            <td class="py-4 px-6 text-center font-bold text-exportani-primary bg-exportani-primary/5">Tanpa Batas</td>
                        </tr>
                        <tr class="hover:bg-exportani-primary/5 transition">
                            <td class="py-4 px-6 font-bold">Upload Produk</td>
                            <td class="py-4 px-6 text-center text-exportani-secondaryText">5 produk</td>
                            <td class="py-4 px-6 text-center font-bold text-exportani-primary bg-exportani-primary/5">Tanpa Batas</td>
                        </tr>
                        <tr class="hover:bg-exportani-primary/5 transition">
                            <td class="py-4 px-6 font-bold">Chat Langsung</td>
                            <td class="py-4 px-6 text-center text-exportani-secondaryText/40">
                                <span class="text-exportani-secondaryText/40 font-bold text-sm select-none">—</span>
                            </td>
                            <td class="py-4 px-6 text-center bg-exportani-primary/5">
                                <svg class="h-4 w-4 mx-auto text-exportani-primary font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </td>
                        </tr>
                        <tr class="hover:bg-exportani-primary/5 transition">
                            <td class="py-4 px-6 font-bold">Prioritas Pencarian</td>
                            <td class="py-4 px-6 text-center text-exportani-secondaryText/40">
                                <span class="text-exportani-secondaryText/40 font-bold text-sm select-none">—</span>
                            </td>
                            <td class="py-4 px-6 text-center bg-exportani-primary/5">
                                <svg class="h-4 w-4 mx-auto text-exportani-primary font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </td>
                        </tr>
                        <tr class="hover:bg-exportani-primary/5 transition">
                            <td class="py-4 px-6 font-bold">Badge Terverifikasi</td>
                            <td class="py-4 px-6 text-center text-exportani-secondaryText/40">
                                <span class="text-exportani-secondaryText/40 font-bold text-sm select-none">—</span>
                            </td>
                            <td class="py-4 px-6 text-center bg-exportani-primary/5">
                                <svg class="h-4 w-4 mx-auto text-exportani-primary font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </td>
                        </tr>
                        <tr class="hover:bg-exportani-primary/5 transition">
                            <td class="py-4 px-6 font-bold">Insight Pasar Ekspor</td>
                            <td class="py-4 px-6 text-center text-exportani-secondaryText/40">
                                <span class="text-exportani-secondaryText/40 font-bold text-sm select-none">—</span>
                            </td>
                            <td class="py-4 px-6 text-center bg-exportani-primary/5">
                                <svg class="h-4 w-4 mx-auto text-exportani-primary font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </td>
                        </tr>
                        <tr class="hover:bg-exportani-primary/5 transition">
                            <td class="py-4 px-6 font-bold">Analisis Tren Komoditas</td>
                            <td class="py-4 px-6 text-center text-exportani-secondaryText/40">
                                <span class="text-exportani-secondaryText/40 font-bold text-sm select-none">—</span>
                            </td>
                            <td class="py-4 px-6 text-center bg-exportani-primary/5">
                                <svg class="h-4 w-4 mx-auto text-exportani-primary font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </td>
                        </tr>
                        <tr class="hover:bg-exportani-primary/5 transition">
                            <td class="py-4 px-6 font-bold">Dukungan Prioritas</td>
                            <td class="py-4 px-6 text-center text-exportani-secondaryText/40">
                                <span class="text-exportani-secondaryText/40 font-bold text-sm select-none">—</span>
                            </td>
                            <td class="py-4 px-6 text-center bg-exportani-primary/5">
                                <svg class="h-4 w-4 mx-auto text-exportani-primary font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
