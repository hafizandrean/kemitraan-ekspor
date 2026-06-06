@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'rounded-xl border border-exportani-mint/30 bg-exportani-mint/10 px-4 py-3 font-medium text-sm text-exportani-accent shadow-sm']) }}>
        {{ $status }}
    </div>
@endif
