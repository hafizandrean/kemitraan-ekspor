<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display text-2xl font-semibold text-stone-900">Verifikasi Premium</h2>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto">
        @if(session('success'))
            <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">{{ session('success') }}</div>
        @endif

        <div class="rounded-xl border border-stone-200 bg-white divide-y divide-stone-100 shadow-sm">
            @forelse($pending as $user)
                <div class="p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <p class="font-semibold text-stone-900">{{ $user->name }}</p>
                        <p class="text-sm text-stone-500">{{ $user->email }} · {{ $user->phone }}</p>
                        @if($user->verification_document_path)
                            <a href="{{ Storage::url($user->verification_document_path) }}" target="_blank" class="text-sm text-emerald-700 font-medium mt-1 inline-block">Lihat dokumen →</a>
                        @endif
                    </div>
                    <div class="flex gap-2">
                        <form method="POST" action="{{ route('admin.premium-verifications.approve', $user) }}">
                            @csrf
                            <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Setujui Premium</button>
                        </form>
                        <form method="POST" action="{{ route('admin.premium-verifications.reject', $user) }}">
                            @csrf
                            <button type="submit" class="rounded-lg border border-stone-300 px-4 py-2 text-sm font-medium text-stone-700 hover:bg-stone-50">Tolak</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="p-8 text-center text-stone-500">Tidak ada pengajuan verifikasi pending.</p>
            @endforelse
        </div>
        {{ $pending->links() }}
    </div>
</x-app-layout>
