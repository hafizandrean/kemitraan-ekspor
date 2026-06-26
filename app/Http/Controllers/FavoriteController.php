<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        $products = $request->user()
            ->favorites()
            ->with(['category', 'owner'])
            ->latest('favorites.created_at')
            ->get();

        return view('favorites.index', compact('products'));
    }

    public function toggle(Request $request, Product $product)
    {
        $user = $request->user();
        $exists = $user->favorites()->where('product_id', $product->id)->exists();

        if ($exists) {
            $user->favorites()->detach($product->id);
            return back()->with('success', 'Produk dihapus dari favorit.');
        }

        $user->favorites()->attach($product->id);
        return back()->with('success', 'Produk ditambahkan ke favorit.');
    }
}

