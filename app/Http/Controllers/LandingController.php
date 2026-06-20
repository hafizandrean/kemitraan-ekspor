<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function __invoke(): View
    {
        $recommendedProducts = Product::query()
            ->where('is_recommended', true)
            ->with(['category', 'owner'])
            ->latest('recommended_at')
            ->limit(6)
            ->get();

        $categories = Category::withCount('products')->orderBy('name')->get();
        $trustedPetaniCount = User::where('role', 'petani')->where('is_trusted_petani', true)->count();

        return view('landing', compact('recommendedProducts', 'categories', 'trustedPetaniCount'));
    }
}
