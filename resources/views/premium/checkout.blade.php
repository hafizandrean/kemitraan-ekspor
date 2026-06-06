<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('premium.index') }}" class="flex h-9 w-9 items-center justify-center rounded-lg border border-exportani-border bg-white text-exportani-secondaryText hover:bg-exportani-background hover:text-exportani-primary transition shadow-sm">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="font-display text-lg font-bold text-exportani-text tracking-tight">Checkout Premium</h2>
                <p class="mt-0.5 text-xs text-exportani-secondaryText">Upgrade keanggotaan otomatis via Payment Gateway Midtrans.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
        <div class="grid md:grid-cols-3 gap-8 items-start">
            
            <!-- Detail Plan (Kolom Kiri) -->
            <div class="md:col-span-1 space-y-6">
                <div class="rounded-2xl border border-exportani-border bg-white p-5 shadow-sm space-y-5">
                    <div>
                        <span class="inline-flex items-center rounded-full bg-exportani-mint/15 text-exportani-accent border border-exportani-mint/20 px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider">
                            Upgrade Keanggotaan
                        </span>
                        <h3 class="text-base font-bold text-exportani-text mt-2">{{ $plan->name }}</h3>
                        <p class="text-xs text-exportani-secondaryText mt-0.5">Masa aktif: {{ $plan->duration_days }} hari</p>
                    </div>
                    
                    <div class="border-t border-exportani-border pt-4 space-y-1">
                        <p class="text-[10px] uppercase font-bold text-exportani-secondaryText tracking-wider">ID Transaksi</p>
                        <p class="text-xs font-mono font-bold text-exportani-text">{{ $subscription->transaction_id }}</p>
                    </div>

                    <div class="border-t border-exportani-border pt-4 space-y-1">
                        <p class="text-[10px] uppercase font-bold text-exportani-secondaryText tracking-wider">Total Pembayaran</p>
                        <p class="text-xl font-black text-exportani-text">Rp{{ number_format($price, 0, ',', '.') }}</p>
                        @if($hasDiscount)
                            <span class="inline-flex items-center rounded-full bg-amber-50 text-amber-800 border border-amber-200/50 px-2 py-0.5 text-[8px] font-semibold mt-1">
                                Diskon Petani Tepercaya Aktif
                            </span>
                        @endif
                    </div>

                    <div class="border-t border-exportani-border pt-4 space-y-3">
                        <h4 class="text-[10px] uppercase font-bold text-exportani-text tracking-wider">Keunggulan Terbuka:</h4>
                        <ul class="space-y-2 text-xs text-exportani-secondaryText">
                            @foreach($plan->features as $feat)
                                <li class="flex items-start gap-2">
                                    <svg class="h-4 w-4 text-exportani-primary shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-exportani-text font-medium">{{ ucwords($feat) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Payment Gateway Simulator (Kolom Kanan) -->
            <div class="md:col-span-2 space-y-6">
                <!-- Midtrans Snap Simulation Frame -->
                <div class="rounded-2xl border border-exportani-border bg-white p-6 shadow-sm relative overflow-hidden" x-data="{ method: 'qris' }">
                    <div class="absolute right-0 top-0 bg-exportani-text text-exportani-background text-[8px] font-bold tracking-widest px-3.5 py-1 uppercase rounded-bl-lg border-l border-b border-exportani-border">
                        Midtrans Sandbox Mode
                    </div>

                    <h3 class="font-bold text-exportani-text text-base mb-1">Metode Pembayaran</h3>
                    <p class="text-xs text-exportani-secondaryText mb-6">Pilih salah satu opsi pembayaran simulasi di bawah untuk melanjutkan transaksi.</p>
                    
                    <!-- Payment Methods Selector -->
                    <div class="grid grid-cols-3 gap-3 mb-6">
                        <button type="button" @click="method = 'qris'" :class="method === 'qris' ? 'border-exportani-primary bg-exportani-primary/5 text-exportani-dark ring-1 ring-exportani-primary/20' : 'border-exportani-border bg-white text-exportani-secondaryText hover:bg-exportani-background'" class="rounded-xl border p-4 text-center transition flex flex-col items-center justify-center gap-2 group">
                            <svg class="h-5 w-5 text-exportani-secondaryText group-hover:text-exportani-primary shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" :class="method === 'qris' ? 'text-exportani-primary' : ''">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h3m-3-3H9m1.5 12V9m3 12H9m-1.5-6h.01M3 21h18M3 3h6v6H3V3zm12 0h6v6h-6V3zM3 15h6v6H3v-6z" />
                            </svg>
                            <span class="text-[11px] font-bold">QRIS Code</span>
                        </button>
                        
                        <button type="button" @click="method = 'gopay'" :class="method === 'gopay' ? 'border-exportani-primary bg-exportani-primary/5 text-exportani-dark ring-1 ring-exportani-primary/20' : 'border-exportani-border bg-white text-exportani-secondaryText hover:bg-exportani-background'" class="rounded-xl border p-4 text-center transition flex flex-col items-center justify-center gap-2 group">
                            <svg class="h-5 w-5 text-exportani-secondaryText group-hover:text-exportani-primary shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" :class="method === 'gopay' ? 'text-exportani-primary' : ''">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            <span class="text-[11px] font-bold">GoPay</span>
                        </button>
 
                        <button type="button" @click="method = 'va'" :class="method === 'va' ? 'border-exportani-primary bg-exportani-primary/5 text-exportani-dark ring-1 ring-exportani-primary/20' : 'border-exportani-border bg-white text-exportani-secondaryText hover:bg-exportani-background'" class="rounded-xl border p-4 text-center transition flex flex-col items-center justify-center gap-2 group">
                            <svg class="h-5 w-5 text-exportani-secondaryText group-hover:text-exportani-primary shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" :class="method === 'va' ? 'text-exportani-primary' : ''">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span class="text-[11px] font-bold">Virtual Account</span>
                        </button>
                    </div>
 
                    <!-- Payment Visualizer Screens -->
                    <div class="rounded-xl border border-exportani-border bg-exportani-background p-6 flex flex-col items-center justify-center min-h-[220px]">
                        
                        <!-- QRIS SCREEN -->
                        <div x-show="method === 'qris'" class="text-center space-y-4 w-full">
                            <div class="bg-white p-4 rounded-xl border border-exportani-border inline-block shadow-sm">
                                <div class="w-36 h-36 border-4 border-exportani-text bg-exportani-background flex flex-col items-center justify-center p-1 relative mx-auto">
                                    <div class="grid grid-cols-3 gap-2.5 w-full h-full opacity-60">
                                        <div class="bg-exportani-text rounded"></div>
                                        <div class="bg-exportani-text rounded"></div>
                                        <div class="bg-exportani-text rounded"></div>
                                        <div class="bg-exportani-text rounded"></div>
                                        <div class="bg-exportani-primary rounded animate-pulse"></div>
                                        <div class="bg-exportani-text rounded"></div>
                                        <div class="bg-exportani-text rounded"></div>
                                        <div class="bg-exportani-text rounded"></div>
                                        <div class="bg-exportani-text rounded"></div>
                                    </div>
                                    <span class="absolute font-mono font-bold text-exportani-text text-[10px] bg-white px-2 py-0.5 rounded shadow border border-exportani-border">QRIS CODE</span>
                                </div>
                            </div>
                            <p class="text-[11px] text-exportani-secondaryText">Scan QR Code simulasi di atas menggunakan dompet digital pilihan Anda.</p>
                        </div>
 
                        <!-- GOPAY SCREEN -->
                        <div x-show="method === 'gopay'" class="text-center space-y-3 w-full max-w-sm">
                            <div class="h-8 w-20 bg-sky-600 text-white rounded-lg flex items-center justify-center text-xs font-bold font-sans mx-auto tracking-wide">
                                gopay
                            </div>
                            <p class="text-xs font-semibold text-exportani-text mt-2">Nomor HP Terdaftar GoPay Anda</p>
                            <input type="text" value="{{ auth()->user()->phone ?? '0812-3456-7890' }}" disabled class="w-full text-center rounded-lg border-exportani-border bg-white text-exportani-text text-xs font-mono">
                            <p class="text-[10px] text-exportani-secondaryText">Saldo GoPay Anda akan otomatis terpotong saat menyetujui simulasi transaksi.</p>
                        </div>
 
                        <!-- VA SCREEN -->
                        <div x-show="method === 'va'" class="w-full space-y-3">
                            <div class="rounded-xl border border-exportani-border bg-white p-4 flex justify-between items-center shadow-sm">
                                <div>
                                    <p class="text-[10px] text-exportani-secondaryText font-bold uppercase tracking-wider">Virtual Account BCA</p>
                                    <p class="text-sm font-mono font-bold text-exportani-text mt-0.5">80777{{ auth()->user()->id . time() }}</p>
                                </div>
                                <span class="text-[10px] font-bold text-exportani-primary bg-exportani-mint/15 border border-exportani-mint/20 px-2 py-0.5 rounded">BCA VA</span>
                            </div>
                            <div class="rounded-xl border border-exportani-border bg-white p-4 flex justify-between items-center shadow-sm">
                                <div>
                                    <p class="text-[10px] text-exportani-secondaryText font-bold uppercase tracking-wider">Virtual Account Mandiri</p>
                                    <p class="text-sm font-mono font-bold text-exportani-text mt-0.5">88392{{ auth()->user()->id . time() }}</p>
                                </div>
                                <span class="text-[10px] font-bold text-blue-800 bg-blue-50 border border-blue-100 px-2 py-0.5 rounded">Mandiri VA</span>
                            </div>
                        </div>
 
                    </div>
 
                    <!-- Real-looking Pay Button Form -->
                    <form method="POST" action="{{ route('premium.simulate-payment') }}" class="mt-6">
                        @csrf
                        <input type="hidden" name="transaction_id" value="{{ $subscription->transaction_id }}">
                        <input type="hidden" name="status" value="success">
                        <input type="hidden" name="payment_type" :value="method">
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-exportani-primary hover:bg-exportani-dark px-4 py-3 text-xs font-bold text-white shadow-sm transition">
                            Bayar Sekarang (Simulasi)
                        </button>
                        <p class="text-[9px] text-exportani-secondaryText text-center mt-2">
                            Pembayaran dienkripsi secara aman dan diproses otomatis oleh Midtrans Sandbox
                        </p>
                    </form>
 
                    <!-- Developer Sandbox Simulator (Collapsed Section) -->
                    <div class="mt-6 border-t border-exportani-border pt-6">
                        <details id="sandbox-simulation-details" class="group rounded-xl border border-exportani-border bg-exportani-background p-4 transition duration-200">
                            <summary class="flex justify-between items-center font-bold text-xs text-exportani-secondaryText cursor-pointer select-none">
                                <span>Developer Sandbox Controller (Untuk Demo Dosen)</span>
                                <span class="transition group-open:rotate-180 text-xs text-exportani-secondaryText">▼</span>
                            </summary>
                            <div class="mt-4 space-y-3">
                                <p class="text-[11px] text-exportani-secondaryText leading-relaxed">Klik tombol simulasi di bawah untuk mengirimkan webhook pembayaran bersangkutan ke sistem secara instan.</p>
                                
                                <div class="grid sm:grid-cols-2 gap-3 pt-1">
                                    <!-- SUCCESS FORM -->
                                    <form method="POST" action="{{ route('premium.simulate-payment') }}">
                                        @csrf
                                        <input type="hidden" name="transaction_id" value="{{ $subscription->subscription_id ?? $subscription->transaction_id }}">
                                        <input type="hidden" name="status" value="success">
                                        <input type="hidden" name="payment_type" :value="method">
                                        <button type="submit" class="w-full inline-flex items-center justify-center gap-1.5 rounded-lg bg-exportani-primary hover:bg-exportani-dark px-4 py-2.5 text-xs font-semibold text-white transition">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Simulasikan Sukses
                                        </button>
                                    </form>
 
                                    <!-- EXPIRE/FAIL FORM -->
                                    <form method="POST" action="{{ route('premium.simulate-payment') }}">
                                        @csrf
                                        <input type="hidden" name="transaction_id" value="{{ $subscription->subscription_id ?? $subscription->transaction_id }}">
                                        <input type="hidden" name="status" value="failed">
                                        <input type="hidden" name="payment_type" :value="method">
                                        <button type="submit" class="w-full inline-flex items-center justify-center gap-1.5 rounded-lg border border-exportani-border bg-white hover:bg-exportani-background px-4 py-2.5 text-xs font-semibold text-exportani-secondaryText transition">
                                            <svg class="h-3.5 w-3.5 text-exportani-secondaryText" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Simulasikan Gagal
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </details>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
