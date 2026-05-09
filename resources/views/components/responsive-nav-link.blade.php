@props(['active', 'darkNav' => false])

@php
if ($darkNav ?? false) {
    $classes = ($active ?? false)
        ? 'block w-full ps-3 pe-4 py-2.5 border-l-4 border-emerald-300 text-start text-base font-semibold text-white bg-white/10 focus:outline-none transition duration-150 ease-in-out'
        : 'block w-full ps-3 pe-4 py-2.5 border-l-4 border-transparent text-start text-base font-medium text-emerald-100/90 hover:text-white hover:bg-white/5 hover:border-emerald-500/40 focus:outline-none transition duration-150 ease-in-out';
} else {
    $classes = ($active ?? false)
        ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-emerald-500 text-start text-base font-semibold text-emerald-800 bg-emerald-50 focus:outline-none transition duration-150 ease-in-out'
        : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-stone-600 hover:text-stone-900 hover:bg-stone-50 hover:border-stone-300 focus:outline-none transition duration-150 ease-in-out';
}
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
