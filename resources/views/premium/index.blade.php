<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-display text-lg font-bold text-stone-900 dark:text-white tracking-tight">Exportani Premium</h2>
                <p class="mt-0.5 text-xs text-stone-500 dark:text-stone-400">Kelola keanggotaan premium Anda untuk akses pasar global.</p>
            </div>
            <div class="shrink-0">
                <a href="{{ route('subscription.history') }}" class="inline-flex items-center gap-1.5 rounded-lg border border-stone-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3 py-1.5 text-xs font-semibold text-stone-600 dark:text-gray-300 hover:bg-stone-50 dark:hover:bg-gray-750 hover:text-emerald-700 dark:hover:text-emerald-400 transition duration-155 shadow-sm">
                    <svg class="h-3.5 w-3.5 text-stone-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Riwayat Langganan
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Main Container: max-w-4xl with space-y-12 for consistent enterprise visual rhythm -->
    <div class="py-12 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto space-y-8">
        
        <!-- Notification Alerts -->
        @if(session('success'))
            <div class="rounded-xl border border-emerald-150 bg-emerald-50/60 p-4 text-xs text-emerald-900 shadow-sm flex items-start gap-2.5">
                <svg class="h-4 w-4 text-emerald-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <span class="font-bold">Berhasil:</span> {{ session('success') }}
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="rounded-xl border border-rose-150 bg-rose-50/60 p-4 text-xs text-rose-900 shadow-sm flex items-start gap-2.5">
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

        <!-- 1. HERO PREMIUM (MATCHES THE NEW PROFILE CARD STYLE) -->
        <div class="relative overflow-hidden bg-white dark:bg-gray-800 shadow-sm border border-emerald-100/50 dark:border-gray-700/50 rounded-2xl py-8 px-8 transition duration-300">
            <!-- Top Gradient Bar -->
            <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-emerald-500 via-teal-500 to-emerald-600"></div>

            <div class="relative z-10 space-y-6">
                <div class="space-y-1.5 text-center sm:text-left">
                    <span class="inline-flex items-center rounded-full bg-emerald-100 dark:bg-emerald-950/45 text-emerald-800 dark:text-emerald-300 border border-emerald-500/15 px-2.5 py-0.5 text-[9px] font-bold uppercase tracking-wider">
                        Premium Membership
                    </span>
                    <h1 class="text-xl md:text-2xl font-black text-gray-900 dark:text-white leading-tight font-display mt-2">
                        Exportani Premium
                    </h1>
                    <p class="text-gray-500 dark:text-gray-400 text-xs font-medium leading-relaxed max-w-lg mx-auto sm:mx-0">
                        Akses fitur premium untuk memperluas peluang kemitraan ekspor global Anda.
                    </p>
                </div>

                <!-- Integrated Compact Membership Status -->
                @if($isPremium && $activeSubscription)
                    <!-- Active Status Box -->
                    <div class="rounded-xl border border-emerald-500/20 bg-emerald-500/10 px-6 py-4.5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="space-y-0.5">
                            <div class="flex items-center gap-1.5 justify-center sm:justify-start">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                <span class="text-[9px] font-bold text-emerald-600 dark:text-emerald-300 uppercase tracking-wider">Premium Aktif</span>
                            </div>
                            <p class="text-xs text-emerald-900 dark:text-emerald-200 text-center sm:text-left">
                                Paket <strong class="text-emerald-950 dark:text-white">{{ $activeSubscription->plan->name }}</strong> s/d <strong class="text-emerald-950 dark:text-white">{{ $activeSubscription->end_date->format('d M Y') }}</strong>.
                            </p>
                        </div>
                        <div class="shrink-0 flex justify-center">
                            <a href="{{ route('premium.insight') }}" class="inline-flex items-center justify-center rounded-lg bg-emerald-600 hover:bg-emerald-700 px-4 py-2 text-xs font-semibold text-white shadow-sm transition duration-150">
                                Buka Analisis Pasar
                            </a>
                        </div>
                    </div>
                @elseif($pendingSubscription)
                    <!-- Pending Payment Box -->
                    <div class="rounded-xl border border-amber-200 dark:border-amber-900/40 bg-amber-50/50 dark:bg-amber-950/20 px-6 py-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm">
                        <div class="space-y-1 text-center sm:text-left w-full sm:w-auto">
                            <div class="flex items-center gap-1.5 justify-center sm:justify-start">
                                <svg class="h-4 w-4 text-amber-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-[9px] font-bold text-amber-700 dark:text-amber-300 uppercase tracking-wider">Pembayaran Pending</span>
                            </div>
                            <p class="text-xs text-amber-800 dark:text-amber-400 mt-1">
                                Selesaikan pembayaran untuk mengaktifkan fitur premium.
                            </p>
                            <div class="flex justify-center sm:justify-start mt-2">
                                <div class="inline-flex items-center gap-2.5 rounded-lg bg-white dark:bg-gray-800 px-4 py-2 border border-amber-200/60 dark:border-amber-900/30">
                                    <span class="text-gray-500 dark:text-gray-400 text-xs font-medium">Tagihan:</span>
                                    <strong class="text-amber-600 dark:text-amber-400 text-sm font-black">Rp{{ number_format($pendingSubscription->gross_amount, 0, ',', '.') }}</strong>
                                </div>
                            </div>
                            <p class="text-[9px] text-gray-400 dark:text-gray-500 font-mono mt-1.5">ID Transaksi: {{ $pendingSubscription->transaction_id }}</p>
                        </div>
                        <div class="shrink-0 flex items-center justify-center gap-4 w-full sm:w-auto">
                            <a href="{{ route('premium.checkout', $pendingSubscription->plan_id) }}" class="inline-flex items-center justify-center rounded-lg bg-emerald-600 hover:bg-emerald-700 px-5 py-2.5 text-xs font-bold text-white shadow-md hover:shadow-lg transition duration-200">
                                Lanjutkan Pembayaran
                            </a>
                            <a href="{{ route('subscription.history') }}" class="text-xs font-bold text-amber-600 dark:text-amber-400 hover:text-amber-800 dark:hover:text-amber-300 underline transition duration-150">
                                Riwayat
                            </a>
                        </div>
                    </div>
                @elseif($user->premium_expires_at && $user->premium_expires_at->isPast())
                    <!-- Expired Status Box -->
                    <div class="rounded-xl border border-rose-200 dark:border-rose-900/40 bg-rose-50/50 dark:bg-rose-950/20 px-6 py-4.5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="space-y-0.5 text-center sm:text-left">
                            <div class="flex items-center gap-1.5 justify-center sm:justify-start">
                                <span class="h-1.5 w-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                                <span class="text-[9px] font-bold text-rose-700 dark:text-rose-300 uppercase tracking-wider">Premium Kedaluwarsa</span>
                            </div>
                            <p class="text-xs text-rose-800 dark:text-rose-400">
                                Masa aktif berakhir pada {{ $user->premium_expires_at->format('d M Y') }}.
                            </p>
                        </div>
                        <div class="shrink-0 flex justify-center">
                            <a href="#premium-plan-card" class="inline-flex items-center justify-center rounded-lg bg-emerald-600 hover:bg-emerald-700 px-3.5 py-1.5 text-xs font-semibold text-white shadow-sm transition duration-150">
                                Perpanjang Langganan
                            </a>
                        </div>
                    </div>
                @else
                    <!-- Free Status Box -->
                    <div class="rounded-xl border border-stone-200 dark:border-gray-700 bg-stone-50 dark:bg-gray-800/60 px-6 py-4.5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="space-y-0.5 text-center sm:text-left">
                            <span class="inline-flex items-center rounded-full bg-stone-200 dark:bg-slate-700 text-stone-700 dark:text-slate-300 px-2 py-0.5 text-[9px] font-semibold">
                                Akun Free
                            </span>
                            <p class="text-xs text-stone-600 dark:text-stone-400">
                                Anda menggunakan Free Plan dengan fitur kemitraan terbatas.
                            </p>
                        </div>
                        <div class="shrink-0 flex justify-center">
                            <a href="#premium-plan-card" class="inline-flex items-center justify-center rounded-lg bg-emerald-600 hover:bg-emerald-700 px-3.5 py-1.5 text-xs font-semibold text-white shadow-sm transition duration-150">
                                Upgrade Ke Premium
                            </a>
                        </div>
                    </div>
                @endif

                @if($trustedDiscount && !$isPremium)
                    <div class="flex items-center justify-center sm:justify-start gap-1.5 text-[9px] text-emerald-600 dark:text-emerald-400 pt-0.5">
                        <svg class="h-3.5 w-3.5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Loyalty Discount: Diskon 20% khusus Petani Tepercaya akan diterapkan otomatis saat checkout.</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- 2. PLAN CARDS SECTION (SIDE-BY-SIDE HORIZONTAL GRID) -->
        <div id="premium-plan-card" class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <!-- Free Tier Card -->
            <div class="rounded-2xl border border-stone-200 dark:border-gray-700/60 bg-white dark:bg-gray-800 p-8 shadow-sm flex flex-col justify-between transition duration-300 relative {{ !$isPremium ? 'ring-2 ring-stone-100 dark:ring-slate-700/30' : '' }}">
                <div class="space-y-6">
                    <div>
                        <span class="text-[9px] font-bold uppercase tracking-wider text-stone-400 dark:text-stone-505 font-sans">Free Plan</span>
                        <h3 class="text-xl font-bold text-stone-900 dark:text-white mt-1">Free Tier</h3>
                        
                        <div class="mt-4 flex items-baseline text-stone-900 dark:text-white gap-1">
                            <span class="text-3xl font-black font-sans tracking-tight">Rp0</span>
                            <span class="text-xs text-stone-400 dark:text-stone-500">/ selamanya</span>
                        </div>
                    </div>

                    <!-- Benefit List -->
                    <ul class="space-y-4 text-xs leading-loose border-t border-stone-100 dark:border-gray-700 pt-6">
                        <li class="flex items-center gap-3">
                            <svg class="h-4 w-4 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-stone-700 dark:text-gray-250 font-bold">Batas Kemitraan: 5/bulan</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="h-4 w-4 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-stone-700 dark:text-gray-250 font-bold">Batas Unggah: 5 produk</span>
                        </li>
                        <li class="flex items-center gap-3 opacity-40">
                            <svg class="h-4 w-4 text-stone-400 dark:text-gray-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <span class="text-stone-400 dark:text-stone-500 font-bold">Tanpa Prioritas Pencarian</span>
                        </li>
                        <li class="flex items-center gap-3 opacity-40">
                            <svg class="h-4 w-4 text-stone-400 dark:text-gray-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <span class="text-stone-400 dark:text-stone-505 font-bold">Tanpa Lencana Premium</span>
                        </li>
                        <li class="flex items-center gap-3 opacity-40">
                            <svg class="h-4 w-4 text-stone-400 dark:text-gray-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <span class="text-stone-400 dark:text-stone-505 font-bold">Tanpa Akses Chat Petani</span>
                        </li>
                    </ul>
                </div>

                <div class="pt-8 text-center">
                    @if(!$isPremium)
                        <button disabled class="w-full rounded-xl bg-stone-100 dark:bg-gray-700 py-3.5 text-xs font-bold uppercase tracking-wider text-stone-400 dark:text-gray-500 text-center cursor-not-allowed border border-stone-200 dark:border-gray-600">
                            Paket Aktif Anda
                        </button>
                    @else
                        <button disabled class="w-full rounded-xl bg-stone-50 dark:bg-gray-800/40 py-3.5 text-xs font-bold uppercase tracking-wider text-stone-300 dark:text-gray-600 text-center cursor-not-allowed border border-stone-150 dark:border-gray-750">
                            Basic Tier
                        </button>
                    @endif
                </div>
            </div>

            <!-- Premium Plan Card -->
            @if($premiumPlan)
                <div class="rounded-2xl border-2 border-emerald-500 dark:border-emerald-500/80 bg-white dark:bg-gray-800 p-8 shadow-[0_10px_30px_-5px_rgba(16,185,129,0.15)] flex flex-col justify-between transition duration-300 relative {{ $isPremium ? 'ring-2 ring-emerald-500/20' : '' }}">
                    <div class="absolute -top-3.5 left-6 bg-emerald-600 text-white text-[9px] font-extrabold px-3.5 py-1 rounded-full uppercase tracking-wider shadow-sm border border-emerald-500 z-10">
                        Recommended Plan
                    </div>

                    <div class="space-y-6">
                        <div>
                            <span class="text-[9px] font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400 font-sans">Premium Upgrade</span>
                            <h3 class="text-xl font-bold text-stone-900 dark:text-white mt-1">{{ $premiumPlan->name }}</h3>
                            
                            <div class="mt-4 flex items-baseline text-stone-900 dark:text-white gap-1">
                                <span class="text-3xl font-black font-sans tracking-tight">
                                    Rp{{ number_format($priceDisplay, 0, ',', '.') }}
                                </span>
                                <span class="text-xs text-stone-400 dark:text-stone-500">/ 30 hari</span>
                            </div>
                        </div>

                        <!-- Benefit List -->
                        <ul class="space-y-4 text-xs leading-loose border-t border-stone-100 dark:border-gray-700 pt-6">
                            <li class="flex items-center gap-3">
                                <svg class="h-4 w-4 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-stone-700 dark:text-gray-200 font-bold">Kemitraan Tanpa Batas</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="h-4 w-4 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-stone-700 dark:text-gray-200 font-bold font-sans">Unggah Produk Tanpa Batas</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="h-4 w-4 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-stone-700 dark:text-gray-200 font-bold">Prioritas Hasil Pencarian</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="h-4 w-4 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-stone-700 dark:text-gray-200 font-bold">Badge Premium Terverifikasi</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="h-4 w-4 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-stone-700 dark:text-gray-200 font-bold">Akses Chat Petani Langsung</span>
                            </li>
                        </ul>
                    </div>

                    <div class="pt-8 text-center">
                        @if($isPremium)
                            <button disabled class="w-full rounded-xl bg-stone-100 dark:bg-gray-750 py-3.5 text-xs font-bold uppercase tracking-wider text-stone-400 dark:text-gray-500 text-center cursor-not-allowed border border-stone-200 dark:border-gray-700">
                                Premium Aktif
                            </button>
                        @elseif($pendingSubscription)
                            <a href="{{ route('premium.checkout', $pendingSubscription->plan_id) }}" class="block w-full rounded-xl bg-emerald-600 hover:bg-emerald-700 py-3.5 text-xs font-bold uppercase tracking-wider text-white shadow-sm hover:shadow-md transition duration-200 text-center">
                                Lanjutkan Pembayaran
                            </a>
                        @else
                            <a href="{{ route('premium.checkout', $premiumPlan) }}" class="block w-full rounded-xl bg-emerald-600 hover:bg-emerald-700 py-3.5 text-xs font-bold uppercase tracking-wider text-white shadow-sm hover:shadow-md transition duration-200 text-center">
                                Upgrade ke Premium
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- 3. COMPACT FEATURE COMPARISON (Table Comparison - max-w-3xl) -->
        <div class="space-y-6 pt-4">
            <div class="text-center">
                <h3 class="font-sans text-[10px] font-bold text-stone-400 dark:text-stone-505 uppercase tracking-widest">
                    Perbandingan Fitur Paket
                </h3>
            </div>
            
            <div class="max-w-3xl mx-auto border border-stone-200 dark:border-gray-700/50 bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-sm">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-stone-50 dark:bg-gray-900/50 border-b border-stone-200 dark:border-gray-700/50 text-[10px] font-bold text-stone-500 dark:text-gray-400 uppercase tracking-wider">
                            <th class="py-4 px-6 font-bold text-stone-700 dark:text-gray-200">Fitur & Layanan</th>
                            <th class="py-4 px-6 font-bold text-stone-500 dark:text-gray-400 text-center w-36">Free Tier</th>
                            <th class="py-4 px-6 font-bold text-emerald-800 dark:text-emerald-300 text-center w-36 bg-emerald-500/5 dark:bg-emerald-950/10">Premium Plan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-200 dark:divide-gray-700/50 text-stone-600 dark:text-gray-300">
                        <tr class="hover:bg-stone-50/50 dark:hover:bg-gray-700/30 transition">
                            <td class="py-4 px-6 font-bold text-stone-850 dark:text-gray-100">Batas Pengajuan Kemitraan</td>
                            <td class="py-4 px-6 text-center text-stone-400 dark:text-gray-500">5 / bulan</td>
                            <td class="py-4 px-6 text-center font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-500/5 dark:bg-emerald-950/10">Tanpa Batas</td>
                        </tr>
                        <tr class="hover:bg-stone-50/50 dark:hover:bg-gray-700/30 transition">
                            <td class="py-4 px-6 font-bold text-stone-850 dark:text-gray-100">Batas Unggah Produk</td>
                            <td class="py-4 px-6 text-center text-stone-400 dark:text-gray-500">5 produk</td>
                            <td class="py-4 px-6 text-center font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-500/5 dark:bg-emerald-950/10">Tanpa Batas</td>
                        </tr>
                        <tr class="hover:bg-stone-50/50 dark:hover:bg-gray-700/30 transition">
                            <td class="py-4 px-6 font-bold text-stone-850 dark:text-gray-100">Akses Chat Petani (Eksklusif)</td>
                            <td class="py-4 px-6 text-center text-stone-300 dark:text-gray-650">
                                <svg class="h-4 w-4 mx-auto text-stone-400 dark:text-gray-650" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                </svg>
                            </td>
                            <td class="py-4 px-6 text-center bg-emerald-500/5 dark:bg-emerald-950/10">
                                <svg class="h-4 w-4 mx-auto text-emerald-600 dark:text-emerald-400 font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </td>
                        </tr>
                        <tr class="hover:bg-stone-50/50 dark:hover:bg-gray-700/30 transition">
                            <td class="py-4 px-6 font-bold text-stone-850 dark:text-gray-100">Prioritas Hasil Pencarian</td>
                            <td class="py-4 px-6 text-center text-stone-300 dark:text-gray-650">
                                <svg class="h-4 w-4 mx-auto text-stone-400 dark:text-gray-650" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                </svg>
                            </td>
                            <td class="py-4 px-6 text-center bg-emerald-500/5 dark:bg-emerald-950/10">
                                <svg class="h-4 w-4 mx-auto text-emerald-600 dark:text-emerald-400 font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </td>
                        </tr>
                        <tr class="hover:bg-stone-50/50 dark:hover:bg-gray-700/30 transition">
                            <td class="py-4 px-6 font-bold text-stone-850 dark:text-gray-100">Badge Premium Terverifikasi</td>
                            <td class="py-4 px-6 text-center text-stone-300 dark:text-gray-650">
                                <svg class="h-4 w-4 mx-auto text-stone-400 dark:text-gray-650" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                </svg>
                            </td>
                            <td class="py-4 px-6 text-center bg-emerald-500/5 dark:bg-emerald-950/10">
                                <svg class="h-4 w-4 mx-auto text-emerald-600 dark:text-emerald-400 font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </td>
                        </tr>
                        <tr class="hover:bg-stone-50/50 dark:hover:bg-gray-700/30 transition">
                            <td class="py-4 px-6 font-bold text-stone-850 dark:text-gray-100">Analisis Pasar Komoditas</td>
                            <td class="py-4 px-6 text-center text-stone-300 dark:text-gray-650">
                                <svg class="h-4 w-4 mx-auto text-stone-400 dark:text-gray-650" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                </svg>
                            </td>
                            <td class="py-4 px-6 text-center bg-emerald-500/5 dark:bg-emerald-950/10">
                                <svg class="h-4 w-4 mx-auto text-emerald-600 dark:text-emerald-400 font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
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
