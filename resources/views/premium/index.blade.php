<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-display text-lg font-bold text-stone-900 tracking-tight">Exportani Premium</h2>
                <p class="mt-0.5 text-xs text-stone-500">Kelola keanggotaan premium Anda untuk akses pasar global.</p>
            </div>
            <div class="shrink-0">
                <a href="{{ route('subscription.history') }}" class="inline-flex items-center gap-1.5 rounded-lg border border-stone-200 bg-white px-3 py-1.5 text-xs font-semibold text-stone-600 hover:bg-stone-50 hover:text-emerald-700 transition duration-155 shadow-sm">
                    <svg class="h-3.5 w-3.5 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Riwayat Langganan
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Main Container: max-w-4xl with space-y-12 for consistent enterprise visual rhythm -->
    <div class="py-12 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto space-y-12">
        
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

        <!-- 1. HERO PREMIUM (STANDOUT & SOLID DEEP STONE DARK) -->
        <div class="relative overflow-hidden rounded-2xl bg-stone-900 text-white py-8 px-8 shadow-sm border border-stone-800 transition duration-300">
            <div class="relative z-10 space-y-6">
                <div class="space-y-1.5">
                    <span class="inline-flex items-center rounded-full bg-emerald-500/10 text-emerald-300 border border-emerald-500/20 px-2.5 py-0.5 text-[9px] font-bold uppercase tracking-wider">
                        Premium Membership
                    </span>
                    <h1 class="text-xl md:text-2xl font-black text-white leading-tight">
                        Exportani Premium
                    </h1>
                    <p class="text-stone-400 text-xs font-medium leading-relaxed max-w-lg">
                        Akses fitur premium untuk memperluas peluang kemitraan ekspor global Anda.
                    </p>
                </div>

                <!-- Integrated Compact Membership Status -->
                @if($isPremium && $activeSubscription)
                    <!-- Active Status Box -->
                    <div class="rounded-xl border border-emerald-500/20 bg-emerald-500/10 px-6 py-4.5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="space-y-0.5">
                            <div class="flex items-center gap-1.5">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                                <span class="text-[9px] font-bold text-emerald-300 uppercase tracking-wider">Premium Aktif</span>
                            </div>
                            <p class="text-xs text-emerald-100/90">
                                Paket <strong class="text-white">{{ $activeSubscription->plan->name }}</strong> s/d <strong class="text-white">{{ $activeSubscription->end_date->format('d M Y') }}</strong>.
                            </p>
                        </div>
                        <div class="shrink-0">
                            <a href="{{ route('premium.insight') }}" class="inline-flex items-center justify-center rounded-lg bg-emerald-600 hover:bg-emerald-700 px-4 py-2 text-xs font-semibold text-white shadow-sm transition duration-150">
                                Buka Analisis Pasar
                            </a>
                        </div>
                    </div>
                @elseif($pendingSubscription)
                    <!-- Pending Payment Box -->
                    <div class="rounded-xl border border-amber-500/20 bg-stone-800/80 px-6 py-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm">
                        <div class="space-y-1">
                            <div class="flex items-center gap-1.5">
                                <svg class="h-4 w-4 text-amber-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-[9px] font-bold text-amber-400 uppercase tracking-wider">Pembayaran Pending</span>
                            </div>
                            <p class="text-xs text-stone-300">
                                Selesaikan pembayaran untuk mengaktifkan fitur premium.
                            </p>
                            <div class="inline-flex items-center gap-2.5 rounded-lg bg-stone-900/80 px-4 py-2 border border-stone-700 mt-2">
                                <span class="text-stone-400 text-xs font-medium">Tagihan:</span>
                                <strong class="text-amber-400 text-sm font-bold">Rp{{ number_format($pendingSubscription->gross_amount, 0, ',', '.') }}</strong>
                            </div>
                            <p class="text-[9px] text-stone-500 font-mono mt-1">ID Transaksi: {{ $pendingSubscription->transaction_id }}</p>
                        </div>
                        <div class="shrink-0 flex items-center gap-4">
                            <a href="{{ route('premium.checkout', $pendingSubscription->plan_id) }}" class="inline-flex items-center justify-center rounded-lg bg-emerald-600 hover:bg-emerald-700 px-5 py-2.5 text-xs font-bold text-white shadow-md hover:shadow-lg transition duration-200">
                                Lanjutkan Pembayaran
                            </a>
                            <a href="{{ route('subscription.history') }}" class="text-xs font-bold text-amber-400 hover:text-amber-300 underline transition duration-150">
                                Riwayat
                            </a>
                        </div>
                    </div>
                @elseif($user->premium_expires_at && $user->premium_expires_at->isPast())
                    <!-- Expired Status Box -->
                    <div class="rounded-xl border border-rose-500/20 bg-rose-500/5 px-6 py-4.5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="space-y-0.5">
                            <div class="flex items-center gap-1.5">
                                <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>
                                <span class="text-[9px] font-bold text-rose-400 uppercase tracking-wider">Premium Kedaluwarsa</span>
                            </div>
                            <p class="text-xs text-stone-300">
                                Masa aktif berakhir pada {{ $user->premium_expires_at->format('d M Y') }}.
                            </p>
                        </div>
                        <div class="shrink-0">
                            <a href="#premium-plan-card" class="inline-flex items-center justify-center rounded-lg bg-emerald-600 hover:bg-emerald-700 px-3.5 py-1.5 text-xs font-semibold text-white shadow-sm transition duration-150">
                                Perpanjang Langganan
                            </a>
                        </div>
                    </div>
                @else
                    <!-- Free Status Box -->
                    <div class="rounded-xl border border-stone-800 bg-stone-800/40 px-6 py-4.5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="space-y-0.5">
                            <span class="inline-flex items-center rounded-full bg-stone-800 text-stone-400 px-2 py-0.5 text-[9px] font-semibold">
                                Akun Free
                            </span>
                            <p class="text-xs text-stone-300">
                                Anda menggunakan Free Plan dengan fitur kemitraan terbatas.
                            </p>
                        </div>
                        <div class="shrink-0">
                            <a href="#premium-plan-card" class="inline-flex items-center justify-center rounded-lg bg-emerald-600 hover:bg-emerald-700 px-3.5 py-1.5 text-xs font-semibold text-white shadow-sm transition duration-150">
                                Upgrade Ke Premium
                            </a>
                        </div>
                    </div>
                @endif

                @if($trustedDiscount && !$isPremium)
                    <div class="flex items-center gap-1.5 text-[9px] text-emerald-400 pt-0.5">
                        <svg class="h-3.5 w-3.5 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Loyalty Discount: Diskon 20% khusus Petani Tepercaya akan diterapkan otomatis saat checkout.</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- 2. PREMIUM PLAN CARD (SINGLE FOCUS PRICE CATALOG - Centered & Subtle Emerald Glow Border) -->
        @if($premiumPlan)
            <div id="premium-plan-card" class="max-w-2xl mx-auto space-y-4">
                <div class="rounded-2xl border border-emerald-500/20 bg-white p-8 shadow-[0_4px_20px_-4px_rgba(16,185,129,0.08)] hover:shadow-[0_10px_30px_-5px_rgba(16,185,129,0.12)] hover:-translate-y-0.5 transition duration-300 relative flex flex-col gap-6">
                    <div class="absolute -top-3 left-6 bg-emerald-600 text-white text-[9px] font-extrabold px-3.5 py-1 rounded-full uppercase tracking-wider shadow-sm border border-emerald-500 z-10">
                        Recommended Plan
                    </div>

                    <div class="space-y-4 pt-3">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
                            <div>
                                <span class="text-[9px] font-bold uppercase tracking-wider text-emerald-600 font-sans">Premium Upgrade</span>
                                <h3 class="text-xl font-bold text-stone-900 mt-1">{{ $premiumPlan->name }}</h3>
                            </div>
                            <div class="text-left sm:text-right">
                                <div class="flex items-baseline text-stone-900 sm:justify-end gap-1">
                                    <span class="text-3xl font-extrabold tracking-tight">
                                        Rp{{ number_format($priceDisplay, 0, ',', '.') }}
                                    </span>
                                    <span class="text-xs text-stone-400">/ 30 hari</span>
                                </div>
                                @if($hasDiscount)
                                    <span class="inline-block mt-1 text-[8px] bg-amber-50 text-amber-900 border border-amber-200/50 px-1.5 py-0.5 rounded font-bold">
                                        Diskon 20% Terpasang
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Benefit List -->
                        <ul class="grid sm:grid-cols-2 gap-x-8 gap-y-4 text-xs text-stone-600 leading-loose border-t border-stone-100 pt-6">
                            @foreach($premiumPlan->features as $feat)
                                <li class="flex items-center gap-3">
                                    <svg class="h-4 w-4 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-stone-700 font-medium">{{ ucwords($feat) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Single Focused Emerald CTA Button -->
                    <div class="pt-2 text-center">
                        @if($isPremium)
                            <button disabled class="w-full max-w-xs mx-auto rounded-xl bg-stone-100 py-4 text-xs font-bold uppercase tracking-wider text-stone-400 text-center cursor-not-allowed border border-stone-200">
                                Keanggotaan Premium Aktif
                            </button>
                        @elseif($pendingSubscription)
                            <a href="{{ route('premium.checkout', $pendingSubscription->plan_id) }}" class="block w-full max-w-xs mx-auto rounded-xl bg-emerald-600 hover:bg-emerald-700 py-4 text-xs font-bold uppercase tracking-wider text-white shadow-sm hover:shadow-md transition duration-200">
                                Lanjutkan Pembayaran
                            </a>
                        @else
                            <a href="{{ route('premium.checkout', $premiumPlan) }}" class="block w-full max-w-xs mx-auto rounded-xl bg-emerald-600 hover:bg-emerald-700 py-4 text-xs font-bold uppercase tracking-wider text-white shadow-sm hover:shadow-md transition duration-200">
                                Upgrade ke Premium
                            </a>
                        @endif
                    </div>
                </div>

                @if(!$isPremium && !$pendingSubscription)
                    <p class="text-[9px] text-center text-stone-400 leading-relaxed">
                        Saat ini Anda menggunakan Free Plan dengan fitur terbatas.
                    </p>
                @endif
            </div>
        @endif

        <!-- 3. COMPACT FEATURE COMPARISON (Table Comparison - max-w-3xl) -->
        <div class="space-y-6 pt-4">
            <div class="text-center">
                <h3 class="font-sans text-[10px] font-semibold text-stone-400 uppercase tracking-wide">
                    Perbandingan Fitur Paket
                </h3>
            </div>
            
            <div class="max-w-3xl mx-auto border border-stone-200 bg-white rounded-xl overflow-hidden shadow-sm">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-stone-50 border-b border-stone-200 text-[10px] font-bold text-stone-500 uppercase tracking-wider">
                            <th class="py-3.5 px-6 font-bold text-stone-700">Fitur & Layanan</th>
                            <th class="py-3.5 px-6 font-bold text-stone-500 text-center w-36">Free Tier</th>
                            <th class="py-3.5 px-6 font-bold text-emerald-800 text-center w-36 bg-emerald-500/5">Premium Plan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-200 text-stone-600">
                        <tr class="hover:bg-stone-50/50 transition">
                            <td class="py-3.5 px-6 font-medium text-stone-800">Batas Pengajuan Kemitraan</td>
                            <td class="py-3.5 px-6 text-center text-stone-400">5 / bulan</td>
                            <td class="py-3.5 px-6 text-center font-bold text-emerald-700 bg-emerald-500/5">Tanpa Batas</td>
                        </tr>
                        <tr class="hover:bg-stone-50/50 transition">
                            <td class="py-3.5 px-6 font-medium text-stone-800">Batas Unggah Produk</td>
                            <td class="py-3.5 px-6 text-center text-stone-400">5 produk</td>
                            <td class="py-3.5 px-6 text-center font-bold text-emerald-700 bg-emerald-500/5">Tanpa Batas</td>
                        </tr>
                        <tr class="hover:bg-stone-50/50 transition">
                            <td class="py-3.5 px-6 font-medium text-stone-800">Prioritas Hasil Pencarian</td>
                            <td class="py-3.5 px-6 text-center text-stone-300">
                                <svg class="h-4 w-4 mx-auto text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                </svg>
                            </td>
                            <td class="py-3.5 px-6 text-center bg-emerald-500/5">
                                <svg class="h-4 w-4 mx-auto text-emerald-600 font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </td>
                        </tr>
                        <tr class="hover:bg-stone-50/50 transition">
                            <td class="py-3.5 px-6 font-medium text-stone-800">Badge Premium Terverifikasi</td>
                            <td class="py-3.5 px-6 text-center text-stone-300">
                                <svg class="h-4 w-4 mx-auto text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                </svg>
                            </td>
                            <td class="py-3.5 px-6 text-center bg-emerald-500/5">
                                <svg class="h-4 w-4 mx-auto text-emerald-600 font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </td>
                        </tr>
                        <tr class="hover:bg-stone-50/50 transition">
                            <td class="py-3.5 px-6 font-medium text-stone-800">Analisis Pasar Komoditas</td>
                            <td class="py-3.5 px-6 text-center text-stone-300">
                                <svg class="h-4 w-4 mx-auto text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                </svg>
                            </td>
                            <td class="py-3.5 px-6 text-center bg-emerald-500/5">
                                <svg class="h-4 w-4 mx-auto text-emerald-600 font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
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
