<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-5 py-2.5 bg-exportani-primary border border-transparent rounded-lg font-semibold text-sm text-white shadow-sm shadow-exportani-dark/10 hover:bg-exportani-dark focus:outline-none focus:ring-2 focus:ring-exportani-primary focus:ring-offset-2 active:bg-exportani-dark transition ease-out duration-150']) }}>
    {{ $slot }}
</button>
