<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function catalog(Request $request)
    {
        $category = $request->query('category');

        $featured = Product::with('images')->orderByDesc('price')->take(3)->get();

        $products = Product::with('images')->latest()
            ->when($category, fn($q) => $q->where('category', $category))
            ->get();

        $categoryCounts = Product::selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category');

        $cartCount = auth()->check() && auth()->user()->isCustomer()
            ? auth()->user()->cart()->count()
            : 0;

        return view('catalog', compact('featured', 'products', 'categoryCounts', 'cartCount', 'category'));
    }

    public function index()
    {
        $featured = Product::with('images')->orderByDesc('price')->take(3)->get();
        $products = Product::with('images')->latest()->take(5)->get();
        $totalCount = Product::count();

        return view('products.index', compact('featured', 'products', 'totalCount'));
    }

    public function all(Request $request)
    {
        $category = $request->query('category');

        $products = Product::with('images')->latest()
            ->when($category, fn($q) => $q->where('category', $category))
            ->get();

        $categoryCounts = Product::selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category');

        return view('products.all', compact('products', 'category', 'categoryCounts'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $data['is_available'] = $request->boolean('is_available');
        unset($data['images']);

        $product = Product::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $product->images()->create([
                    'path'       => $file->store('products', 'public'),
                    'image_mime' => $file->getMimeType(),
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product added!');
    }

    public function edit(Product $product)
    {
        $product->load('images');
        return view('products.edit', compact('product'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $data['is_available'] = $request->boolean('is_available');
        unset($data['images']);

        $product->update($data);

        if ($request->hasFile('images')) {
            $existingCount = $product->images()->count();
            foreach ($request->file('images') as $index => $file) {
                $product->images()->create([
                    'path'       => $file->store('products', 'public'),
                    'image_mime' => $file->getMimeType(),
                    'sort_order' => $existingCount + $index,
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product updated!');
    }

    public function serveImage(Product $product)
    {
        $image = $product->primaryImage();

        if (! $image) {
            abort(404);
        }

        return Storage::disk('public')->response($image->path, null, [
            'Content-Type'  => $image->image_mime,
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }

    public function serveProductImage(Product $product, ProductImage $image)
    {
        if ($image->product_id !== $product->id) {
            abort(404);
        }

        return Storage::disk('public')->response($image->path, null, [
            'Content-Type'  => $image->image_mime,
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }

    public function removeImage(Product $product, ProductImage $image)
    {
        if ($image->product_id !== $product->id) {
            abort(403);
        }

        $image->delete();

        if (request()->expectsJson()) {
            return response()->json(['ok' => true]);
        }
        return back()->with('success', 'Image removed.');
    }

    public function gallery(Product $product)
    {
        $product->load('images');
        return view('products.gallery', compact('product'));
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted!');
    }
}
