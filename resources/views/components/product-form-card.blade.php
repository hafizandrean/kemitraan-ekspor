@props(['title', 'icon' => '📋'])

<div {{ $attributes->merge(['class' => 'rounded-2xl border border-exportani-border bg-white p-6 shadow-sm']) }}>
    <div class="mb-4 flex items-center gap-2 border-b border-exportani-border/50 pb-3">
        <span class="text-lg" aria-hidden="true">{{ $icon }}</span>
        <h3 class="font-semibold text-exportani-text font-display">{{ $title }}</h3>
    </div>
    {{ $slot }}
</div>
