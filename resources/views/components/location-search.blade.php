@props([
    'name' => 'lokasi',
    'value' => '',
    'locations' => [],
])

@php
    $rootId = 'location-search-'.uniqid();
@endphp

<div id="{{ $rootId }}" class="relative" data-location-search>
    <x-input-label :for="$rootId.'-input'" value="Lokasi (Kabupaten/Kota)" />
    <input
        id="{{ $rootId }}-input"
        type="text"
        role="combobox"
        autocomplete="off"
        placeholder="Ketik untuk mencari kota/kabupaten..."
        value="{{ $value }}"
        data-location-input
        class="mt-1.5 block w-full rounded-lg border-stone-300 shadow-sm focus:border-exportani-primary focus:ring-exportani-primary"
        required
    >
    <input type="hidden" name="{{ $name }}" value="{{ $value }}" data-location-hidden>
    <ul data-location-dropdown class="absolute z-20 mt-1 max-h-52 w-full overflow-auto rounded-lg border border-stone-200 bg-white py-1 shadow-lg hidden"></ul>
    <p class="mt-1 text-xs text-stone-500">Pilih dari daftar agar lokasi konsisten untuk filter eksportir.</p>
</div>

<script>
(function () {
    const root = document.getElementById(@json($rootId));
    if (!root || root.dataset.bound) return;
    root.dataset.bound = '1';

    const locations = @json($locations);
    const visible = root.querySelector('[data-location-input]');
    const hidden = root.querySelector('[data-location-hidden]');
    const dropdown = root.querySelector('[data-location-dropdown]');

    function render(query) {
        const q = query.trim().toLowerCase();
        const matches = locations.filter((loc) => loc.toLowerCase().includes(q)).slice(0, 12);
        dropdown.innerHTML = '';
        if (!matches.length) {
            dropdown.classList.add('hidden');
            return;
        }
        matches.forEach((loc) => {
            const li = document.createElement('li');
            li.className = 'cursor-pointer px-3 py-2 text-sm text-stone-700 hover:bg-exportani-mint/10 hover:text-exportani-primary';
            li.textContent = loc;
            li.addEventListener('mousedown', (e) => {
                e.preventDefault();
                visible.value = loc;
                hidden.value = loc;
                dropdown.classList.add('hidden');
            });
            dropdown.appendChild(li);
        });
        dropdown.classList.remove('hidden');
    }

    visible.addEventListener('input', () => {
        hidden.value = visible.value;
        render(visible.value);
    });
    visible.addEventListener('focus', () => render(visible.value));
    visible.addEventListener('blur', () => setTimeout(() => dropdown.classList.add('hidden'), 150));
})();
</script>
