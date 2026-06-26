@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-stone-300 bg-white text-stone-900 placeholder:text-stone-400 focus:border-exportani-primary focus:ring-exportani-primary rounded-lg shadow-sm']) !!}>
