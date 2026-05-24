<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-display text-2xl font-semibold text-stone-900 tracking-tight">Kategori Produk</h2>
            <p class="mt-1 text-sm text-stone-600">Kelola kategori komoditas untuk produk petani.</p>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto space-y-6">
        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-900">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-900">{{ session('error') }}</div>
        @endif

        <div class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
            <h3 class="font-semibold text-stone-900 mb-4">Tambah Kategori</h3>
            <form method="POST" action="{{ route('admin.categories.store') }}" class="flex flex-col sm:flex-row gap-3">
                @csrf
                <div class="flex-1">
                    <x-text-input name="name" class="w-full" placeholder="Nama kategori baru" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <x-primary-button type="submit">Tambah</x-primary-button>
            </form>
        </div>

        <div class="rounded-2xl border border-stone-200 bg-white overflow-hidden shadow-sm">
            <table class="min-w-full divide-y divide-stone-200">
                <thead class="bg-stone-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-stone-500">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-stone-500">Slug</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-stone-500">Produk</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold uppercase text-stone-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse ($categories as $category)
                        <tr>
                            <td class="px-6 py-4">
                                <form id="cat-{{ $category->id }}" method="POST" action="{{ route('admin.categories.update', $category) }}">
                                    @csrf
                                    @method('PATCH')
                                    <x-text-input name="name" value="{{ $category->name }}" class="w-full max-w-xs" required />
                                </form>
                            </td>
                            <td class="px-6 py-4 text-sm text-stone-500">{{ $category->slug }}</td>
                            <td class="px-6 py-4 text-sm text-stone-700">{{ $category->products_count }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button form="cat-{{ $category->id }}" type="submit" class="text-sm font-medium text-emerald-700 hover:text-emerald-800">Simpan</button>
                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="inline" onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-stone-500">Belum ada kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
