<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-display text-2xl font-semibold text-stone-900 tracking-tight">Monitoring Transaksi & Langganan</h2>
                <p class="mt-1 text-sm text-stone-600">Audit real-time transaksi otomatis Payment Gateway Midtrans dan status Premium pengguna.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-10">
        @if(session('success'))
            <div class="rounded-xl border border-emerald-250 bg-emerald-50/60 p-4 text-xs text-emerald-900 shadow-sm flex items-start gap-2.5">
                <svg class="h-4 w-4 text-emerald-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="font-medium">{{ session('success') }}</div>
            </div>
        @endif

        <!-- SECTION: SUBSCRIPTION PAYMENTS MONITORING -->
        <div class="space-y-4">
            <div class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <svg class="h-5 w-5 text-stone-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    <h3 class="font-display text-lg font-bold text-stone-900">
                        Log Transaksi Midtrans Sandbox
                    </h3>
                </div>
                <span class="text-xs font-semibold bg-emerald-50 border border-emerald-200 text-emerald-800 px-3 py-1 rounded-full flex items-center gap-1.5">
                    <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Sistem Otomatis Aktif
                </span>
            </div>
            
            <div class="rounded-2xl border border-stone-200 bg-white overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-stone-50 text-xs font-semibold text-stone-500 uppercase border-b border-stone-100">
                                <th class="p-4">Pengguna</th>
                                <th class="p-4">ID Transaksi</th>
                                <th class="p-4">Paket Premium</th>
                                <th class="p-4">Gross Amount</th>
                                <th class="p-4">Metode Bayar</th>
                                <th class="p-4">Status</th>
                                <th class="p-4">Tanggal Pembayaran / Log</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100 text-sm">
                            @forelse($subscriptions as $sub)
                                <tr class="hover:bg-stone-50/50 transition">
                                    <td class="p-4">
                                        <div class="flex items-center gap-3">
                                            <div class="h-9 w-9 rounded-full bg-stone-100 flex items-center justify-center font-bold text-stone-700">
                                                {{ strtoupper(substr($sub->user->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="font-semibold text-stone-900">{{ $sub->user->name }}</div>
                                                <div class="text-xs text-stone-500">{{ $sub->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <span class="font-mono font-bold text-stone-700 text-xs bg-stone-50 border border-stone-200 px-2 py-1 rounded">
                                            {{ $sub->transaction_id ?? 'DUMMY-TRX' }}
                                        </span>
                                    </td>
                                    <td class="p-4">
                                        <div class="font-medium text-stone-800">{{ $sub->plan->name }}</div>
                                        <div class="text-xs text-stone-500">Masa aktif: {{ $sub->plan->duration_days }} hari</div>
                                    </td>
                                    <td class="p-4">
                                        <span class="font-semibold text-stone-900">
                                            Rp{{ number_format($sub->gross_amount, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="p-4">
                                        <span class="inline-flex items-center gap-1.5 uppercase text-xs font-bold text-stone-600 bg-stone-100/80 px-2 py-0.5 rounded">
                                            @if($sub->payment_type === 'qris')
                                                QRIS
                                            @elseif($sub->payment_type === 'gopay')
                                                GoPay
                                            @elseif($sub->payment_type === 'shopeepay')
                                                ShopeePay
                                            @elseif($sub->payment_type === 'bank_transfer')
                                                VA Transfer
                                            @else
                                                {{ strtoupper($sub->payment_type ?? 'ONLINE') }}
                                            @endif
                                        </span>
                                    </td>
                                    <td class="p-4">
                                        @php
                                            $color = match($sub->status) {
                                                'active' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                                                'paid' => 'bg-sky-50 text-sky-800 border-sky-200',
                                                'pending' => 'bg-amber-50 text-amber-800 border-amber-200 animate-pulse',
                                                'failed' => 'bg-red-50 text-red-800 border-red-200',
                                                'cancelled' => 'bg-orange-50 text-orange-800 border-orange-200',
                                                'expired' => 'bg-stone-50 text-stone-600 border-stone-200',
                                                default => 'bg-stone-50 text-stone-800 border-stone-200',
                                            };
                                        @endphp
                                        <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold {{ $color }}">
                                            {{ strtoupper($sub->status) }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-stone-500 text-xs">
                                        @if($sub->paid_at)
                                            <div class="font-semibold text-stone-700">Paid: {{ $sub->paid_at->format('d M Y H:i') }}</div>
                                        @endif
                                        <div class="mt-0.5">Created: {{ $sub->created_at->format('d M Y H:i') }}</div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-12 text-center">
                                        <div class="max-w-md mx-auto space-y-4">
                                            <svg class="h-10 w-10 text-stone-400 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                            </svg>
                                            <div>
                                                <h4 class="font-bold text-stone-800 text-base">Belum ada riwayat transaksi</h4>
                                                <p class="mt-2 text-sm text-stone-500">Semua aktivitas upgrade premium otomatis lewat payment gateway akan dicatat secara real-time di sini.</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if($subscriptions->hasPages())
                <div class="mt-2">
                    {{ $subscriptions->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
