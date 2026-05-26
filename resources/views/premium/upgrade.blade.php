<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display text-2xl font-semibold text-stone-900">Upgrade Premium</h2>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto space-y-6">
        @if(session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-900">{{ session('error') }}</div>
        @endif

        <div class="rounded-xl border {{ $isPremium ? 'border-emerald-300 bg-emerald-50' : 'border-stone-200 bg-white' }} p-6 shadow-sm">
            <p class="text-sm text-stone-600">Status akun</p>
            <p class="text-2xl font-bold {{ $isPremium ? 'text-emerald-700' : 'text-stone-800' }}">
                {{ $isPremium ? 'Premium Aktif' : 'Free User' }}
            </p>
            @if($user->premium_expires_at)
                <p class="text-sm text-stone-600 mt-1">Berlaku hingga {{ $user->premium_expires_at->format('d M Y') }}</p>
            @endif
            @if($trustedDiscount)
                <p class="mt-3 text-sm font-medium text-amber-800">🎉 Trusted Farmer: Anda memenuhi syarat diskon upgrade Premium!</p>
            @endif
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <div class="rounded-xl border border-stone-200 p-5">
                <h3 class="font-semibold text-stone-800">Free</h3>
                <ul class="mt-3 space-y-2 text-sm text-stone-600 list-disc pl-5">
                    <li>Maks. {{ config('permissions.limits.free_farmer_max_products') }} produk</li>
                    <li>Lokasi level kabupaten</li>
                    <li>Kontak eksportir terkunci</li>
                </ul>
            </div>
            <div class="rounded-xl border-2 border-emerald-500 p-5 bg-emerald-50/50">
                <h3 class="font-semibold text-emerald-800">Premium ✓</h3>
                <ul class="mt-3 space-y-2 text-sm text-emerald-900/90 list-disc pl-5">
                    <li>Verified badge & unlimited upload</li>
                    <li>Priority listing di pencarian</li>
                    <li>Akses kontak eksportir langsung</li>
                    <li>Insight pasar komoditas ekspor</li>
                </ul>
            </div>
        </div>

        @if($user->role === 'farmer' && ! $isPremium)
            <div class="rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
                <h3 class="font-semibold text-stone-900">Verifikasi dokumen (KTP / Sertifikat lahan)</h3>
                <p class="text-sm text-stone-600 mt-1">Admin Exportani akan meninjau sebelum aktivasi Premium.</p>
                <form method="POST" action="{{ route('premium.verify') }}" enctype="multipart/form-data" class="mt-4 space-y-4">
                    @csrf
                    <div>
                        <label class="text-sm font-medium">Nomor telepon / WhatsApp</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required class="mt-1 w-full rounded-lg border-stone-300">
                    </div>
                    <div>
                        <label class="text-sm font-medium">Upload dokumen (PDF/JPG, maks 5MB)</label>
                        <input type="file" name="verification_document" accept=".pdf,.jpg,.jpeg,.png" required class="mt-1 w-full text-sm">
                    </div>
                    <p class="text-xs text-stone-500">Status verifikasi: <strong>{{ ucfirst($user->verification_status) }}</strong></p>
                    <x-primary-button type="submit">Ajukan Verifikasi Premium</x-primary-button>
                </form>
            </div>
        @endif

        @if($isPremium)
            <a href="{{ route('premium.insight') }}" class="inline-flex rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Buka Insight Pasar →</a>
        @endif
    </div>
</x-app-layout>
