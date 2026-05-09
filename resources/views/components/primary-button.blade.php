<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-5 py-2.5 bg-emerald-600 border border-transparent rounded-lg font-semibold text-sm text-white shadow-sm shadow-emerald-900/20 hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 active:bg-emerald-700 transition ease-out duration-150']) }}>
    {{ $slot }}
</button>
