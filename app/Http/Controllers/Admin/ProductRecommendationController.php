<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductRecommendationController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));

        $products = Product::query()
            ->with(['category', 'owner'])
            ->when($q !== '', function ($query) use ($q) {
                $query->where('nama_produk', 'like', '%'.$q.'%');
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $recommendedCount = Product::where('is_recommended', true)->count();

        return view('admin.products.recommendations', compact('products', 'q', 'recommendedCount'));
    }

    public function toggle(Product $product): RedirectResponse
    {
        $isRecommended = ! $product->is_recommended;

        $product->update([
            'is_recommended' => $isRecommended,
            'recommended_at' => $isRecommended ? now() : null,
        ]);

        $message = $isRecommended
            ? 'Produk ditambahkan ke rekomendasi.'
            : 'Produk dihapus dari rekomendasi.';

        return back()->with('success', $message);
    }
}
