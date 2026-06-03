<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display text-2xl font-semibold text-stone-900">Insight Pasar Ekspor</h2>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
        <div class="rounded-xl border border-emerald-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-emerald-700 font-semibold">Fitur Premium</p>
            <h3 class="text-xl font-bold text-stone-900 mt-2">Harga komoditas ekspor terkini (contoh)</h3>
            <div class="mt-6 grid sm:grid-cols-2 gap-4">
                <div class="rounded-xl border border-stone-200/60 bg-stone-50/50 p-4.5 flex flex-col justify-between hover:bg-white hover:shadow-sm transition">
                    <div>
                        <p class="text-xs text-stone-500 font-semibold uppercase tracking-wider">Kopi Arabica</p>
                        <p class="text-xl font-extrabold text-stone-900 mt-1">Rp 185.000 <span class="text-xs text-stone-400 font-normal">/ kg</span></p>
                    </div>
                    <div class="mt-3 flex items-center gap-1 text-xs text-emerald-600 font-bold">
                        <svg class="h-3.5 w-3.5 text-emerald-600 fill-none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                        </svg>
                        <span>3% vs bulan lalu</span>
                    </div>
                </div>

                <div class="rounded-xl border border-stone-200/60 bg-stone-50/50 p-4.5 flex flex-col justify-between hover:bg-white hover:shadow-sm transition">
                    <div>
                        <p class="text-xs text-stone-500 font-semibold uppercase tracking-wider">Cabe Merah</p>
                        <p class="text-xl font-extrabold text-stone-900 mt-1">Rp 42.000 <span class="text-xs text-stone-400 font-normal">/ kg</span></p>
                    </div>
                    <div class="mt-3 flex items-center gap-1 text-xs text-stone-500 font-semibold">
                        <svg class="h-3.5 w-3.5 text-stone-400 fill-none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14"/>
                        </svg>
                        <span>Stabil</span>
                    </div>
                </div>

                <div class="rounded-xl border border-stone-200/60 bg-stone-50/50 p-4.5 flex flex-col justify-between hover:bg-white hover:shadow-sm transition">
                    <div>
                        <p class="text-xs text-stone-500 font-semibold uppercase tracking-wider">Cengkeh</p>
                        <p class="text-xl font-extrabold text-stone-900 mt-1">Rp 128.000 <span class="text-xs text-stone-400 font-normal">/ kg</span></p>
                    </div>
                    <div class="mt-3 flex items-center gap-1 text-xs text-emerald-600 font-bold">
                        <svg class="h-3.5 w-3.5 text-emerald-600 fill-none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                        </svg>
                        <span>1.5% vs bulan lalu</span>
                    </div>
                </div>

                <div class="rounded-xl border border-stone-200/60 bg-stone-50/50 p-4.5 flex flex-col justify-between hover:bg-white hover:shadow-sm transition">
                    <div>
                        <p class="text-xs text-stone-500 font-semibold uppercase tracking-wider">Kelapa Sawit</p>
                        <p class="text-xl font-extrabold text-stone-900 mt-1">Rp 11.200 <span class="text-xs text-stone-400 font-normal">/ kg</span></p>
                    </div>
                    <div class="mt-3 flex items-center gap-1 text-xs text-rose-600 font-bold">
                        <svg class="h-3.5 w-3.5 text-rose-500 fill-none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                        </svg>
                        <span>0.8% vs bulan lalu</span>
                    </div>
                </div>
            </div>
            <p class="mt-4 text-xs text-stone-500">Data ilustrasi — integrasi API harga riil dapat ditambahkan pada sprint berikutnya.</p>
        </div>
    </div>
</x-app-layout>
