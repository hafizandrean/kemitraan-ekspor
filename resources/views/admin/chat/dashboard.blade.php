<x-app-layout>
    <x-slot name="header">
<<<<<<< Updated upstream
        <div>
            <h2 class="font-display text-2xl font-semibold text-exportani-text tracking-tight">
                Moderasi Chat & Laporan Pengguna
            </h2>
            <p class="mt-1 text-sm text-exportani-secondaryText">Review laporan pelanggaran chat, suspend/ban user, dan kelola integritas platform.</p>
        </div>
=======
        <h2 class="font-display text-2xl font-semibold text-stone-900 tracking-tight">
            Moderasi Chat & Laporan Pengguna
        </h2>
        <p class="mt-1 text-sm text-stone-600">Review laporan pelanggaran chat, suspend user, dan kelola integritas platform.</p>
>>>>>>> Stashed changes
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-8">
        
        @if (session('success'))
<<<<<<< Updated upstream
            <div class="rounded-xl border border-exportani-mint/30 bg-exportani-mint/10 px-4 py-3 text-sm font-medium text-exportani-accent shadow-sm">
=======
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-900 shadow-sm">
>>>>>>> Stashed changes
                {{ session('success') }}
            </div>
        @endif

<<<<<<< Updated upstream
        @if (session('error'))
            <div class="rounded-xl border border-rose-200 bg-rose-50 dark:bg-rose-950/20 dark:border-rose-900/40 px-4 py-3 text-sm font-medium text-rose-900 dark:text-rose-300 shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Card 1 -->
            <div class="bg-white overflow-hidden shadow-sm border-l-4 border-l-exportani-mint border-y border-r border-exportani-border rounded-2xl p-5 flex items-center justify-between transition-all duration-200 hover:shadow-md">
                <div>
                    <p class="text-xs font-semibold text-exportani-secondaryText uppercase tracking-wider">Total Percakapan</p>
                    <p class="mt-2 text-3xl font-bold text-exportani-text">{{ $totalConversations }}</p>
                </div>
                <div class="p-3 bg-exportani-mint/15 rounded-xl text-exportani-accent">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
=======
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <div class="bg-white overflow-hidden shadow-sm border border-stone-200/80 rounded-2xl p-5 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-stone-500 uppercase tracking-wider">Total Percakapan</p>
                    <p class="mt-2 text-3xl font-bold text-stone-900">{{ $totalConversations }}</p>
                </div>
                <div class="p-3 bg-stone-100 rounded-xl text-stone-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
>>>>>>> Stashed changes
                    </svg>
                </div>
            </div>

<<<<<<< Updated upstream
            <!-- Card 2 -->
            <div class="bg-white overflow-hidden shadow-sm border-l-4 border-l-exportani-mint border-y border-r border-exportani-border rounded-2xl p-5 flex items-center justify-between transition-all duration-200 hover:shadow-md">
                <div>
                    <p class="text-xs font-semibold text-exportani-secondaryText uppercase tracking-wider">Pesan Hari Ini</p>
                    <p class="mt-2 text-3xl font-bold text-exportani-text">{{ $messagesToday }}</p>
                </div>
                <div class="p-3 bg-exportani-mint/15 rounded-xl text-exportani-accent">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
=======
            <div class="bg-white overflow-hidden shadow-sm border border-stone-200/80 rounded-2xl p-5 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-stone-500 uppercase tracking-wider">Pesan Terkirim Hari Ini</p>
                    <p class="mt-2 text-3xl font-bold text-emerald-600">{{ $messagesToday }}</p>
                </div>
                <div class="p-3 bg-emerald-50 rounded-xl text-emerald-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
>>>>>>> Stashed changes
                    </svg>
                </div>
            </div>

<<<<<<< Updated upstream
            <!-- Card 3 -->
            <div class="bg-white overflow-hidden shadow-sm border-l-4 border-l-rose-500 border-y border-r border-exportani-border rounded-2xl p-5 flex items-center justify-between transition-all duration-200 hover:shadow-md">
                <div>
                    <p class="text-xs font-semibold text-exportani-secondaryText uppercase tracking-wider">Laporan Pending</p>
                    <p class="mt-2 text-3xl font-bold {{ $pendingReports > 0 ? 'text-red-600' : 'text-exportani-text' }}">
                        {{ $pendingReports }}
                    </p>
                </div>
                <div class="p-3 {{ $pendingReports > 0 ? 'bg-red-50 text-red-500' : 'bg-exportani-mint/15 text-exportani-accent' }} rounded-xl">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
=======
            <div class="bg-white overflow-hidden shadow-sm border border-stone-200/80 rounded-2xl p-5 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-stone-500 uppercase tracking-wider">Laporan Pending</p>
                    <p class="mt-2 text-3xl font-bold {{ $pendingReports > 0 ? 'text-red-600' : 'text-stone-900' }}">{{ $pendingReports }}</p>
                </div>
                <div class="p-3 {{ $pendingReports > 0 ? 'bg-red-50 text-red-600 animate-pulse' : 'bg-stone-100 text-stone-500' }} rounded-xl">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
>>>>>>> Stashed changes
                    </svg>
                </div>
            </div>

<<<<<<< Updated upstream
            <!-- Card 4 -->
            <div class="bg-white overflow-hidden shadow-sm border-l-4 border-l-amber-500 border-y border-r border-exportani-border rounded-2xl p-5 flex items-center justify-between transition-all duration-200 hover:shadow-md">
                <div>
                    <p class="text-xs font-semibold text-exportani-secondaryText uppercase tracking-wider">User Ditangguhkan</p>
                    <p class="mt-2 text-3xl font-bold text-exportani-text">{{ $suspendedUsersCount }}</p>
                </div>
                <div class="p-3 bg-amber-50 rounded-xl text-amber-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
=======
            <div class="bg-white overflow-hidden shadow-sm border border-stone-200/80 rounded-2xl p-5 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-stone-500 uppercase tracking-wider">User Ditangguhkan / Banned</p>
                    <p class="mt-2 text-3xl font-bold text-stone-900">{{ $suspendedUsersCount }}</p>
                </div>
                <div class="p-3 bg-stone-100 rounded-xl text-stone-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
>>>>>>> Stashed changes
                    </svg>
                </div>
            </div>
        </div>

<<<<<<< Updated upstream
        <!-- Section: Top Reported Users -->
        <div class="bg-white border border-exportani-border rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-exportani-border">
                <h3 class="font-display text-sm font-bold text-exportani-text">Pengguna Paling Sering Dilaporkan</h3>
                <p class="mt-1 text-xs text-exportani-secondaryText">Daftar pengguna dengan laporan masuk terbanyak. Tindakan moderasi cepat dapat diambil di bawah ini.</p>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-exportani-border text-left text-xs">
                    <thead class="bg-[#F8FAFC] text-exportani-secondaryText font-semibold uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3.5">Nama & Kontak</th>
                            <th class="px-6 py-3.5">Peran</th>
                            <th class="px-6 py-3.5 text-center">Jumlah Laporan</th>
                            <th class="px-6 py-3.5">Status Saat Ini</th>
                            <th class="px-6 py-3.5 text-right">Moderasi Cepat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-exportani-border bg-white text-exportani-text">
                        @forelse($topReportedUsers as $repUser)
                            <tr class="hover:bg-[#F0FDF4] transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-exportani-mint/15 font-bold text-exportani-accent text-sm">
                                            {{ substr($repUser->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-exportani-text">{{ $repUser->name }}</div>
                                            <div class="text-[10px] text-exportani-secondaryText">{{ $repUser->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 uppercase">
                                    @if($repUser->role === 'petani')
                                        <span class="inline-flex items-center rounded bg-exportani-mint/15 px-1.5 py-0.5 font-medium text-exportani-accent border border-exportani-mint/20">
                                            Petani
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded bg-sky-50 px-1.5 py-0.5 font-medium text-sky-700 border border-sky-250/20">
                                            Eksportir
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center font-bold text-red-600">
=======
        <!-- Top Reported Users Section -->
        <div class="bg-white border border-stone-200/80 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-stone-100">
                <h3 class="font-display text-sm font-bold text-stone-900">Top Reported Users</h3>
                <p class="mt-1 text-xs text-stone-500">Pengguna dengan jumlah laporan tertinggi dari komunitas.</p>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-stone-100 text-left text-xs">
                    <thead class="bg-stone-50 text-stone-500 font-semibold uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3.5">Nama Pengguna</th>
                            <th class="px-6 py-3.5">Peran</th>
                            <th class="px-6 py-3.5 text-center">Jumlah Laporan</th>
                            <th class="px-6 py-3.5">Status Saat Ini</th>
                            <th class="px-6 py-3.5 text-right">Ubah Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100 bg-white">
                        @forelse($topReportedUsers as $repUser)
                            <tr>
                                <td class="px-6 py-4 font-medium text-stone-900">
                                    {{ $repUser->name }}
                                    <span class="block text-[10px] text-stone-400 mt-0.5">{{ $repUser->email }}</span>
                                </td>
                                <td class="px-6 py-4 uppercase">
                                    <span class="inline-flex items-center rounded bg-stone-100 px-1.5 py-0.5 font-medium text-stone-600">
                                        {{ $repUser->role }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center font-semibold text-red-650">
>>>>>>> Stashed changes
                                    {{ $repUser->reports_against_count }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($repUser->status === 'suspended')
<<<<<<< Updated upstream
                                        <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2 py-0.5 font-semibold text-amber-800 border border-amber-500/15">
                                            Suspended
                                        </span>
                                    @elseif($repUser->status === 'banned')
                                        <span class="inline-flex items-center gap-1 rounded-full bg-red-100 px-2 py-0.5 font-semibold text-red-800 border border-red-500/15">
                                            Banned
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 rounded-full bg-exportani-mint/15 px-2 py-0.5 font-semibold text-exportani-accent border border-exportani-mint/15">
=======
                                        <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2 py-0.5 font-semibold text-amber-800">
                                            Suspended
                                        </span>
                                    @elseif($repUser->status === 'banned')
                                        <span class="inline-flex items-center gap-1 rounded-full bg-red-100 px-2 py-0.5 font-semibold text-red-800">
                                            Banned
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2 py-0.5 font-semibold text-emerald-800">
>>>>>>> Stashed changes
                                            Active
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
<<<<<<< Updated upstream
                                    <form method="POST" action="{{ route('admin.users.status.update', $repUser) }}" class="inline-flex items-center justify-end">
                                        @csrf
                                        <select name="status" onchange="this.form.submit()" class="rounded-lg border border-exportani-border bg-white text-exportani-text px-2.5 py-1 text-[11px] font-semibold focus:outline-none focus:ring-1 focus:ring-exportani-primary focus:border-exportani-primary transition">
=======
                                    <form method="POST" action="{{ route('admin.users.status.update', $repUser) }}" class="inline-flex gap-1.5">
                                        @csrf
                                        <select name="status" onchange="this.form.submit()" class="rounded-lg border border-stone-200 px-2.5 py-1 text-[11px] font-medium text-stone-700 bg-white focus:outline-none focus:ring-1 focus:ring-emerald-600">
>>>>>>> Stashed changes
                                            <option value="active" {{ $repUser->status === 'active' ? 'selected' : '' }}>Set Active</option>
                                            <option value="suspended" {{ $repUser->status === 'suspended' ? 'selected' : '' }}>Suspend</option>
                                            <option value="banned" {{ $repUser->status === 'banned' ? 'selected' : '' }}>Ban</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
<<<<<<< Updated upstream
                                <td colspan="5" class="px-6 py-8 text-center text-exportani-secondaryText italic">
=======
                                <td colspan="5" class="px-6 py-8 text-center text-stone-500 italic">
>>>>>>> Stashed changes
                                    Tidak ada pengguna yang dilaporkan saat ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

<<<<<<< Updated upstream
        <!-- Section: Reports Log List -->
        <div class="bg-white border border-exportani-border rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-exportani-border">
                <h3 class="font-display text-sm font-bold text-exportani-text">Daftar Laporan Masuk</h3>
                <p class="mt-1 text-xs text-exportani-secondaryText">Tinjau transkrip percakapan chat secara utuh dan putuskan tindakan administratif.</p>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-exportani-border text-left text-xs">
                    <thead class="bg-[#F8FAFC] text-exportani-secondaryText font-semibold uppercase tracking-wider">
=======
        <!-- Reports Log Section -->
        <div class="bg-white border border-stone-200/80 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-stone-100">
                <h3 class="font-display text-sm font-bold text-stone-900">Daftar Laporan Masuk</h3>
                <p class="mt-1 text-xs text-stone-500">Tinjau transkrip obrolan dan selesaikan aduan pengguna.</p>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-stone-100 text-left text-xs">
                    <thead class="bg-stone-50 text-stone-500 font-semibold uppercase tracking-wider">
>>>>>>> Stashed changes
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
<<<<<<< Updated upstream
                    <tbody class="divide-y divide-exportani-border bg-white text-exportani-text">
                        @forelse($reports as $report)
                            <tr class="hover:bg-[#F0FDF4] transition">
                                <td class="px-6 py-4 font-semibold text-exportani-text">
                                    {{ $report->reporter->name }}
                                    <span class="block text-[9px] text-exportani-secondaryText mt-0.5 uppercase tracking-wide">{{ $report->reporter->role }}</span>
                                </td>
                                <td class="px-6 py-4 font-semibold text-exportani-text">
                                    {{ $report->reportedUser->name }}
                                    <span class="block text-[9px] text-exportani-secondaryText mt-0.5 uppercase tracking-wide">{{ $report->reportedUser->role }}</span>
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
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[10px] font-bold bg-red-50 text-red-750 border border-red-500/10">
                                        {{ $label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 max-w-xs truncate" title="{{ $report->description }}">
                                    {{ $report->description }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($report->status === 'dismissed')
                                        <span class="inline-flex items-center gap-1 rounded-full bg-exportani-background px-2 py-0.5 font-bold text-exportani-secondaryText">
                                            Ditolak
                                        </span>
                                    @elseif($report->status === 'resolved')
                                        <span class="inline-flex items-center gap-1 rounded-full bg-exportani-mint/15 px-2 py-0.5 font-bold text-exportani-accent border border-exportani-mint/15">
                                            Selesai
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2 py-0.5 font-bold text-amber-800 animate-pulse">
=======
                    <tbody class="divide-y divide-stone-100 bg-white">
                        @forelse($reports as $report)
                            <tr>
                                <td class="px-6 py-4 font-medium text-stone-900">
                                    {{ $report->reporter->name }}
                                    <span class="block text-[10px] text-stone-400 mt-0.5 uppercase">{{ $report->reporter->role }}</span>
                                </td>
                                <td class="px-6 py-4 font-medium text-stone-950">
                                    {{ $report->reportedUser->name }}
                                    <span class="block text-[10px] text-stone-400 mt-0.5 uppercase">{{ $report->reportedUser->role }}</span>
                                </td>
                                <td class="px-6 py-4 font-semibold uppercase tracking-wider">
                                    <span class="inline-flex items-center rounded-full px-2 py-0.5 bg-red-50 text-red-700">
                                        {{ $report->reason }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 max-w-xs truncate">
                                    {{ $report->description }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($report->status === 'dismissed')
                                        <span class="inline-flex items-center gap-1 rounded-full bg-stone-100 px-2.5 py-0.5 font-semibold text-stone-600">
                                            Dismissed
                                        </span>
                                    @elseif($report->status === 'resolved')
                                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-0.5 font-semibold text-emerald-800">
                                            Resolved
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2.5 py-0.5 font-semibold text-amber-800">
>>>>>>> Stashed changes
                                            Pending
                                        </span>
                                    @endif
                                </td>
<<<<<<< Updated upstream
                                <td class="px-6 py-4 text-exportani-secondaryText whitespace-nowrap">
                                    {{ $report->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <a href="{{ route('admin.chat.report.show', $report) }}" class="inline-flex items-center justify-center rounded-lg border border-exportani-border bg-white px-3 py-1.5 font-semibold text-exportani-text shadow-sm hover:bg-[#F8FAFC] hover:text-exportani-primary transition duration-150">
=======
                                <td class="px-6 py-4 text-stone-500 whitespace-nowrap">
                                    {{ $report->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.chat.report.show', $report) }}" class="inline-flex items-center justify-center rounded-lg border border-stone-250 bg-white px-3 py-1.5 font-medium text-stone-700 shadow-sm hover:bg-stone-50 transition-colors">
>>>>>>> Stashed changes
                                        Tinjau Chat & Laporan
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
<<<<<<< Updated upstream
                                <td colspan="7" class="px-6 py-8 text-center text-exportani-secondaryText italic">
=======
                                <td colspan="7" class="px-6 py-8 text-center text-stone-500 italic">
>>>>>>> Stashed changes
                                    Belum ada laporan chat masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<<<<<<< Updated upstream
</x-app-layout>
=======
</x-app-layout>
>>>>>>> Stashed changes
