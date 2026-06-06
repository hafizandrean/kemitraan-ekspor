<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-display text-2xl font-semibold text-stone-900 dark:text-white tracking-tight">
                Moderasi Chat & Laporan Pengguna
            </h2>
            <p class="mt-1 text-sm text-stone-600 dark:text-stone-400">Review laporan pelanggaran chat, suspend/ban user, dan kelola integritas platform.</p>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-8">
        
        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 dark:bg-emerald-950/20 dark:border-emerald-900/40 px-4 py-3 text-sm font-medium text-emerald-900 dark:text-emerald-300 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-xl border border-rose-200 bg-rose-50 dark:bg-rose-950/20 dark:border-rose-900/40 px-4 py-3 text-sm font-medium text-rose-900 dark:text-rose-300 shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Card 1 -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm border border-stone-200/80 dark:border-gray-700/50 rounded-2xl p-5 flex items-center justify-between transition-all duration-200 hover:shadow-md">
                <div>
                    <p class="text-xs font-semibold text-stone-500 dark:text-stone-400 uppercase tracking-wider">Total Percakapan</p>
                    <p class="mt-2 text-3xl font-bold text-stone-900 dark:text-white">{{ $totalConversations }}</p>
                </div>
                <div class="p-3 bg-stone-100 dark:bg-gray-750 rounded-xl text-stone-500 dark:text-gray-400">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm border border-stone-200/80 dark:border-gray-700/50 rounded-2xl p-5 flex items-center justify-between transition-all duration-200 hover:shadow-md">
                <div>
                    <p class="text-xs font-semibold text-stone-500 dark:text-stone-400 uppercase tracking-wider">Pesan Hari Ini</p>
                    <p class="mt-2 text-3xl font-bold text-stone-900 dark:text-white">{{ $messagesToday }}</p>
                </div>
                <div class="p-3 bg-stone-100 dark:bg-gray-750 rounded-xl text-stone-500 dark:text-gray-400">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                    </svg>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm border border-stone-200/80 dark:border-gray-700/50 rounded-2xl p-5 flex items-center justify-between transition-all duration-200 hover:shadow-md">
                <div>
                    <p class="text-xs font-semibold text-stone-500 dark:text-stone-400 uppercase tracking-wider">Laporan Pending</p>
                    <p class="mt-2 text-3xl font-bold {{ $pendingReports > 0 ? 'text-red-650 dark:text-red-400' : 'text-stone-900 dark:text-white' }}">
                        {{ $pendingReports }}
                    </p>
                </div>
                <div class="p-3 {{ $pendingReports > 0 ? 'bg-red-50 dark:bg-red-950/20 text-red-500' : 'bg-stone-100 dark:bg-gray-750 text-stone-500 dark:text-gray-400' }} rounded-xl">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm border border-stone-200/80 dark:border-gray-700/50 rounded-2xl p-5 flex items-center justify-between transition-all duration-200 hover:shadow-md">
                <div>
                    <p class="text-xs font-semibold text-stone-500 dark:text-stone-400 uppercase tracking-wider">User Ditangguhkan</p>
                    <p class="mt-2 text-3xl font-bold text-stone-900 dark:text-white">{{ $suspendedUsersCount }}</p>
                </div>
                <div class="p-3 bg-stone-100 dark:bg-gray-750 rounded-xl text-stone-500 dark:text-gray-400">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Section: Top Reported Users -->
        <div class="bg-white dark:bg-gray-800 border border-stone-200/80 dark:border-gray-700/50 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-stone-100 dark:border-gray-700/50">
                <h3 class="font-display text-sm font-bold text-stone-900 dark:text-white">Pengguna Paling Sering Dilaporkan</h3>
                <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">Daftar pengguna dengan laporan masuk terbanyak. Tindakan moderasi cepat dapat diambil di bawah ini.</p>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-stone-100 dark:divide-gray-700/50 text-left text-xs">
                    <thead class="bg-stone-50 dark:bg-gray-900/30 text-stone-500 dark:text-gray-400 font-semibold uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3.5">Nama & Kontak</th>
                            <th class="px-6 py-3.5">Peran</th>
                            <th class="px-6 py-3.5 text-center">Jumlah Laporan</th>
                            <th class="px-6 py-3.5">Status Saat Ini</th>
                            <th class="px-6 py-3.5 text-right">Moderasi Cepat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100 dark:divide-gray-700/50 bg-white dark:bg-gray-800 text-stone-700 dark:text-gray-300">
                        @forelse($topReportedUsers as $repUser)
                            <tr class="hover:bg-stone-55/30 dark:hover:bg-gray-750/30 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-emerald-100 dark:bg-emerald-950/40 font-bold text-emerald-800 dark:text-emerald-350 text-sm">
                                            {{ substr($repUser->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-stone-900 dark:text-white">{{ $repUser->name }}</div>
                                            <div class="text-[10px] text-stone-400 dark:text-stone-500">{{ $repUser->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 uppercase">
                                    @if($repUser->role === 'petani')
                                        <span class="inline-flex items-center rounded bg-emerald-50 dark:bg-emerald-950/20 px-1.5 py-0.5 font-medium text-emerald-700 dark:text-emerald-450 border border-emerald-250/20">
                                            Petani
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded bg-sky-50 dark:bg-sky-950/20 px-1.5 py-0.5 font-medium text-sky-700 dark:text-sky-450 border border-sky-250/20">
                                            Eksportir
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center font-bold text-red-650 dark:text-red-400">
                                    {{ $repUser->reports_against_count }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($repUser->status === 'suspended')
                                        <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 dark:bg-amber-950/45 px-2 py-0.5 font-semibold text-amber-800 dark:text-amber-300 border border-amber-500/15">
                                            Suspended
                                        </span>
                                    @elseif($repUser->status === 'banned')
                                        <span class="inline-flex items-center gap-1 rounded-full bg-red-100 dark:bg-red-950/45 px-2 py-0.5 font-semibold text-red-800 dark:text-red-300 border border-red-500/15">
                                            Banned
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 dark:bg-emerald-950/45 px-2 py-0.5 font-semibold text-emerald-800 dark:text-emerald-350 border border-emerald-500/15">
                                            Active
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <form method="POST" action="{{ route('admin.users.status.update', $repUser) }}" class="inline-flex items-center justify-end">
                                        @csrf
                                        <select name="status" onchange="this.form.submit()" class="rounded-lg border border-stone-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-stone-850 dark:text-gray-200 px-2.5 py-1 text-[11px] font-semibold focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:border-emerald-600 transition">
                                            <option value="active" {{ $repUser->status === 'active' ? 'selected' : '' }}>Set Active</option>
                                            <option value="suspended" {{ $repUser->status === 'suspended' ? 'selected' : '' }}>Suspend</option>
                                            <option value="banned" {{ $repUser->status === 'banned' ? 'selected' : '' }}>Ban</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-stone-400 dark:text-stone-500 italic">
                                    Tidak ada pengguna yang dilaporkan saat ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Section: Reports Log List -->
        <div class="bg-white dark:bg-gray-800 border border-stone-200/80 dark:border-gray-700/50 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-stone-100 dark:border-gray-700/50">
                <h3 class="font-display text-sm font-bold text-stone-900 dark:text-white">Daftar Laporan Masuk</h3>
                <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">Tinjau transkrip percakapan chat secara utuh dan putuskan tindakan administratif.</p>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-stone-100 dark:divide-gray-700/50 text-left text-xs">
                    <thead class="bg-stone-50 dark:bg-gray-900/30 text-stone-500 dark:text-gray-400 font-semibold uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3.5">Pelapor</th>
                            <th class="px-6 py-3.5">Dilaporkan</th>
                            <th class="px-6 py-3.5">Alasan</th>
                            <th class="px-6 py-3.5">Deskripsi</th>
                            <th class="px-6 py-3.5">Status</th>
                            <th class="px-6 py-3.5">Tanggal</th>
                            <th class="px-6 py-3.5 text-right">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100 dark:divide-gray-700/50 bg-white dark:bg-gray-800 text-stone-700 dark:text-gray-300">
                        @forelse($reports as $report)
                            <tr class="hover:bg-stone-55/30 dark:hover:bg-gray-750/30 transition">
                                <td class="px-6 py-4 font-semibold text-stone-900 dark:text-white">
                                    {{ $report->reporter->name }}
                                    <span class="block text-[9px] text-stone-400 dark:text-stone-500 mt-0.5 uppercase tracking-wide">{{ $report->reporter->role }}</span>
                                </td>
                                <td class="px-6 py-4 font-semibold text-stone-950 dark:text-white">
                                    {{ $report->reportedUser->name }}
                                    <span class="block text-[9px] text-stone-400 dark:text-stone-500 mt-0.5 uppercase tracking-wide">{{ $report->reportedUser->role }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $reasonLabels = [
                                            'spam' => 'Spam / Gangguan',
                                            'fraud' => 'Penipuan / Fraud',
                                            'harassment' => 'Pelecehan / Toksik',
                                            'inappropriate' => 'Konten Tidak Pantas',
                                            'other' => 'Lainnya'
                                        ];
                                        $label = $reasonLabels[$report->reason] ?? ucfirst($report->reason);
                                    @endphp
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[10px] font-bold bg-red-50 dark:bg-red-950/20 text-red-700 dark:text-red-400 border border-red-500/10">
                                        {{ $label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 max-w-xs truncate" title="{{ $report->description }}">
                                    {{ $report->description }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($report->status === 'dismissed')
                                        <span class="inline-flex items-center gap-1 rounded-full bg-stone-100 dark:bg-gray-700 px-2 py-0.5 font-bold text-stone-600 dark:text-stone-400">
                                            Ditolak
                                        </span>
                                    @elseif($report->status === 'resolved')
                                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 dark:bg-emerald-950/45 px-2 py-0.5 font-bold text-emerald-800 dark:text-emerald-350">
                                            Selesai
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 rounded-full bg-amber-150 dark:bg-amber-950/45 px-2 py-0.5 font-bold text-amber-800 dark:text-amber-350 animate-pulse">
                                            Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-stone-500 dark:text-stone-400 whitespace-nowrap">
                                    {{ $report->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <a href="{{ route('admin.chat.report.show', $report) }}" class="inline-flex items-center justify-center rounded-lg border border-stone-250 dark:border-gray-750 bg-white dark:bg-gray-800 px-3 py-1.5 font-semibold text-stone-700 dark:text-gray-300 shadow-sm hover:bg-stone-50 dark:hover:bg-gray-750 hover:text-emerald-700 dark:hover:text-emerald-450 transition duration-150">
                                        Tinjau Chat & Laporan
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-stone-400 dark:text-stone-500 italic">
                                    Belum ada laporan chat masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>