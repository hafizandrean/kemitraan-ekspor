<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('premium.index') }}" class="inline-flex items-center justify-center h-10 w-10 rounded-full border border-stone-300 bg-white text-stone-500 hover:bg-emerald-50 hover:text-emerald-600 transition shadow-sm">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="font-display text-2xl font-semibold text-stone-900 tracking-tight">Riwayat Langganan</h2>
                <p class="mt-1 text-sm text-stone-600">Audit transparan transaksi dan riwayat masa aktif Premium Anda.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto">
        <div class="bg-white rounded-2xl border border-stone-200 shadow-sm overflow-hidden">
            @if($subscriptions->isEmpty())
                <div class="p-16 text-center">
                    <div class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-stone-50 text-stone-400 border border-stone-200 shadow-sm mb-4">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-stone-800">Belum ada riwayat subscription</h3>
                    <p class="text-sm text-stone-500 mt-2 max-w-sm mx-auto">Semua riwayat pembelian, masa berakhir, dan metode pembayaran subscription Anda akan tercatat di sini.</p>
                    <div class="mt-6">
                        <a href="{{ route('premium.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition">
                            Mulai Upgrade ke Premium Sekarang
                        </a>
                    </div>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-stone-50 border-b border-stone-200 text-xs font-semibold uppercase tracking-wider text-stone-500">
                                <th class="py-4 px-6">ID / Transaksi</th>
                                <th class="py-4 px-6">Paket Premium</th>
                                <th class="py-4 px-6">Gross Amount</th>
                                <th class="py-4 px-6">Metode</th>
                                <th class="py-4 px-6">Status</th>
                                <th class="py-4 px-6">Masa Aktif</th>
                                <th class="py-4 px-6">Dibuat Pada</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-200 text-sm text-stone-700">
                            @foreach($subscriptions as $sub)
                                <tr class="hover:bg-stone-50/50 transition">
                                    <td class="py-4 px-6">
                                        <div class="font-mono font-bold text-stone-700 text-xs bg-stone-50 border border-stone-200 px-2 py-0.5 rounded inline-block">
                                            {{ $sub->transaction_id ?? 'SUB-TRX-' . $sub->id }}
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="font-semibold text-stone-900">
                                            {{ $sub->plan->name }}
                                        </div>
                                        <div class="text-xs text-stone-500">
                                            Durasi: {{ $sub->plan->duration_days }} hari
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 font-semibold text-stone-800">
                                        Rp{{ number_format($sub->gross_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="uppercase text-xs font-bold text-stone-600 bg-stone-100 px-2 py-0.5 rounded">
                                            {{ $sub->payment_type ?? 'ONLINE' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6">
                                        @php
                                            $color = match($sub->status) {
                                                'active' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                                                'paid' => 'bg-sky-50 text-sky-800 border-sky-200',
                                                'pending' => 'bg-amber-50 text-amber-800 border-amber-200 animate-pulse',
                                                'failed' => 'bg-red-50 text-red-800 border-red-200',
                                                'cancelled' => 'bg-rose-50 text-rose-800 border-rose-200',
                                                'expired' => 'bg-stone-50 text-stone-500 border-stone-200',
                                                default => 'bg-stone-50 text-stone-800 border-stone-200',
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
                                    <td class="py-4 px-6 text-stone-600 text-xs">
                                        @if($sub->status === 'active' || $sub->status === 'expired')
                                            <div class="font-medium text-stone-800">
                                                {{ $sub->start_date ? $sub->start_date->format('d M Y') : '-' }} s/d
                                            </div>
                                            <div class="font-bold text-stone-900 mt-0.5">
                                                {{ $sub->end_date ? $sub->end_date->format('d M Y') : '-' }}
                                            </div>
                                        @else
                                            <span class="text-stone-400 font-medium">-</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-stone-500 text-xs">
                                        @if($sub->paid_at)
                                            <div class="text-stone-700 font-medium">Lunas: {{ $sub->paid_at->format('d M Y H:i') }}</div>
                                        @endif
                                        <div class="mt-0.5">Dibuat: {{ $sub->created_at->format('d M Y H:i') }}</div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($subscriptions->hasPages())
                    <div class="p-6 border-t border-stone-200">
                        {{ $subscriptions->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>
