<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the user's products.
     */
    public function index()
    {
        $products = auth()->user()->products;
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();
        
        // Tambah user_id secara otomatis
        $validated['user_id'] = auth()->id();

        try {
            Product::create($validated);
            return redirect()->route('products.index')
                ->with('success', 'Produk berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan produk. Silakan coba lagi.');
        }
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        // Pastikan user hanya bisa edit produk miliknya
        $this->authorize('update', $product);
        
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        // Pastikan user hanya bisa update produk miliknya
        $this->authorize('update', $product);

        $validated = $request->validated();

        try {
            $product->update($validated);
            return redirect()->route('products.index')
                ->with('success', 'Produk berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui produk. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        // Pastikan user hanya bisa delete produk miliknya
        $this->authorize('delete', $product);

        try {
            $product->delete();
            return redirect()->route('products.index')
                ->with('success', 'Produk berhasil dihapus!');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal menghapus produk. Silakan coba lagi.');
        }
    }

    /**
     * Validate product data (API endpoint untuk validasi real-time)
     */
    public function validateProduct(Request $request)
    {
        $rules = [
            'nama_produk' => [
                'required',
                'string',
                'max:255',
                'min:3',
                'regex:/^[a-zA-Z0-9\s\-()]+$/'
            ],
            'jumlah' => [
                'required',
                'integer',
                'min:1',
                'max:999999'
            ],
            'lokasi' => [
                'required',
                'string',
                'max:255',
                'min:3'
            ],
        ];

        $validated = $request->validate($rules);
        
        return response()->json([
            'valid' => true,
            'message' => 'Data produk valid'
        ]);
    }
}
