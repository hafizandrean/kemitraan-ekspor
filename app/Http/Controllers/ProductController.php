<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Eksportir: browse + search + filter + sort
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $category_id = $request->query('category_id');
        $min_price = $request->query('min_price');
        $max_price = $request->query('max_price');
        $location = $request->query('location');
        $sort = $request->query('sort', 'terbaru');

        $query = Product::query()->with('category');

        if ($q !== '') {
            $query->where(function ($qBuilder) use ($q) {
                $qBuilder->where('nama_produk', 'like', '%'.$q.'%')
                         ->orWhere('deskripsi', 'like', '%'.$q.'%');
            });
        }

        if ($category_id) {
            $query->where('kategori_id', $category_id);
        }
        if ($min_price) {
            $query->where('harga', '>=', $min_price);
        }
        if ($max_price) {
            $query->where('harga', '<=', $max_price);
        }
        if ($location) {
            $query->where('lokasi', 'like', '%'.$location.'%');
        }

        if ($sort === 'termurah') {
            $query->orderBy('harga', 'asc');
        } elseif ($sort === 'termahal') {
            $query->orderBy('harga', 'desc');
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::all();

        return view('products.index', compact(
            'products', 'categories', 'q', 'category_id', 'min_price', 'max_price', 'location', 'sort'
        ));
    }

    // Eksportir: detail produk
    public function show(Product $product)
    {
        $product->load(['owner', 'category']);
        return view('products.show', compact('product'));
    }

    // Petani: list produk miliknya
    public function myIndex(Request $request)
    {
        $products = Product::query()
            ->with('category')
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
        $categories = Category::all();
        return view('petani.products.create', compact('categories'));
    }

    // Petani: simpan produk
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();
        
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        $validated['user_id'] = $request->user()->id;

        Product::create($validated);

        return redirect()
            ->route('petani.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    // Petani: form edit produk
    public function edit(Request $request, Product $product)
    {
        abort_unless($product->user_id === $request->user()->id, 403);

        $categories = Category::all();
        return view('petani.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();
        
        if ($request->hasFile('gambar')) {
            if ($product->gambar) {
                Storage::disk('public')->delete($product->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()
            ->route('petani.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Request $request, Product $product)
    {
        abort_unless($product->user_id === $request->user()->id, 403);

        if ($product->gambar) {
            Storage::disk('public')->delete($product->gambar);
        }

        $product->delete();

        return redirect()
            ->route('petani.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
