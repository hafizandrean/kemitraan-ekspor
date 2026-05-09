<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-display text-2xl font-semibold text-stone-900 tracking-tight">
                {{ __('Dashboard') }}
            </h2>
            <p class="mt-1 text-sm text-stone-600">Ringkasan akun dan langkah berikutnya.</p>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto space-y-8">
            <div class="rounded-2xl border border-emerald-200/60 bg-gradient-to-br from-emerald-600 to-teal-700 p-8 text-white shadow-xl shadow-emerald-900/20">
                <p class="text-emerald-100 text-sm font-medium uppercase tracking-wide">Selamat datang</p>
                <p class="mt-2 font-display text-2xl sm:text-3xl font-semibold leading-tight">
                    Halo, {{ auth()->user()->name }}.
                </p>
                <p class="mt-3 max-w-xl text-emerald-50/95 text-sm leading-relaxed">
                    @if(auth()->user()->role === 'petani')
                        Kelola produk kamu dan tinjau permintaan kerja sama dari eksportir.
                    @else
                        Cari produk dari petani dan ajukan kerja sama dalam beberapa klik.
                    @endif
                </p>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                @if(auth()->user()->role === 'petani')
                    <a href="{{ route('petani.products.index') }}" class="group block rounded-2xl border border-stone-200/80 bg-white/90 p-6 shadow-sm shadow-stone-900/5 transition hover:border-emerald-300 hover:shadow-md hover:shadow-emerald-900/5">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <h3 class="mt-4 font-display text-lg font-semibold text-stone-900 group-hover:text-emerald-800">Produk saya</h3>
                        <p class="mt-1 text-sm text-stone-600">Tambah atau lihat daftar produk yang sudah dipublikasi.</p>
                        <span class="mt-4 inline-flex text-sm font-semibold text-emerald-600">Buka halaman →</span>
                    </a>
                    <a href="{{ route('requests.index') }}" class="group rounded-2xl border border-stone-200/80 bg-white/90 p-6 shadow-sm shadow-stone-900/5 transition hover:border-emerald-300 hover:shadow-md hover:shadow-emerald-900/5">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-amber-800">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="mt-4 font-display text-lg font-semibold text-stone-900 group-hover:text-emerald-800">Permintaan masuk</h3>
                        <p class="mt-1 text-sm text-stone-600">Terima atau tolak pengajuan kerja sama dari eksportir.</p>
                        <span class="mt-4 inline-flex text-sm font-semibold text-emerald-600">Kelola permintaan →</span>
                    </a>
                @else
                    <a href="{{ route('products.index') }}" class="group rounded-2xl border border-stone-200/80 bg-white/90 p-6 shadow-sm shadow-stone-900/5 transition hover:border-emerald-300 hover:shadow-md hover:shadow-emerald-900/5 sm:col-span-2">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-teal-100 text-teal-800">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <h3 class="mt-4 font-display text-lg font-semibold text-stone-900 group-hover:text-emerald-800">Cari produk</h3>
                        <p class="mt-1 text-sm text-stone-600">Gunakan pencarian nama produk, lalu buka detail untuk mengajukan kerja sama.</p>
                        <span class="mt-4 inline-flex text-sm font-semibold text-emerald-600">Mulai cari →</span>
                    </a>
                @endif
            </div>

            <div class="rounded-2xl border border-stone-200/80 bg-white/80 px-5 py-4 text-sm text-stone-600">
                <span class="font-medium text-stone-800">Peran akun:</span>
                <span class="ml-2 inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-800 ring-1 ring-emerald-200/80">
                    {{ auth()->user()->role === 'petani' ? 'Petani' : 'Eksportir' }}
                </span>
            </div>
        </div>
    </div>
</x-app-layout>
