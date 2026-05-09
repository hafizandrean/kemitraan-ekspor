@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-stone-300 bg-white text-stone-900 placeholder:text-stone-400 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm']) !!}>
