<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Permintaan Masuk') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <div class="space-y-4">
                    @forelse($requests as $r)
                        <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $r->product->nama_produk }}
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                        Eksportir: <span class="font-medium">{{ $r->eksportir->name }}</span>
                                    </div>
                                    <div class="text-sm mt-2">
                                        Status:
                                        @if($r->status === 'pending')
                                            <span class="font-semibold text-orange-600">pending</span>
                                        @elseif($r->status === 'accepted')
                                            <span class="font-semibold text-green-600">accepted</span>
                                        @else
                                            <span class="font-semibold text-red-600">rejected</span>
                                        @endif
                                    </div>
                                </div>

                                @if ($r->status === 'pending')
                                    <div class="flex items-center gap-2">
                                        <form method="POST" action="{{ route('requests.accept', $r->id) }}">
                                            @csrf
                                            <x-primary-button>Accept</x-primary-button>
                                        </form>
                                        <form method="POST" action="{{ route('requests.reject', $r->id) }}">
                                            @csrf
                                            <x-danger-button>Reject</x-danger-button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-gray-600 dark:text-gray-300">
                            Belum ada permintaan kerja sama masuk.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>