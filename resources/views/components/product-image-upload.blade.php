@props([
    'required' => false,
    'existingUrl' => null,
])

@php
    $uploadId = 'product-image-upload-'.uniqid();
@endphp

<div class="space-y-2" id="{{ $uploadId }}">
    <label
        for="gambar"
        class="upload-zone mt-1.5 flex cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-stone-300 bg-stone-50 px-6 py-8 transition-colors hover:border-exportani-primary hover:bg-exportani-mint/10"
    >
        <div class="upload-placeholder text-center {{ $existingUrl ? 'hidden' : '' }}">
            <svg class="mx-auto h-12 w-12 text-stone-400" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
            </svg>
            <p class="mt-3 text-sm font-semibold text-exportani-primary">Klik di sini untuk pilih foto dari folder</p>
            <p class="mt-1 text-xs text-stone-500">JPG, PNG, WEBP — maks. 5 MB</p>
            <p class="mt-1 text-xs text-amber-700">Foto iPhone (HEIC)? Ekspor/simpan sebagai JPG dulu.</p>
        </div>
        <div class="upload-preview text-center {{ $existingUrl ? '' : 'hidden' }}">
            <img src="{{ $existingUrl ?? '' }}" alt="Pratinjau" class="upload-preview-img mx-auto max-h-48 rounded-lg border border-stone-200 object-contain">
            <p class="upload-filename mt-3 text-sm font-medium text-stone-700">{{ $existingUrl ? 'Foto saat ini — klik untuk ganti' : '' }}</p>
        </div>

        <input
            id="gambar"
            name="gambar"
            type="file"
            class="hidden"
            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
            @if($required) required @endif
        >
    </label>

    <p class="upload-error hidden text-sm font-medium text-red-600"></p>
</div>

<script>
(function () {
    const root = document.getElementById(@json($uploadId));
    if (!root || root.dataset.bound === '1') return;
    root.dataset.bound = '1';

    const input = root.querySelector('#gambar');
    const zone = root.querySelector('.upload-zone');
    const placeholder = root.querySelector('.upload-placeholder');
    const preview = root.querySelector('.upload-preview');
    const previewImg = root.querySelector('.upload-preview-img');
    const fileName = root.querySelector('.upload-filename');
    const errorEl = root.querySelector('.upload-error');
    const maxBytes = 5 * 1024 * 1024;
    const allowed = ['image/jpeg', 'image/png', 'image/webp'];

    function showError(message) {
        errorEl.textContent = message;
        errorEl.classList.remove('hidden');
        input.value = '';
    }

    function clearError() {
        errorEl.textContent = '';
        errorEl.classList.add('hidden');
    }

    function showPreview(file) {
        clearError();
        fileName.textContent = file.name + ' (' + (file.size / 1024 / 1024).toFixed(1) + ' MB)';
        placeholder.classList.add('hidden');
        preview.classList.remove('hidden');

        const reader = new FileReader();
        reader.onload = (e) => {
            previewImg.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }

    function handleFile(file) {
        if (!file) return;

        if (!allowed.includes(file.type)) {
            showError('Format tidak didukung. Gunakan JPG, PNG, atau WEBP (bukan HEIC).');
            return;
        }

        if (file.size > maxBytes) {
            showError('Ukuran file terlalu besar. Maksimal 5 MB.');
            return;
        }

        showPreview(file);
    }

    input.addEventListener('change', () => handleFile(input.files[0]));

    zone.addEventListener('dragover', (e) => {
        e.preventDefault();
        zone.classList.add('border-exportani-primary', 'bg-exportani-mint/10');
    });

    zone.addEventListener('dragleave', () => {
        zone.classList.remove('border-exportani-primary', 'bg-exportani-mint/10');
    });

    zone.addEventListener('drop', (e) => {
        e.preventDefault();
        zone.classList.remove('border-exportani-primary', 'bg-exportani-mint/10');
        const file = e.dataTransfer?.files?.[0];
        if (!file) return;

        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        input.files = dataTransfer.files;
        handleFile(file);
    });
})();
</script>
