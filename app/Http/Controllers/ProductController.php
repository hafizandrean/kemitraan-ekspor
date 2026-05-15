<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Eksportir: browse + search
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $products = Product::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where('nama_produk', 'like', '%'.$q.'%');
            })
            ->latest()
            ->get();

        return view('products.index', [
            'products' => $products,
            'q' => $q,
        ]);
    }

    // Petani: form edit produk
    public function edit(Request $request, Product $product)
    {
        abort_unless($product->user_id === $request->user()->id, 403);

        return view('petani.products.edit', [
            'product' => $product,
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return redirect()
            ->route('petani.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Request $request, Product $product)
    {
        abort_unless($product->user_id === $request->user()->id, 403);

        $product->delete();

        return redirect()
            ->route('petani.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    // Petani: list produk miliknya
    public function myIndex(Request $request)
    {
        $products = Product::query()
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return view('petani.products.index', [
            'products' => $products,
        ]);
    }

    // Petani: form tambah produk
    public function create()
    {
        return view('petani.products.create');
    }

    // Petani: simpan produk
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        Product::create([
            'nama_produk' => $validated['nama_produk'],
            'jumlah' => $validated['jumlah'],
            'lokasi' => $validated['lokasi'],
            'user_id' => $request->user()->id,
        ]);

        return redirect()
            ->route('petani.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }
}
