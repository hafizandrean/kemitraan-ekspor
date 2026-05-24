<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\ProductImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductImageService $imageService
    ) {}

    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $category_id = $request->query('category_id');
        $trusted_only = $request->boolean('trusted_only');
        $recommended_only = $request->boolean('recommended_only');
        $min_price = $request->query('min_price');
        $max_price = $request->query('max_price');
        $location = $request->query('location');
        $sort = $request->query('sort', 'terbaru');

        $query = Product::query()->with(['category', 'owner']);

        if ($q !== '') {
            $query->where(function ($qBuilder) use ($q) {
                $qBuilder->where('nama_produk', 'like', '%'.$q.'%')
                    ->orWhere('deskripsi', 'like', '%'.$q.'%');
            });
        }

        if ($category_id) {
            $query->where('kategori_id', $category_id);
        }
        if ($trusted_only) {
            $query->whereHas('owner', fn ($q) => $q->where('is_trusted_farmer', true));
        }
        if ($recommended_only) {
            $query->where('is_recommended', true);
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

        $recommendedProducts = Product::recommended()
            ->with(['category', 'owner'])
            ->limit(6)
            ->get();

        return view('products.index', compact(
            'products',
            'categories',
            'recommendedProducts',
            'q',
            'category_id',
            'trusted_only',
            'recommended_only',
            'min_price',
            'max_price',
            'location',
            'sort'
        ));
    }

    public function show(Product $product)
    {
        $product->load(['owner', 'category', 'images']);

        return view('products.show', compact('product'));
    }

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

    public function create()
    {
        $categories = Category::all();

        return view('petani.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->safe()->except(['gambar']);
        $validated['user_id'] = $request->user()->id;

        $product = Product::create($validated);
        $this->storeUploadedImages($product, $request->file('gambar', []));

        return redirect()
            ->route('petani.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Request $request, Product $product)
    {
        abort_unless($product->user_id === $request->user()->id, 403);

        $product->load('images');
        $categories = Category::all();

        return view('petani.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->safe()->except(['gambar']);
        $product->update($validated);

        if ($request->hasFile('gambar')) {
            $this->storeUploadedImages($product, $request->file('gambar'));
        }

        return redirect()
            ->route('petani.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Request $request, Product $product)
    {
        abort_unless($product->user_id === $request->user()->id, 403);

        $product->load('images');
        foreach ($product->images as $image) {
            $this->imageService->delete($image->path);
        }
        $this->imageService->delete($product->gambar);

        $product->delete();

        return redirect()
            ->route('petani.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * @param  array<int, \Illuminate\Http\UploadedFile>  $files
     */
    private function storeUploadedImages(Product $product, array $files): void
    {
        $sortOrder = (int) $product->images()->max('sort_order');

        foreach ($files as $file) {
            if (! $file) {
                continue;
            }

            try {
                $path = $this->imageService->store($file);
            } catch (\InvalidArgumentException $e) {
                continue;
            }

            $sortOrder++;
            $product->images()->create([
                'path' => $path,
                'sort_order' => $sortOrder,
            ]);

            if (! $product->gambar) {
                $product->update(['gambar' => $path]);
            }
        }
    }
}
