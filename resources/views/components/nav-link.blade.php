@props(['active', 'darkNav' => false])

@php
if ($darkNav ?? false) {
    $classes = ($active ?? false)
        ? 'inline-flex items-center px-2.5 py-1.5 rounded-lg text-xs font-semibold text-white bg-white/15 ring-1 ring-white/20'
        : 'inline-flex items-center px-2.5 py-1.5 rounded-lg text-xs font-medium text-emerald-100/90 hover:text-white hover:bg-white/10 transition duration-150 ease-out';
} else {
    $classes = ($active ?? false)
        ? 'inline-flex items-center px-1 pt-1 border-b-2 border-emerald-500 text-sm font-semibold leading-5 text-emerald-800 focus:outline-none transition duration-150 ease-in-out'
        : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-stone-500 hover:text-stone-800 hover:border-stone-300 focus:outline-none transition duration-150 ease-in-out';
}
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
