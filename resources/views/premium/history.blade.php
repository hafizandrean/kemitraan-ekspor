<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('premium.index') }}" class="inline-flex items-center justify-center h-9 w-9 rounded-lg border border-exportani-border bg-white text-exportani-secondaryText hover:bg-exportani-background hover:text-exportani-primary transition shadow-sm">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="font-display text-lg font-bold text-exportani-text tracking-tight">Riwayat Langganan</h2>
                <p class="mt-0.5 text-xs text-exportani-secondaryText">Audit transparan transaksi dan riwayat masa aktif Premium Anda.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto">
        <div class="bg-white rounded-2xl border border-exportani-border shadow-sm overflow-hidden">
            @if($subscriptions->isEmpty())
                <div class="p-16 text-center">
                    <div class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-exportani-background text-exportani-secondaryText border border-exportani-border shadow-sm mb-4">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-exportani-text">Belum ada riwayat subscription</h3>
                    <p class="text-sm text-exportani-secondaryText mt-2 max-w-sm mx-auto">Semua riwayat pembelian, masa berakhir, dan metode pembayaran subscription Anda akan tercatat di sini.</p>
                    <div class="mt-6">
                        <a href="{{ route('premium.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-exportani-primary hover:bg-exportani-dark px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition">
                            Mulai Upgrade ke Premium Sekarang
                        </a>
                    </div>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#F8FAFC] border-b border-exportani-border text-xs font-semibold uppercase tracking-wider text-exportani-secondaryText">
                                <th class="py-4 px-6">ID / Transaksi</th>
                                <th class="py-4 px-6">Paket Premium</th>
                                <th class="py-4 px-6">Gross Amount</th>
                                <th class="py-4 px-6">Metode</th>
                                <th class="py-4 px-6">Status</th>
                                <th class="py-4 px-6">Masa Aktif</th>
                                <th class="py-4 px-6">Dibuat Pada</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-exportani-border text-sm text-exportani-text">
                            @foreach($subscriptions as $sub)
                                <tr class="hover:bg-[#F0FDF4] transition duration-150">
                                    <td class="py-4 px-6">
                                        <div class="font-mono font-bold text-exportani-secondaryText text-xs bg-exportani-background border border-exportani-border px-2 py-0.5 rounded inline-block">
                                            {{ $sub->transaction_id ?? 'SUB-TRX-' . $sub->id }}
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="font-semibold text-exportani-text">
                                            {{ $sub->plan->name }}
                                        </div>
                                        <div class="text-xs text-exportani-secondaryText">
                                            Durasi: {{ $sub->plan->duration_days }} hari
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 font-semibold text-exportani-text">
                                        Rp{{ number_format($sub->gross_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="uppercase text-xs font-bold text-exportani-secondaryText bg-exportani-background border border-exportani-border px-2 py-0.5 rounded">
                                            {{ $sub->payment_type ?? 'ONLINE' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6">
                                        @php
                                            $color = match($sub->status) {
                                                'active' => 'bg-exportani-mint/15 text-exportani-accent border-exportani-mint/20',
                                                'paid' => 'bg-sky-50 text-sky-850 border-sky-200',
                                                'pending' => 'bg-amber-50 text-amber-800 border-amber-200 animate-pulse',
                                                'failed' => 'bg-red-50 text-red-800 border-red-200',
                                                'cancelled' => 'bg-rose-50 text-rose-800 border-rose-200',
                                                'expired' => 'bg-exportani-background text-exportani-secondaryText border-exportani-border',
                                                default => 'bg-exportani-background text-exportani-text border-exportani-border',
                                            };
                                            
                                            $label = match($sub->status) {
                                                'active' => 'Aktif',
                                                'paid' => 'Lunas',
                                                'pending' => 'Pending',
                                                'failed' => 'Gagal',
                                                'cancelled' => 'Dibatalkan',
                                                'expired' => 'Expired',
                                                default => ucfirst($sub->status),
                                            };
                                        @endphp
                                        <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold {{ $color }}">
                                            {{ $label }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-exportani-secondaryText text-xs">
                                        @if($sub->status === 'active' || $sub->status === 'expired')
                                            <div class="font-medium text-exportani-text">
                                                {{ $sub->start_date ? $sub->start_date->format('d M Y') : '-' }} s/d
                                            </div>
                                            <div class="font-bold text-exportani-text mt-0.5">
                                                {{ $sub->end_date ? $sub->end_date->format('d M Y') : '-' }}
                                            </div>
                                        @else
                                            <span class="text-exportani-secondaryText/50 font-medium">-</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-exportani-secondaryText text-xs">
                                        @if($sub->paid_at)
                                            <div class="text-exportani-text font-medium">Lunas: {{ $sub->paid_at->format('d M Y H:i') }}</div>
                                        @endif
                                        <div class="mt-0.5">Dibuat: {{ $sub->created_at->format('d M Y H:i') }}</div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($subscriptions->hasPages())
                    <div class="p-6 border-t border-exportani-border">
                        {{ $subscriptions->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>
