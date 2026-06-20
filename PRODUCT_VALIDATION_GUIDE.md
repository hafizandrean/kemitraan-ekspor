# Panduan Validasi Data Produk

## Fitur yang Telah Ditambahkan

### 1. **Form Request Classes** (Validasi Server-Side)

#### StoreProductRequest
Digunakan untuk validasi saat **membuat produk baru**:
- `nama_produk`: Required, min 3, max 255 karakter, hanya alfanumerik dan tanda hubung
- `jumlah`: Required, integer, min 1, max 999.999
- `lokasi`: Required, min 3, max 255 karakter

```php
// Penggunaan di Controller
public function store(StoreProductRequest $request)
{
    // Data sudah validated otomatis
    $validated = $request->validated();
    Product::create($validated);
}
```

#### UpdateProductRequest
Digunakan untuk validasi saat **mengupdate produk**:
- Field menggunakan `sometimes` (validasi hanya field yang dikirim)
- Hanya pemilik produk yang bisa update

```php
public function update(UpdateProductRequest $request, Product $product)
{
    // Hanya pemilik produk yang bisa update
    $this->authorize('update', $product);
    $validated = $request->validated();
    $product->update($validated);
}
```

### 2. **ProductController** (Business Logic)

Routes yang tersedia:
```
GET    /products              - Tampilkan semua produk user
GET    /products/create       - Form tambah produk
POST   /products              - Simpan produk baru (dengan validasi)
GET    /products/{id}/edit    - Form edit produk
PATCH  /products/{id}         - Update produk (dengan validasi)
DELETE /products/{id}         - Hapus produk
POST   /products/validate     - API untuk validasi real-time
```

### 3. **ProductPolicy** (Authorization)

Kontrol akses per operasi:
- `view()` - Semua user bisa lihat produk
- `create()` - Semua user terautentikasi bisa buat produk
- `update()` - Hanya pemilik produk
- `delete()` - Hanya pemilik produk

### 4. **Model Validation** (Reusable Rules)

Product model menyimpan rules untuk reusabilitas:
```php
Product::$rules;       // Validation rules
Product::$messages;    // Custom messages
```

### 5. **Relationships**

**Product Model:**
```php
$product->user();           // Relasi ke user pemilik
$product->partnerships();   // Relasi ke partnerships
```

**User Model:**
```php
$user->products();          // Semua produk user
$user->partnerships();      // Semua partnership user
```

---

## Contoh Penggunaan

### Create Produk (Blade View)
```blade
<form action="{{ route('products.store') }}" method="POST">
    @csrf
    
    <div class="form-group">
        <label for="nama_produk">Nama Produk</label>
        <input type="text" 
               id="nama_produk" 
               name="nama_produk" 
               value="{{ old('nama_produk') }}"
               class="form-control @error('nama_produk') is-invalid @enderror"
               placeholder="Misal: Beras Premium">
        @error('nama_produk')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="jumlah">Jumlah (kg)</label>
        <input type="number" 
               id="jumlah" 
               name="jumlah" 
               value="{{ old('jumlah') }}"
               class="form-control @error('jumlah') is-invalid @enderror"
               min="1"
               max="999999">
        @error('jumlah')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="lokasi">Lokasi</label>
        <input type="text" 
               id="lokasi" 
               name="lokasi" 
               value="{{ old('lokasi') }}"
               class="form-control @error('lokasi') is-invalid @enderror"
               placeholder="Misal: Karawang, Jawa Barat">
        @error('lokasi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Simpan Produk</button>
</form>
```

### Validasi Real-Time (JavaScript)
```javascript
// POST /products/validate
async function validateProduct(data) {
    try {
        const response = await fetch('/products/validate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        return result.valid;
    } catch (error) {
        console.error('Validation error:', error);
    }
}

// Gunakan saat user selesai input
document.getElementById('nama_produk').addEventListener('blur', async (e) => {
    const isValid = await validateProduct({
        nama_produk: e.target.value,
        jumlah: document.getElementById('jumlah').value,
        lokasi: document.getElementById('lokasi').value
    });
    
    if (isValid) {
        e.target.classList.remove('is-invalid');
        e.target.classList.add('is-valid');
    }
});
```

### Get User Products (PHP)
```php
// Di Controller
$products = auth()->user()->products;

// Filter dengan kondisi
$activeProducts = auth()->user()->products()
    ->where('jumlah', '>', 0)
    ->latest()
    ->get();
```

---

## Error Handling

Semua error message sudah dalam Bahasa Indonesia:

| Field | Error Message |
|-------|---------------|
| `nama_produk.required` | Nama produk harus diisi |
| `nama_produk.min` | Nama produk minimal 3 karakter |
| `nama_produk.regex` | Nama produk hanya boleh mengandung huruf, angka, spasi, dan tanda hubung |
| `jumlah.required` | Jumlah produk harus diisi |
| `jumlah.integer` | Jumlah produk harus berupa angka |
| `jumlah.min` | Jumlah produk minimal 1 |
| `lokasi.required` | Lokasi produk harus diisi |
| `lokasi.min` | Lokasi minimal 3 karakter |

---

## Best Practices

1. **Selalu gunakan Form Request** untuk validasi endpoint public
2. **Combine multiple middlewares** untuk autentikasi:
   ```php
   Route::middleware(['auth', 'verified'])->group(function () {
       Route::resource('products', ProductController::class);
   });
   ```

3. **Gunakan Authorization Policy** sebelum update/delete:
   ```php
   $this->authorize('update', $product);
   ```

4. **Validasi real-time di frontend** untuk better UX
5. **Log perubahan produk** untuk audit trail (optional future feature)

---

## Testing Validasi

```php
// tests/Feature/ProductValidationTest.php
public function test_store_product_with_valid_data()
{
    $response = $this->post('/products', [
        'nama_produk' => 'Beras Premium',
        'jumlah' => 100,
        'lokasi' => 'Karawang'
    ]);
    
    $response->assertRedirect('/products');
    $this->assertDatabaseHas('products', [
        'nama_produk' => 'Beras Premium'
    ]);
}

public function test_store_product_validation_fails()
{
    $response = $this->post('/products', [
        'nama_produk' => 'ab', // too short
        'jumlah' => -5,        // invalid
        'lokasi' => 'x'        // too short
    ]);
    
    $response->assertSessionHasErrors(['nama_produk', 'jumlah', 'lokasi']);
}
```

---

Dokumentasi lengkap sudah siap digunakan! 🎉
