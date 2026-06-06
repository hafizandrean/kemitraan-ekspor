@props([
    'required' => true,
    'existingImages' => [],
    'maxFiles' => 5,
])

@php
    $rootId = 'product-images-'.uniqid();
@endphp

<div id="{{ $rootId }}" class="space-y-3">
    <label class="upload-zone flex cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-stone-300 bg-stone-50 px-4 py-6 transition hover:border-exportani-primary hover:bg-exportani-mint/10">
        <svg class="h-10 w-10 text-stone-400" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd"/></svg>
        <p class="mt-2 text-sm font-semibold text-exportani-primary">Klik atau seret foto (maks. {{ $maxFiles }})</p>
        <p class="mt-1 text-xs text-stone-500">JPG, PNG, WEBP, HEIC — otomatis dikonversi ke JPG</p>
        <input
            type="file"
            name="gambar[]"
            class="hidden"
            accept=".jpg,.jpeg,.png,.webp,.heic,.heif,image/*"
            multiple
            data-file-input
            @if($required && empty($existingImages)) required @endif
        >
    </label>

    @if(count($existingImages))
        <div>
            <p class="text-xs font-medium text-stone-600 mb-2">Foto saat ini</p>
            <div class="grid grid-cols-3 gap-2">
                @foreach($existingImages as $img)
                    <img src="{{ Storage::url($img->path) }}" alt="" class="h-24 w-full rounded-lg border border-stone-200 object-cover">
                @endforeach
            </div>
        </div>
    @endif

    <div data-preview-grid class="grid grid-cols-2 sm:grid-cols-3 gap-2 hidden"></div>
    <p data-upload-error class="hidden text-sm font-medium text-red-600"></p>
    <p data-upload-count class="text-xs text-stone-500">0 / {{ $maxFiles }} foto dipilih</p>
</div>

<script>
(function () {
    const root = document.getElementById(@json($rootId));
    if (!root || root.dataset.bound) return;
    root.dataset.bound = '1';

    const maxFiles = {{ (int) $maxFiles }};
    const input = root.querySelector('[data-file-input]');
    const zone = root.querySelector('.upload-zone');
    const grid = root.querySelector('[data-preview-grid]');
    const errorEl = root.querySelector('[data-upload-error]');
    const countEl = root.querySelector('[data-upload-count]');
    const maxBytes = 5 * 1024 * 1024;
    let selectedFiles = [];

    function syncInput() {
        const dt = new DataTransfer();
        selectedFiles.forEach((f) => dt.items.add(f));
        input.files = dt.files;
        countEl.textContent = selectedFiles.length + ' / ' + maxFiles + ' foto dipilih';
    }

    function renderPreviews() {
        grid.innerHTML = '';
        if (!selectedFiles.length) {
            grid.classList.add('hidden');
            syncInput();
            return;
        }
        grid.classList.remove('hidden');
        selectedFiles.forEach((file, index) => {
            const wrap = document.createElement('div');
            wrap.className = 'relative group';
            const img = document.createElement('img');
            img.className = 'h-24 w-full rounded-lg border border-stone-200 object-cover';
            const reader = new FileReader();
            reader.onload = (e) => { img.src = e.target.result; };
            reader.readAsDataURL(file);
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'absolute top-1 right-1 rounded-full bg-red-600 px-1.5 py-0.5 text-xs text-white opacity-90 hover:opacity-100';
            btn.textContent = '×';
            btn.addEventListener('click', () => {
                selectedFiles.splice(index, 1);
                renderPreviews();
            });
            const cap = document.createElement('p');
            cap.className = 'mt-1 truncate text-[10px] text-stone-500';
            cap.textContent = file.name;
            wrap.appendChild(img);
            wrap.appendChild(btn);
            wrap.appendChild(cap);
            grid.appendChild(wrap);
        });
        syncInput();
    }

    function addFiles(fileList) {
        errorEl.classList.add('hidden');
        const incoming = Array.from(fileList || []);
        for (const file of incoming) {
            if (selectedFiles.length >= maxFiles) {
                errorEl.textContent = 'Maksimal ' + maxFiles + ' foto per produk.';
                errorEl.classList.remove('hidden');
                break;
            }
            if (file.size > maxBytes) {
                errorEl.textContent = file.name + ' terlalu besar (maks. 5 MB).';
                errorEl.classList.remove('hidden');
                continue;
            }
            selectedFiles.push(file);
        }
        renderPreviews();
    }

    input.addEventListener('change', () => addFiles(input.files));
    zone.addEventListener('dragover', (e) => { e.preventDefault(); zone.classList.add('border-exportani-primary', 'bg-exportani-mint/10'); });
    zone.addEventListener('dragleave', () => zone.classList.remove('border-exportani-primary', 'bg-exportani-mint/10'));
    zone.addEventListener('drop', (e) => {
        e.preventDefault();
        zone.classList.remove('border-exportani-primary', 'bg-exportani-mint/10');
        addFiles(e.dataTransfer.files);
    });
})();
</script>
