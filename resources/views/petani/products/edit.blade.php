<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-display text-2xl font-semibold text-exportani-text tracking-tight">{{ __('Edit Produk') }}</h2>
            <p class="mt-1 text-sm text-exportani-secondaryText">Perbarui data komoditas kamu.</p>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <div class="rounded-2xl border border-exportani-border bg-white p-6 sm:p-8 shadow-sm">
                @if ($errors->any())
                    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-905">
                        <p class="font-semibold">Periksa data berikut:</p>
                        <ul class="mt-2 list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('petani.products.update', $product) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    @include('petani.products._form', ['product' => $product])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
