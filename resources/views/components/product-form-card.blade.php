@props(['title', 'icon' => '📋'])

<div {{ $attributes->merge(['class' => 'rounded-xl border border-stone-200 bg-white p-5 shadow-sm']) }}>
    <div class="mb-4 flex items-center gap-2 border-b border-stone-100 pb-3">
        <span class="text-lg" aria-hidden="true">{{ $icon }}</span>
        <h3 class="font-semibold text-stone-900">{{ $title }}</h3>
    </div>
    {{ $slot }}
</div>
