<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Status Langganan</h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Informasi tier akun dan masa berlaku Premium.</p>
    </header>

    <div class="mt-6 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Tier saat ini</p>
                <p class="text-xl font-bold {{ $user->isPremium() ? 'text-emerald-600' : 'text-gray-800' }}">
                    {{ $user->premiumBadgeLabel() }}
                    @if($user->is_trusted_farmer)
                        <span class="ml-2 text-xs rounded-full bg-emerald-100 text-emerald-800 px-2 py-0.5">Trusted</span>
                    @endif
                </p>
            </div>
            <a href="{{ route('premium.upgrade') }}" class="text-sm font-semibold text-emerald-600 hover:underline">
                {{ $user->isPremium() ? 'Kelola' : 'Upgrade' }}
            </a>
        </div>
        @if($user->premium_expires_at)
            <p class="mt-2 text-sm text-gray-600">Premium berlaku hingga <strong>{{ $user->premium_expires_at->format('d F Y') }}</strong></p>
        @endif
        @if($user->role === 'farmer' && $user->verification_status !== 'none')
            <p class="mt-2 text-sm text-gray-600">Verifikasi dokumen: <strong>{{ ucfirst($user->verification_status) }}</strong></p>
        @endif
    </div>
</section>
