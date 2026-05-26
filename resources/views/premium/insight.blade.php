<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display text-2xl font-semibold text-stone-900">Insight Pasar Ekspor</h2>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
        <div class="rounded-xl border border-emerald-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-emerald-700 font-semibold">Fitur Premium</p>
            <h3 class="text-xl font-bold text-stone-900 mt-2">Harga komoditas ekspor terkini (contoh)</h3>
            <div class="mt-6 grid sm:grid-cols-2 gap-4">
                <div class="rounded-lg bg-stone-50 p-4"><p class="text-sm text-stone-500">Kopi Arabica</p><p class="text-lg font-bold text-emerald-700">Rp 185.000/kg</p><p class="text-xs text-stone-400">↑ 3% vs bulan lalu</p></div>
                <div class="rounded-lg bg-stone-50 p-4"><p class="text-sm text-stone-500">Cabe Merah</p><p class="text-lg font-bold text-emerald-700">Rp 42.000/kg</p><p class="text-xs text-stone-400">→ stabil</p></div>
                <div class="rounded-lg bg-stone-50 p-4"><p class="text-sm text-stone-500">Cengkeh</p><p class="text-lg font-bold text-emerald-700">Rp 128.000/kg</p><p class="text-xs text-stone-400">↑ 1.5%</p></div>
                <div class="rounded-lg bg-stone-50 p-4"><p class="text-sm text-stone-500">Kelapa Sawit</p><p class="text-lg font-bold text-emerald-700">Rp 11.200/kg</p><p class="text-xs text-stone-400">↓ 0.8%</p></div>
            </div>
            <p class="mt-4 text-xs text-stone-500">Data ilustrasi — integrasi API harga riil dapat ditambahkan pada sprint berikutnya.</p>
        </div>
    </div>
</x-app-layout>
